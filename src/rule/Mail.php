<?php

namespace S0llvan\DataValidator\Rule;

class Mail implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL);
    }
}