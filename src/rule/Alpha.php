<?php

namespace S0llvan\DataValidator\Rule;

class Alpha implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        $value = trim($value);
        $matches = preg_match("/^\pL+(?>[-']\pL+)*$/mu", $value, $matches);
        return $matches || empty($value);
    }
}