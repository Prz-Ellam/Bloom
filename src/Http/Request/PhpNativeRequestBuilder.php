<?php

namespace Bloom\Http\Request;

use Bloom\Http\HttpMethod;
use Bloom\Http\UploadedFile;

/**
 * Concrete implementation of the RequestBuilder for the PHP Development Server
 */
class PhpNativeRequestBuilder extends RequestBuilder {
    /**
     * Construct the uri of the HTTP Request
     *
     * @return void
     */
    public function buildUri(): self {
        $this->request->setUri(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
        return $this;
    }

    /**
     * Construct the method of the HTTP Request
     *
     * @return void
     */
    public function buildMethod(): self {
        $this->request->setMethod(HttpMethod::from($_SERVER["REQUEST_METHOD"]));
        return $this;
    }

    public function buildHeaders(): self {
        $this->request->setHeaders(getallheaders());
        return $this;
    }

    public function buildQuery(): self {
        $this->request->setQuery($_GET);
        return $this;
    }

    public function buildBody(): self {
        $this->request->setBody($this->getPostData());
        return $this;
    }

    public function buildParams(): self {
        return $this;
    }

    public function buildFiles(): self {
        $this->request->setFiles($this->createUploadedFiles($_FILES));
        return $this;
    }

    public function buildProtocol(): self {
        $_SERVER["SERVER_PROTOCOL"];
        return $this;
    }

    private function getPostData(): array {
        
        $requestsTable = [
            "GET_URL" => [ "GET", "application/x-www-form-urlencoded" ],
            "POST_URL" => [ "POST", "application/x-www-form-urlencoded" ],
            "PUT_URL" => [ "PUT", "application/x-www-form-urlencoded" ],
            "PATCH_URL" => [ "PATCH", "application/x-www-form-urlencoded" ],
            "DELETE_URL" => [ "DELETE", "application/x-www-form-urlencoded" ],

            "GET_JSON" => [ "GET", "application/json" ],
            "POST_JSON" => [ "POST", "application/json" ],
            "PUT_JSON" => [ "PUT", "application/json" ],
            "PATCH_JSON" => [ "PATCH", "application/json" ],
            "DELETE_JSON" => [ "DELETE", "application/json" ],

            "GET_MULTIPART" => [ "GET", "multipart/form-data" ],
            "POST_MULTIPART" => [ "POST", "multipart/form-data" ],
            "PUT_MULTIPART" => [ "PUT", "multipart/form-data" ],
            "PATCH_MULTIPART" => [ "PATCH", "multipart/form-data" ],
            "DELETE_MULTIPART" => [ "DELETE", "multipart/form-data" ]
        ];

        // Content Type
        $contentType = explode(';', $_SERVER["CONTENT_TYPE"] ?? "")[0];
        $method = $_SERVER["REQUEST_METHOD"];

        $requestType = [ $method, $contentType ];
        $input = file_get_contents("php://input");

        switch ($requestType) {
            case $requestsTable["GET_URL"]:
            case $requestsTable["POST_URL"]:
            case $requestsTable["PUT_URL"]:
            case $requestsTable["PATCH_URL"]:
            case $requestsTable["DELETE_URL"]: {
                parse_str($input, $body);
                return $body;
            }
            case $requestsTable["GET_JSON"]:
            case $requestsTable["POST_JSON"]:
            case $requestsTable["PUT_JSON"]:
            case $requestsTable["PATCH_JSON"]:
            case $requestsTable["DELETE_JSON"]: {
                $body = json_decode($input, true);
                $body = $this->util_array_trim($body, true);
                return $body;
            }
            case $requestsTable["GET_MULTIPART"]:
            case $requestsTable["PUT_MULTIPART"]:
            case $requestsTable["PATCH_MULTIPART"]:
            case $requestsTable["DELETE_MULTIPART"]: {
                $data = $this->decode($input);
                return $data;
            }
            case $requestsTable["POST_MULTIPART"]: {
                return $_POST;
            }
            default: {
                return [];
            }
        }
    }

    public function decode(string $rawData) {
        $files = [];
        $data  = [];
        $boundary = substr($rawData, 0, strpos($rawData, "\r\n"));
        // Fetch and process each part
        $parts = $rawData ? array_slice(explode($boundary, $rawData), 1) : [];
        foreach ($parts as $part) {
            // If this is the last part, break
            if ($part == "--\r\n") {
                break;
            }
            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($rawHeaders, $content) = explode("\r\n\r\n", $part, 2);
            $content = substr($content, 0, strlen($content) - 2);
            // Parse the headers list
            $rawHeaders = explode("\r\n", $rawHeaders);
            $headers    = array();
            foreach ($rawHeaders as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }
            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^form-data; *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                $fieldName = $matches[1];
                $fileName  = (isset($matches[3]) ? $matches[3] : null);
                // If we have a file, save it. Otherwise, save the data.
                if ($fileName !== null) {
                    $localFileName = tempnam(sys_get_temp_dir(), 'sfy');
                    file_put_contents($localFileName, $content);
                    $files = $this->transformData($files, $fieldName, [
                        'name'     => $fileName,
                        'type'     => $headers['content-type'],
                        'tmp_name' => $localFileName,
                        'error'    => 0,
                        'size'     => filesize($localFileName)
                    ]);
                    // register a shutdown function to cleanup the temporary file
                    register_shutdown_function(function () use ($localFileName) {
                        unlink($localFileName);
                    });
                } else {
                    $data = $this->transformData($data, $fieldName, $content);
                }
            }
        }

        $_FILES = $files;
        return $data;
    }

    private function transformData($data, $name, $value) {
        $isArray = strpos($name, '[]');
        if ($isArray && (($isArray + 2) == strlen($name))) {
            $name = str_replace('[]', '', $name);
            $data[$name][]= $value;
        } else {
            $data[$name] = $value;
        }
        return $data;
    }

    public function createUploadedFiles($files): array {
        $outputFiles = [];
        foreach ($files as $key => $file) {
            if (count($file) !== count($file, COUNT_RECURSIVE)) {
                // Multidimensional
                $transpose = [];
                foreach ($file as $pKet => $subarr) {
                    foreach ($subarr as $subkey => $subvalue) {
                        $transpose[$subkey][$pKet] = $subvalue;
                    }
                }
                
                foreach ($transpose as $pKey => $value) {
                    $outputFiles[$key][$pKey] = new UploadedFile(
                        $value["name"] ?? null,
                        $value["path"] ?? null,
                        $value["tmp_name"] ?? null,
                        $value["size"] ?? null,
                        $value["type"] ?? null
                    );
                }
            }
            else {
                // Not multidimensional
                $outputFiles[$key] = new UploadedFile(
                    $file["name"] ?? null,
                    $file["path"] ?? null,
                    $file["tmp_name"] ?? null,
                    $file["size"] ?? null,
                    $file["type"] ?? null
                );
            }
        }
        return $outputFiles;
    }

    function util_array_trim(array &$array, $filter = false) {
        array_walk_recursive($array, function (&$value) use ($filter) {
            if ($filter) {
                $type = gettype($value);
                $value = htmlspecialchars($value);
                $value = trim($value);
                settype($value, $type);
            }
        });
        return $array;
    }
}
