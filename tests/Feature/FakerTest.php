<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Faker\Factory as Faker;

class FakerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testFakerUuid()
    {
        $faker = Faker::create();
        $uuid = $faker->uuid();
        $this->assertNotEmpty($uuid);
    }
}
