<?php

namespace S0llvan\DataValidator\Rule;

class AlphaNumeric implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        $value = trim($value);
        $matches = preg_match("/^[\pL|\d]+(?>[-'][\pL|\d]+)*$/mu", $value, $matches);
        return $matches || empty($value);
    }
}