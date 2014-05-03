<?php

class Curve25519Test extends PHPUnit_Framework_TestCase
{
    function testOverall()
    {
        $curve25519 = new Curve25519();

        $secret1 = str_repeat('a', 32);
        $secret2 = str_repeat('b', 32);

        $public1 = $curve25519->getPublic($secret1);
        $public2 = $curve25519->getPublic($secret2);

        $shared1 = $curve25519->getShared($secret1, $public2);
        $shared2 = $curve25519->getShared($secret2, $public1);

        $this->assertSame($shared1, $shared2);
    }

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

    function testMulModP()
    {
        $curve25519 = new Curve25519();

        $this->assertSame(
            [571, 534, 497, 460, 423, 386, 349, 312, 275, 238, 201, 164, 127, 90, 53, 16],
            $curve25519->mul(
                [1,1,1,1, 1,1,1,1, 1,1,1,1, 1,1,1,1],
                [1,1,1,1, 1,1,1,1, 1,1,1,1, 1,1,1,1]
            )
        );

        $this->assertSame(
            [1350, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32768],
            $curve25519->mul(
                [0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff],
                [0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff]
            )
        );
    }

    function testSqrModP()
    {
        $curve25519 = new Curve25519();

        $this->assertSame(
            [571, 534, 497, 460, 423, 386, 349, 312, 275, 238, 201, 164, 127, 90, 53, 16],
            $curve25519->sqr(
                [1,1,1,1, 1,1,1,1, 1,1,1,1, 1,1,1,1]
            )
        );

        $this->assertSame(
            [1350, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 32768],
            $curve25519->sqr(
                [0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff]
            )
        );
    }

    function testClamp()
    {
        $curve25519 = new Curve25519();

        $key = array_fill(0, 16, 0xffff);
        $curve25519->clamp($key);

        $this->assertSame(
            [0xfff8,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0xffff, 0xffff,0xffff,0xffff,0x7fff],
            $key
        );

        $key = array_fill(0, 16, 7);
        $curve25519->clamp($key);

        $this->assertSame(
            [0,7,7,7, 7,7,7,7, 7,7,7,7, 7,7,7,0x4007],
            $key
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
