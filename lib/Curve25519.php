<?php

class Curve25519
{
    public function getPublic($secret)
    {
        if (!is_string($secret) || strlen($secret) !== 32) {
            throw new InvalidArgumentException('Secret must be a 32 byte string');
        }

        return '';
    }

    public function getShared($secret, $public)
    {
        if (!is_string($secret) || strlen($secret) !== 32) {
            throw new InvalidArgumentException('Secret must be a 32 byte string');
        }

        if (!is_string($public) || strlen($public) !== 32) {
            throw new InvalidArgumentException('Public must be a 32 byte string');
        }

        return '';
    }
} 

if (!function_exists('curve25519_public')) {
    function curve25519_public($secret)
    {
        return (new Curve25519)->getPublic($secret);
    }

    function curve25519_shared($secret, $public)
    {
        return (new Curve25519)->getShared($secret, $public);
    }
}
