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
        $this->assertNotEmpty(static::$kernel->getContainer()->getServiceIds());

        $kernel = static::$kernel->getContainer()->get('kernel');
        $testService = self::createService('kernel');

        $this->assertEquals($kernel, $testService);
    }
}
