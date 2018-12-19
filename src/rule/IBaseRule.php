<?php

namespace S0llvan\DataValidator\Rule;

interface IBaseRule
{
    public static function Validate($value, array $parameters = []);
}