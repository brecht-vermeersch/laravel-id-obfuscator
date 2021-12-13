<?php

use Lurza\IdObfuscator\Facades\IdObfuscator;
use Lurza\IdObfuscator\Drivers\NullIdObfuscator;

it("resolves from the manager", function() {
    expect(IdObfuscator::driver('null'))->toBeInstanceOf(NullIdObfuscator::class);
});

it("obfuscates ids", function() {
    $obfuscator = IdObfuscator::driver('null');

    $id = 123;

    expect($id)->toBe($obfuscator->decode($obfuscator->encode($id)));
    expect($id)->toBe($obfuscator->decode($obfuscator->encode($id, 'salty'), 'salty'));
});