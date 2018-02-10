<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Test\Traits\DataServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public static function assertIsString($condition, $message = '')
    {
        self::assertThat(is_string($condition), self::isTrue(), $message);
    }

    public static function assertIsClass($class, $object, $message = '')
    {
        self::assertEquals($class, get_class($object), $message);
    }

}
