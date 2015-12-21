<?php

namespace Curve25519;

if (!extension_loaded('curve25519')) {
    function publicKey($secret)
    {
        return (new Curve25519)->publicKey($secret);
    }

    function sharedKey($secret, $public)
    {
        return (new Curve25519)->sharedKey($secret, $public);
    }
}
