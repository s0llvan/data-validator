<?php

namespace S0llvan\DataValidator\Rule;

class Required implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        return !empty(trim($value));
    }
}