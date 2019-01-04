<?php

namespace S0llvan\DataValidator\Rule;

class Mail implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL);
    }
}