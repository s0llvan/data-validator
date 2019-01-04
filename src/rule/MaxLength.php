<?php

namespace S0llvan\DataValidator\Rule;

class MaxLength implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        return mb_strlen(trim($value)) < $parameters[0] || empty($value);
    }
}