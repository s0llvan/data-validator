<?php

namespace S0llvan\DataValidator\Rule;

class Required implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        return !empty(trim($value));
    }
}