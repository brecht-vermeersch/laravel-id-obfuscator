<?php

use Illuminate\Database\Eloquent\Model;
use Lurza\IdObfuscator\Traits\HasObfuscatedId;

it("resolves from route", function() {
    $dummy = Dummy::create();
    $saltDummy = SaltDummy::find($dummy->id);

    expect($dummy->id)->toBe($saltDummy->id);

    $dummyRouteKey = $dummy->getRouteKey();
    $saltDummyRouteKey = $saltDummy->getRouteKey();

    expect($dummyRouteKey)->not->toBe($saltDummyRouteKey);

    $resolvedDummy = (new Dummy)->resolveRouteBinding($dummyRouteKey);
    $resolvedSaltDummy = (new SaltDummy)->resolveRouteBinding($saltDummyRouteKey);

    expect($dummy->id)->toBe($resolvedDummy->id);
    expect($dummy->id)->toBe($resolvedSaltDummy->id);
});

class Dummy extends Model
{
    use HasObfuscatedId;

    public $idObfuscator = 'hashids';
}

class SaltDummy extends Model
{
    use HasObfuscatedId;

    protected $table = "dummies";

    public $idObfuscator = 'hashids';
    public $idObfuscatorSalt = 'salty';
}