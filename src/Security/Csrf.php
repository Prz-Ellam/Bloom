<?php

namespace Bloom\Security;

class Csrf {
    public function generateToken() {
        return bin2hex(random_bytes(32));
    }
}
