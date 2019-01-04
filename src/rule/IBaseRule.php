<?php

namespace S0llvan\DataValidator\Rule;

interface IBaseRule
{
    public static function Apply($value, array $parameters = []);
}