<?php

class Curve25519Test extends PHPUnit_Framework_TestCase
{
    function testAddModP()
    {
        $curve25519 = new Curve25519();

        $this->assertSame(
            [2,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
            $curve25519->add(
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0]
            )
        );

        $this->assertSame(
            [0,1,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
            $curve25519->add(
                [0xffff,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0]
            )
        );

        $this->assertSame(
            [19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1],
            $curve25519->add(
                [0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0x8000],
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0]
            )
        );
    }

    function testSubModP()
    {
        $curve25519 = new Curve25519();

        $this->assertSame(
            [19 - 19,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0x8000],
            $curve25519->sub(
                [20,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0]
            )
        );

        $this->assertSame(
            [0xffff - 19,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0x8000],
            $curve25519->sub(
                [0,1,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0]
            )
        );

        $this->assertSame(
            [0xffff - 19,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0x8000 - 1],
            $curve25519->sub(
                [0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0],
                [1,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0]
            )
        );
    }

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
