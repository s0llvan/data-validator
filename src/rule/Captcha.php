<?php

namespace S0llvan\DataValidator\Rule;

use ReCaptcha\ReCaptcha;

class Captcha implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        $configuration = new \Configuration(1);
        $privateCaptchaKey = $configuration->tab_var[4]->value;

        $recaptcha = new ReCaptcha($privateCaptchaKey);
        $recaptcha = $recaptcha->setExpectedAction('social');

        if (isset($parameters[0])) {
            $recaptcha->setScoreThreshold($parameters[0]);
        }

        $response = $recaptcha->verify($value, $_SERVER['REMOTE_ADDR']);
        return $response->isSuccess();
    }
}