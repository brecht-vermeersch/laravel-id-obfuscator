<?php

use Lurza\IdObfuscator\Drivers\NullIdObfuscator;
use Lurza\IdObfuscator\Facades\IdObfuscator;

it('resolves from the manager', function () {
    expect(IdObfuscator::driver('null'))->toBeInstanceOf(NullIdObfuscator::class);
});

it('encodes and decodes ids', function () {
    $obfuscator = IdObfuscator::driver('null');

    $id = 123;

    expect($id)->toBe($obfuscator->decode($obfuscator->encode($id)));
    expect($id)->toBe($obfuscator->decode($obfuscator->encode($id, 'salty'), 'salty'));
});
