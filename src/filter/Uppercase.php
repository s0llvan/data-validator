<?php

namespace S0llvan\DataValidator\Filter;

class Uppercase implements IBaseFilter
{
    public static function Apply($value, array $parameters = [])
    {
        return strtoupper($value);
    }
}