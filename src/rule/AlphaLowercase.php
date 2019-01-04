<?php

namespace S0llvan\DataValidator\Rule;

class AlphaLowercase implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        $value = trim($value);
        return ctype_lower($value) || empty($value);
    }
}