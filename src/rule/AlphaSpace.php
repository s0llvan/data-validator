<?php

namespace S0llvan\DataValidator\Rule;

class AlphaSpace implements IBaseRule
{
    public static function Apply($value, array $parameters = [])
    {
        $value = trim($value);
        $matches = preg_match("/^\pL+(?>[- ']\pL+)*$/mu", $value, $matches);
        return $matches || empty($value);
    }
}