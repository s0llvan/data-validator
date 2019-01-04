<?php

class UppercaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Just check if the DataValidator has no syntax error 
     *
     * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
     * any typo before you even use this library in a real project.
     *
     */
    public function testFilter()
    {
        $validator = new S0llvan\DataValidator\DataValidator([
            'form' => [
                'field' => 'john'
            ]
        ], [], [], [
            'form[field]' => 'uppercase'
        ]);
        $this->assertTrue($validator->get('form[field]') == 'JOHN');
        unset($validator);
    }
}