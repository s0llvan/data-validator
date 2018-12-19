<?php

class IntegerTest extends PHPUnit_Framework_TestCase
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
                'field' => '123'
            ]
        ], [
            'form[field]' => 'integer'
        ]);
        $this->assertTrue($validator->isValid());
        unset($validator);
    }
}