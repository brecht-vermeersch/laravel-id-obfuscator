<?php

use Illuminate\Http\Request;
use function Pest\Laravel\post;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Lurza\IdObfuscator\Facades\IdObfuscator;
use Lurza\IdObfuscator\Attributes\ObfuscatedIds;
use Lurza\IdObfuscator\Middleware\DecodeObfuscatedIds;

it("does nothing if there is no attribute", function () {
    Route::post('testWithNoAttribute', [TestController::class, 'testWithNoAttribute'])
        ->middleware(DecodeObfuscatedIds::class);

    post('testWithNoAttribute')->assertOk();
});

it("decodes when there is an attribute", function () {
    Route::post('testWithAttribute', [TestController::class, 'testWithAttribute'])
        ->middleware(DecodeObfuscatedIds::class);

    post('testWithAttribute', [
        "a" => IdObfuscator::encode(3),
        "b" => [
            "c" => IdObfuscator::encode(1),
            "d" => IdObfuscator::encode(2)
        ],
        "e" => IdObfuscator::encode(4, 'salty'),
        "f" => [
            "g" => IdObfuscator::encode(5, 'salty')
        ]
    ])
        ->assertExactJson([
            "a" => 3,
            "b" => [
                "c" => 1,
                "d" => 2
            ],
            "e" => 4,
            "f" => [
                "g" => 5
            ]
        ])
        ->assertOk();

});

class TestController extends Controller
{
    public function testWithNoAttribute(Request $request)
    {
        return $request->input();
    }

    #[ObfuscatedIds(["a", "b.*", "e" => 'salty', "f.*" => 'salty'])]
    public function testWithAttribute(Request $request)
    {
        return $request->input();
    }
}