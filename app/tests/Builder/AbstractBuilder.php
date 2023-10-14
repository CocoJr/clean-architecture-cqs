<?php

namespace Tests\Builder;

use Faker\Generator;
use Tests\FakerUtility;

abstract class AbstractBuilder
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = FakerUtility::getGenerator();
    }

    abstract public function build(): mixed;
}
