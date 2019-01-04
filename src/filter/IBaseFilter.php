<?php

namespace S0llvan\DataValidator\Filter;

interface IBaseFilter
{
    public static function Apply($value, array $parameters = []);
}