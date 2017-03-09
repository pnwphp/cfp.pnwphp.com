<?php

namespace OpenCFP\Test\Util\Faker;

use Faker\Generator;

class GeneratorTest extends \PHPUnit\Framework\TestCase
{
    use GeneratorTrait;

    public function testGetFakerReturnsFaker()
    {
        $faker = $this->getFaker();

        $this->assertInstanceOf(Generator::class, $faker);
    }

    public function testGetFakerReturnsSameInstance()
    {
        $faker = $this->getFaker();

        $this->assertSame($faker, $this->getFaker());
    }
}
