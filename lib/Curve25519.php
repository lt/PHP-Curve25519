<?php

class Curve25519
{
    private $zero = [0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];
    private $one  = [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];
    private $nine = [9,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0];

    function add(array $a, array $b)
    {
        return [
            ($carry = (($a[15] >> 15) + ($b[15] >> 15)) * 19 + $a[0] + $b[0]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 1] + $b[ 1]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 2] + $b[ 2]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 3] + $b[ 3]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 4] + $b[ 4]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 5] + $b[ 5]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 6] + $b[ 6]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 7] + $b[ 7]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 8] + $b[ 8]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 9] + $b[ 9]) & 0xffff,
            ($carry = ($carry >> 16) + $a[10] + $b[10]) & 0xffff,
            ($carry = ($carry >> 16) + $a[11] + $b[11]) & 0xffff,
            ($carry = ($carry >> 16) + $a[12] + $b[12]) & 0xffff,
            ($carry = ($carry >> 16) + $a[13] + $b[13]) & 0xffff,
            ($carry = ($carry >> 16) + $a[14] + $b[14]) & 0xffff,
                      ($carry >> 16) + ($a[15] & 0x7fff) + ($b[15] & 0x7fff)
        ];
    }

    function sub(array $a, array $b)
    {
        return [
            ($carry = 0x80000 + (($a[15] >> 15) - ($b[15] >> 15) - 1) * 19 + $a[0] - $b[0]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 1] - $b[ 1]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 2] - $b[ 2]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 3] - $b[ 3]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 4] - $b[ 4]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 5] - $b[ 5]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 6] - $b[ 6]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 7] - $b[ 7]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 8] - $b[ 8]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[ 9] - $b[ 9]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[10] - $b[10]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[11] - $b[11]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[12] - $b[12]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[13] - $b[13]) & 0xffff,
            ($carry = ($carry >> 16) + 0x7fff8 + $a[14] - $b[14]) & 0xffff,
                      ($carry >> 16) + 0x7ff8 + ($a[15] & 0x7fff) - ($b[15] & 0x7fff)
        ];
    }

    function mulHalf($a7, $a6, $a5, $a4, $a3, $a2, $a1, $a0, $b7, $b6, $b5, $b4, $b3, $b2, $b1, $b0)
    {
        return [
            ($carry = $a0*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b1 + $a1*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b2 + $a1*$b1 + $a2*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b3 + $a1*$b2 + $a2*$b1 + $a3*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b4 + $a1*$b3 + $a2*$b2 + $a3*$b1 + $a4*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b5 + $a1*$b4 + $a2*$b3 + $a3*$b2 + $a4*$b1 + $a5*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b6 + $a1*$b5 + $a2*$b4 + $a3*$b3 + $a4*$b2 + $a5*$b1 + $a6*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a0*$b7 + $a1*$b6 + $a2*$b5 + $a3*$b4 + $a4*$b3 + $a5*$b2 + $a6*$b1 + $a7*$b0) & 0xffff,
            ($carry = ($carry >> 16) + $a1*$b7 + $a2*$b6 + $a3*$b5 + $a4*$b4 + $a5*$b3 + $a6*$b2 + $a7*$b1) & 0xffff,
            ($carry = ($carry >> 16) + $a2*$b7 + $a3*$b6 + $a4*$b5 + $a5*$b4 + $a6*$b3 + $a7*$b2) & 0xffff,
            ($carry = ($carry >> 16) + $a3*$b7 + $a4*$b6 + $a5*$b5 + $a6*$b4 + $a7*$b3) & 0xffff,
            ($carry = ($carry >> 16) + $a4*$b7 + $a5*$b6 + $a6*$b5 + $a7*$b4) & 0xffff,
            ($carry = ($carry >> 16) + $a5*$b7 + $a6*$b6 + $a7*$b5) & 0xffff,
            ($carry = ($carry >> 16) + $a6*$b7 + $a7*$b6) & 0xffff,
            ($carry = ($carry >> 16) + $a7*$b7) & 0xffff,
                       $carry >> 16
        ];
    }

    function mul(array $a, array $b) {
        $d = $this->mulHalf($a[15], $a[14], $a[13], $a[12], $a[11], $a[10], $a[ 9], $a[ 8], $b[15], $b[14], $b[13], $b[12], $b[11], $b[10], $b[ 9], $b[ 8]);
        $e = $this->mulHalf($a[ 7], $a[ 6], $a[ 5], $a[ 4], $a[ 3], $a[ 2], $a[ 1], $a[ 0], $b[ 7], $b[ 6], $b[ 5], $b[ 4], $b[ 3], $b[ 2], $b[ 1], $b[ 0]);
        $f = $this->mulHalf($a[15] + $a[7], $a[14] + $a[6], $a[13] + $a[5], $a[12] + $a[4], $a[11] + $a[3], $a[10] + $a[2], $a[9] + $a[1], $a[8] + $a[0], $b[15] + $b[7], $b[14] + $b[6], $b[13] + $b[5], $b[12] + $b[4], $b[11] + $b[3], $b[10] + $b[2], $b[9] + $b[1], $b[8] + $b[0]);

        return $this->reduce([
            ($carry = 0x800000                  + $e[ 0] + ($f[ 8] - $d[ 8] - $e[ 8] + $d[ 0] -0x80) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 1] + ($f[ 9] - $d[ 9] - $e[ 9] + $d[ 1]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 2] + ($f[10] - $d[10] - $e[10] + $d[ 2]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 3] + ($f[11] - $d[11] - $e[11] + $d[ 3]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 4] + ($f[12] - $d[12] - $e[12] + $d[ 4]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 5] + ($f[13] - $d[13] - $e[13] + $d[ 5]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 6] + ($f[14] - $d[14] - $e[14] + $d[ 6]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 7] + ($f[15] - $d[15] - $e[15] + $d[ 7]) * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 8] +  $f[ 0] - $d[ 0] - $e[ 0] + $d[ 8]  * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[ 9] +  $f[ 1] - $d[ 1] - $e[ 1] + $d[ 9]  * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[10] +  $f[ 2] - $d[ 2] - $e[ 2] + $d[10]  * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[11] +  $f[ 3] - $d[ 3] - $e[ 3] + $d[11]  * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[12] +  $f[ 4] - $d[ 4] - $e[ 4] + $d[12]  * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[13] +  $f[ 5] - $d[ 5] - $e[ 5] + $d[13]  * 38) & 0xffff,
            ($carry = 0x7fff80 + ($carry >> 16) + $e[14] +  $f[ 6] - $d[ 6] - $e[ 6] + $d[14]  * 38) & 0xffff,
                      0x7fff80 + ($carry >> 16) + $e[15] +  $f[ 7] - $d[ 7] - $e[ 7] + $d[15]  * 38
        ]);
    }

    function sqr(array $a)
    {
        return $this->mul($a, $a);
    }

    function mul121665(array $a)
    {
        return $this->reduce([
            ($carry =                  $a[ 0] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 1] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 2] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 3] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 4] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 5] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 6] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 7] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 8] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 9] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[10] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[11] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[12] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[13] * 121665) & 0xffff,
            ($carry = ($carry >> 16) + $a[14] * 121665) & 0xffff,
                      ($carry >> 16) + $a[15] * 121665
        ]);
    }

    function inv(array $a)
    {
        $c = $a;
        $i = 250;
        while (--$i) {
            $a = $this->sqr($a);
            $a = $this->mul($a, $c);
        }
        $a = $this->sqr($a);
        $a = $this->sqr($a); $a = $this->mul($a, $c);
        $a = $this->sqr($a);
        $a = $this->sqr($a); $a = $this->mul($a, $c);
        $a = $this->sqr($a); $a = $this->mul($a, $c);
        return $a;
    }

    function reduce(array $a)
    {
        $carry2 = ($carry = $a[15]) & 0x7fff;
        $r = [
            ($carry = ($carry >> 15) * 19 + $a[0]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 1]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 2]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 3]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 4]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 5]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 6]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 7]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 8]) & 0xffff,
            ($carry = ($carry >> 16) + $a[ 9]) & 0xffff,
            ($carry = ($carry >> 16) + $a[10]) & 0xffff,
            ($carry = ($carry >> 16) + $a[11]) & 0xffff,
            ($carry = ($carry >> 16) + $a[12]) & 0xffff,
            ($carry = ($carry >> 16) + $a[13]) & 0xffff,
            ($carry = ($carry >> 16) + $a[14]) & 0xffff,
                      ($carry >> 16) + $carry2
        ];
        return $r;
    }

    function dbl($x, $z)
    {
        $m = $this->sqr($this->add($x, $z));
        $n = $this->sqr($this->sub($x, $z));
        $o = $this->sub($m, $n);
        $x_2 = $this->mul($n, $m);
        $z_2 = $this->mul($this->add($this->mul121665($o), $m), $o);
        return [$x_2, $z_2];
    }

    function sum($x, $z, $x_p, $z_p, $x_1)
    {
        $p = $this->mul($this->sub($x, $z), $this->add($x_p, $z_p));
        $q = $this->mul($this->add($x, $z), $this->sub($x_p, $z_p));
        $x_3 = $this->sqr($this->add($p, $q));
        $z_3 = $this->mul($this->sqr($this->sub($p, $q)), $x_1);
        return [$x_3, $z_3];
    }

    function scalarmult(array $f, array $c)
    {
        $x_1 = $c;
        $a = $this->dbl($x_1, $this->one);
        $q = [$x_1, $this->one];

        $n = 0xff;

        while (1 & $f[$n >> 4] >> ($n & 0xf) === 0) {
            $n--;
            // For correct constant-time operation, $bit 255 should always be set to 1 so the following 'while' loop is never entered
            if ($n < 0) {
                return $this->zero;
            }
        }
        $n--;

        $aq = [ $a, $q ];

        while ($n >= 0) {
            $b = 1 & $f[$n >> 4] >> ($n & 0xf);
            $r = $this->sum($aq[0][0], $aq[0][1], $aq[1][0], $aq[1][1], $x_1);
            $s = $this->dbl($aq[1-$b][0], $aq[1-$b][1]);
            $aq[1-$b]  = $s;
            $aq[$b]    = $r;
            $n--;
        }
        $q = $aq[1];

        $q[1] = $this->inv($q[1]);
        $q[0] = $this->mul($q[0], $q[1]);
        return $this->reduce($q[0]);
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

        $this->clamp($n);

        $q = $this->scalarmult($n, $this->nine);
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
