<?php

namespace App\Services;

use ReCaptcha\ReCaptcha;

class RecaptchaVerifier
{
    public function verify(string $response, string $ipAddress): bool
    {
        return (new ReCaptcha(config('services.recaptcha.secret_key')))
            ->verify($response, $ipAddress)
            ->isSuccess();
    }
}