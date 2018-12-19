<?php

namespace S0llvan\DataValidator\Rule;

class Mac implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        return filter_var(trim($value), FILTER_VALIDATE_MAC);
    }
}