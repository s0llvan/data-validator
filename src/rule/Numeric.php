<?php

namespace S0llvan\DataValidator\Rule;

class Numeric implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        $value = trim($value);
        return ctype_digit($value) || empty($value);
    }
}