<?php

class Curve25519
{
    function add(array $a, array $b)
    {
        return [
            ($carry = (($a[15] >> 15) + ($b[15] >> 15)) * 19 + $a[0] + $b[0]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 1] + $b[ 1]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 2] + $b[ 2]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 3] + $b[ 3]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 4] + $b[ 4]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 5] + $b[ 5]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 6] + $b[ 6]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 7] + $b[ 7]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 8] + $b[ 8]) % 0x10000,
            ($carry = ($carry >> 16) + $a[ 9] + $b[ 9]) % 0x10000,
            ($carry = ($carry >> 16) + $a[10] + $b[10]) % 0x10000,
            ($carry = ($carry >> 16) + $a[11] + $b[11]) % 0x10000,
            ($carry = ($carry >> 16) + $a[12] + $b[12]) % 0x10000,
            ($carry = ($carry >> 16) + $a[13] + $b[13]) % 0x10000,
            ($carry = ($carry >> 16) + $a[14] + $b[14]) % 0x10000,
            ($carry >> 16) + $a[15] % 0x8000 + $b[15] % 0x8000
        ];
    }

    function sub(array $a, array $b)
    {
        return [
            ($carry = 0x80000 + (($a[15] >> 15) - ($b[15] >> 15) - 1) * 19 + $a[0] - $b[0]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 1] - $b[ 1]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 2] - $b[ 2]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 3] - $b[ 3]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 4] - $b[ 4]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 5] - $b[ 5]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 6] - $b[ 6]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 7] - $b[ 7]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 8] - $b[ 8]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 9] - $b[ 9]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[10] - $b[10]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[11] - $b[11]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[12] - $b[12]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[13] - $b[13]) % 0x10000,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[14] - $b[14]) % 0x10000,
            ($carry >> 16) + 0x7ff8 + $a[15] % 0x8000 - $b[15] % 0x8000
        ];
    }

    function scalarmult(array $n, array $p)
    {
        return [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    }

    function clamp(array &$key)
    {
        $key[0] &= 0xfff8;
        $key[15] = ($key[15] & 0x7fff) | 0x4000;
    }

    function getPublic($secret)
    {
        if (!is_string($secret) || strlen($secret) !== 32) {
            throw new InvalidArgumentException('Secret must be a 32 byte string');
        }

        $n = array_values(unpack('v16', $secret));
        $p = [9,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $this->clamp($n);

        $q = $this->scalarmult($n, $p);
        array_unshift($q, 'v16');

        return call_user_func_array('pack', $q);
    }

    function getShared($secret, $public)
    {
        if (!is_string($secret) || strlen($secret) !== 32) {
            throw new InvalidArgumentException('Secret must be a 32 byte string');
        }

        if (!is_string($public) || strlen($public) !== 32) {
            throw new InvalidArgumentException('Public must be a 32 byte string');
        }

        $n = array_values(unpack('v16', $secret));
        $p = array_values(unpack('v16', $public));

        $this->clamp($n);

        $q = $this->scalarmult($n, $p);
        array_unshift($q, 'v16');

        return call_user_func_array('pack', $q);
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
