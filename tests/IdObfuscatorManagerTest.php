<?php

use Lurza\IdObfuscator\Facades\IdObfuscator;
use Lurza\IdObfuscator\IdObfuscatorManager;

it('resolves from the container', function () {
    $manager = app(IdObfuscatorManager::class);

    expect($manager instanceof IdObfuscatorManager)->toBeTrue();
});

it('resolves as a Facade', function () {
    $manager = IdObfuscator::getFacadeRoot();

    expect($manager instanceof IdObfuscatorManager)->toBeTrue();
});

it('resolves as a singleton', function () {
    $managerA = app(IdObfuscatorManager::class);
    $managerB = app(IdObfuscatorManager::class);

    expect($managerA)->toBe($managerB);
});
