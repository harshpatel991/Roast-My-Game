<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Log;
use Illuminate\Support\Str;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = ['/add-game'];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $sessionToken = $request->session()->token();

        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');

        if (! $token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }

        if (! is_string($sessionToken) || ! is_string($token)) {
            Log::warning('Token missing at path: '. $request->path());
            return false;
        }

        $tokenMatches = $sessionToken == $token;
        if(!$tokenMatches) {
            Log::warning('Token mismatch at path: '. $request->path());
            return false;
        }
        return true;
    }
}
