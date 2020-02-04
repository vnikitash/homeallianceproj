<?php

namespace App\Http\Middleware;

use Closure;

class Localisation
{
    private const ACCEPTABLE_LANGUAGES = [
        'en',
        'de'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $receivedLangCode = $request->header('Accept-Language');

        if (!in_array($receivedLangCode, self::ACCEPTABLE_LANGUAGES)) {
            //If received unsupported language code => en
            $receivedLangCode = self::ACCEPTABLE_LANGUAGES[0];
        }

        app()->setLocale($receivedLangCode);

        return $next($request);
    }
}
