<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneraleTrait;
use Closure;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{
    use GeneraleTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->api_password || $request->api_password !== env("API_PASSWORD")) {
            return $this->returnError("not authontificated ", 501);
        }
        return $next($request);
    }
}
