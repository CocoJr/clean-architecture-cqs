<?php

namespace Tests;

use Faker\Factory;
use Faker\Generator;

class FakerUtility
{
    private static ?Generator $faker = null;

    public static function getGenerator(): Generator
    {
        if (null === self::$faker) {
            self::$faker = Factory::create();
        }

        return self::$faker;
    }
}
