<?php

namespace Bloom\Http;

/**
 * List of the supported HTTP Methods
 */
enum HttpMethod: string {
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
    case HEAD = 'HEAD';
    case OPTIONS = 'OPTIONS';
}