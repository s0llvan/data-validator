<?php

namespace S0llvan\DataValidator\Rule;

class MinLength implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        return mb_strlen(trim($value)) >= $parameters[0] || empty($value);
    }
}