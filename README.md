Curve25519 in PHP
=================

This is a pure PHP implementation of the Curve25519 Diffie-Hellman function.

The library has been written to be high performance (relative to PHP), not pretty. It obviously doesn't perform anywhere close to a native implementation.

### Usage:

```
$mySecret = random_bytes(32);
$myPublic = \Curve25519\publicKey($mySecret);
$shared   = \Curve25519\sharedKey($mySecret, $theirPublic);
```

### Multi-party shared secrets:

When more than two parties are communicating, it is necessary to communicate intermediate values so that each party can compute a common shared secret

```
$alicePrivate = str_repeat('a', 32);
$bobPrivate   = str_repeat('b', 32);
$carolPrivate = str_repeat('c', 32);

$alicePublic = \Curve25519\publicKey($alicePrivate); // Send to Bob
$bobPublic   = \Curve25519\publicKey($bobPrivate);   // Send to Carol
$carolPublic = \Curve25519\publicKey($carolPrivate); // Send to Alice

$aliceCarolShared = \Curve25519\sharedKey($alicePrivate, $carolPublic); // Send to Bob
$bobAliceShared   = \Curve25519\sharedKey($bobPrivate,   $alicePublic); // Send to Carol
$carolBobShared   = \Curve25519\sharedKey($carolPrivate, $bobPublic);   // Send to Alice

$aliceShared = \Curve25519\sharedKey($alicePrivate, $carolBobShared);
$bobShared   = \Curve25519\sharedKey($bobPrivate,   $aliceCarolShared);
$carolShared = \Curve25519\sharedKey($carolPrivate, $bobAliceShared);

// An adversary potentially observed f(a), f(b), f(c), f(ab), f(ac), and f(bc),
// whereas each party solved for f(abc)
var_dump($aliceShared === $bobShared && $bobShared === $carolShared);
```