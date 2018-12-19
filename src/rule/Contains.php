<?php

namespace S0llvan\DataValidator\Rule;

class Contains implements IBaseRule
{
    public static function Validate($value, array $parameters = [])
    {
        $valid = false;
        $value = trim($value);
        $caracters = str_split($value);

        foreach ($parameters as $parameter) {
            $rule = explode('_', $parameter);
            $rule = array_map('ucfirst', $rule);
            $rule = implode('', $rule);
            $class = __NAMESPACE__ . '\\' . $rule;
            if (class_exists($class)) {
                $valid = false;
                for ($i = 0; $i < count($caracters); $i++) {
                    if ($class::Validate($caracters[$i])) {
                        $valid = true;
                    }
                }
            }
            if (!$valid) {
                break;
            }
        }
        return empty($value) || $valid;
    }
}