<?php

namespace Potara\Correios\Test;

use PHPUnit\Framework\TestCase;
use Potara\Correios\Cep;

class CepTest extends TestCase
{
    protected $testCep = "04546-001";

    public function testCepValid()
    {
        $validCep = Cep::find($this->testCep);
        $this->assertEquals($this->testCep, $validCep['cep']);
    }

    public function testCepInvalidFormat()
    {
        try {
            Cep::find("a{$this->testCep}");
        } catch (\Exception $e) {
            $this->assertEquals(101, $e->getCode());
        }
    }

    public function testCepInvalid()
    {
        try {
            Cep::find("04546-021");
        } catch (\Exception $e) {
            $this->assertEquals(102, $e->getCode());
        }
    }
}