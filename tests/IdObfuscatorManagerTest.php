<?php

use Lurza\IdObfuscator\IdObfuscatorManager;
use Lurza\IdObfuscator\Facades\IdObfuscator;

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