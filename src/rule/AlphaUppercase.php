<?php

namespace S0llvan\DataValidator\Rule;

class AlphaUppercase implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        $value = trim($value);
        return ctype_upper($value) || empty($value);
    }
}