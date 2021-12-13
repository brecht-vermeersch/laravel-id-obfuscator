<?php

use Lurza\IdObfuscator\Drivers\HashidsIdObfuscator;
use Lurza\IdObfuscator\Facades\IdObfuscator;

it("resolves from the manager", function() {
    expect(IdObfuscator::driver('hashids'))->toBeInstanceOf(HashidsIdObfuscator::class);
});

it("encodes and decodes ids", function() {
    $obfuscator = IdObfuscator::driver('hashids');

    $id = 123;

    expect($id)->toBe($obfuscator->decode($obfuscator->encode($id)));
    expect($id)->toBe($obfuscator->decode($obfuscator->encode($id, 'salty'), 'salty'));
});