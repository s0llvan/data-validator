<?php

namespace S0llvan\DataValidator\Filter;

class Lowercase implements IBaseFilter
{
    public static function Apply($value, array $parameters = [])
    {
        return strtolower($value);
    }
}