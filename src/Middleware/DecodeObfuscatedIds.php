<?php declare(strict_types = 1);

namespace Lurza\IdObfuscator\Middleware;

use Closure;
use TypeError;
use ReflectionMethod;
use ReflectionException;
use Illuminate\Http\Request;
use Lurza\IdObfuscator\Attributes\ObfuscatedIds;
use Lurza\IdObfuscator\Facades\IdObfuscator;

class DecodeObfuscatedIds
{
    public function handle(Request $request, Closure $next): mixed
    {
        $input = $request->input();

        foreach ($this->getKeysToDecode($request) as $key=>$value) {
            if(is_int($key)) {
                $dotKey = $value;
                $salt = null;
            } else {
                $dotKey = $key;
                $salt = $value;
            }

            data_set_with_callback($input, $dotKey, fn($value) => IdObfuscator::decode($value, $salt));
        }

        $request->replace($input);

        return $next($request);
    }

    private function getKeysToDecode(Request $request): array
    {
        try {
            $route = $request->route();
            $controller = $route->getController();
            $actionMethod = $route->getActionMethod();

            $rm = new ReflectionMethod($controller, $actionMethod);
            $attributes = $rm->getAttributes(ObfuscatedIds::class);

            if(empty($attributes)) {
                return [];
            }

            return $attributes[0]->getArguments()[0];

        } catch(TypeError|ReflectionException) {
            // route has no controller or something went wrong with the reflection
            return [];
        }
    }
}