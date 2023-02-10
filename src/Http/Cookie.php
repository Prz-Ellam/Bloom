<?php

namespace Bloom\Http\Cookies;

class Cookie {
    private string $name;
    private string $value;
    private int $expiration;
    private string $path;
    private string $domain;
    private bool $secure = false;
    private bool $httpOnly = false;

    public function create(string $name, 
        string $value = "", 
        int $expiration = 0, 
        string $path = "", 
        string $domain = "", 
        bool $secure = false, 
        bool $httpOnly = false) {

        

    }
}
