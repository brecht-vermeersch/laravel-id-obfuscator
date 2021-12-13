<?php

use Illuminate\Database\Eloquent\Model;
use Lurza\IdObfuscator\Traits\HasObfuscatedId;

it('resolves from route', function () {
    $dummy = Dummy::create();

    expect($dummy->id)->toBe(
        (new Dummy())->resolveRouteBinding($dummy->getRouteKey())->id
    );
});

it('resolves from route with salt', function () {
    $dummy = SaltDummy::create();

    expect($dummy->id)->toBe(
        (new SaltDummy())->resolveRouteBinding($dummy->getRouteKey())->id
    );
});

class Dummy extends Model
{
    use HasObfuscatedId;

    public $idObfuscator = 'hashids';
}

class SaltDummy extends Model
{
    use HasObfuscatedId;

    protected $table = 'dummies';

    public $idObfuscator = 'hashids';
    public $idObfuscatorSalt = 'salty';
}
