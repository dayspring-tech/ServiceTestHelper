<?php

namespace Dayspring\ServiceTestHelper\Tests\Framework\Test;

use Dayspring\ServiceTestHelper\Framework\Test\ServiceTestCase;
use Dayspring\ServiceTestHelper\Tests\TestKernel;

class ServiceTestCaseTest extends ServiceTestCase
{

    protected static function getKernelClass()
    {
        return TestKernel::class;
    }

    public function testCreateService()
    {
        $routing = static::$kernel->getContainer()->get('router');
        $testService = self::createService('router');

        $this->assertEquals($routing, $testService);
    }
}
