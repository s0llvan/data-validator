<?php

class MaxLengthTest extends PHPUnit_Framework_TestCase
{
    /**
     * Just check if the DataValidator has no syntax error 
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testRule()
    {
        $validator = new S0llvan\DataValidator\DataValidator([
            'form' => [
                'field' => 'john'
            ]
        ], [
            'form[field]' => 'max_length:12'
        ]);
        $this->assertTrue($validator->isValid());
        unset($validator);
    }
}