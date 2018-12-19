<?php

namespace S0llvan\DataValidator\Rule;

class AlphaUppercase implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        $value = trim($value);
        return ctype_upper($value) || empty($value);
    }
}