<?php

class Curve25519Test extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    function testInvalidSharedSecret()
    {
        $curve25519 = new Curve25519();
        $curve25519->getPublic('123');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    function testInvalidPublicSecret()
    {
        $curve25519 = new Curve25519();
        $curve25519->getShared('123', '01234567890123456789012345678901');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    function testInvalidPublicShared()
    {
        $curve25519 = new Curve25519();
        $curve25519->getShared('01234567890123456789012345678901', '123');
    }
}
