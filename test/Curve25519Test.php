<?php

namespace Curve25519;

class Curve25519Test extends \PHPUnit_Framework_TestCase
{
    function testOverall()
    {
        $curve25519 = new Curve25519();

        $secret1 = str_repeat('a', 32);
        $secret2 = str_repeat('b', 32);

        $public1 = $curve25519->publicKey($secret1);
        $public2 = $curve25519->publicKey($secret2);

        $shared1 = $curve25519->sharedKey($secret1, $public2);
        $shared2 = $curve25519->sharedKey($secret2, $public1);

        $this->assertSame($shared1, $shared2);
    }

    function testNaCL()
    {
        $alicepk = call_user_func_array('pack', ['C*',
            0x85,0x20,0xf0,0x09,0x89,0x30,0xa7,0x54,
            0x74,0x8b,0x7d,0xdc,0xb4,0x3e,0xf7,0x5a,
            0x0d,0xbf,0x3a,0x0d,0x26,0x38,0x1a,0xf4,
            0xeb,0xa4,0xa9,0x8e,0xaa,0x9b,0x4e,0x6a
        ]);

        $alicesk = call_user_func_array('pack', ['C*',
            0x77,0x07,0x6d,0x0a,0x73,0x18,0xa5,0x7d,
            0x3c,0x16,0xc1,0x72,0x51,0xb2,0x66,0x45,
            0xdf,0x4c,0x2f,0x87,0xeb,0xc0,0x99,0x2a,
            0xb1,0x77,0xfb,0xa5,0x1d,0xb9,0x2c,0x2a
        ]);

        $curve25519 = new Curve25519();
        $this->assertSame($alicepk, $curve25519->publicKey($alicesk));
    }

    function testClamp()
    {
        $curve25519 = new Curve25519();

        $this->assertSame(
            [0xf8,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0xff,0x7f],
            $curve25519->clamp(str_repeat("\xff", 32))
        );

        $this->assertSame(
            [0,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,7,0x47],
            $curve25519->clamp(str_repeat("\x07", 32))
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testInvalidSharedSecret()
    {
        $curve25519 = new Curve25519();
        $curve25519->publicKey('123');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testInvalidPublicSecret()
    {
        $curve25519 = new Curve25519();
        $curve25519->sharedKey('123', '01234567890123456789012345678901');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testInvalidPublicShared()
    {
        $curve25519 = new Curve25519();
        $curve25519->sharedKey('01234567890123456789012345678901', '123');
    }
}
