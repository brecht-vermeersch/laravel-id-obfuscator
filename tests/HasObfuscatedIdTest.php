<?php

use Illuminate\Database\Eloquent\Model;
use Lurza\IdObfuscator\Traits\HasObfuscatedId;

it("can by resolved by confuscated id", function() {
    $dummy = Dummy::create();
    $classBasedDummy = ClassBasedDummy::find($dummy->id);

    $this->assertEquals($dummy->id, $classBasedDummy->id);

    $dummyRouteKey = $dummy->getRouteKey();
    $classBasedDummyRouteKey = $classBasedDummy->getRouteKey();

    $this->assertNotEquals($dummyRouteKey, $classBasedDummy);

    $resolvedDummy = (new Dummy)->resolveRouteBinding($dummyRouteKey);
    $resolvedClassBasedDummy = (new ClassBasedDummy)->resolveRouteBinding($classBasedDummyRouteKey);

    $this->assertEquals($dummy->id, $resolvedDummy->id);
    $this->assertEquals($dummy->id, $resolvedClassBasedDummy->id);
});

class Dummy extends Model
{
    use HasObfuscatedId;

    public $idObfuscator = 'hashids';
}

class ClassBasedDummy extends Model
{
    use HasObfuscatedId;

    protected $table = "dummies";

    public $idObfuscator = 'hashids';
    public $classBasedIdObfuscation = true;
}