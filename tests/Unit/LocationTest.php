<?php

namespace Tests\Unit;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CreatesApplication;

class LocationTest extends TestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $faker;

    public function setUp():void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    /**
     * @return void
     */
    public function test_can_add_location()
    {
        $data = [
            0 => [
                'name' => $this->faker->unique()->word,
                'lat'  => $this->faker->randomFloat(6,0, 90),
                'lng'  => $this->faker->randomFloat(6, 0, 180)
            ]
        ];

        $this->json('POST',route('add.location'), $data)
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Added: 1 rows'
            ]);
    }
    /**
     * @return void
     */
    public function test_get_closest_point()
    {
        $data = [
            'name' => $this->faker->unique()->word,
            'lat'  => $this->faker->randomFloat(6,0, 90),
            'lng'  => $this->faker->randomFloat(6, 0, 180)
        ];

        $this->json('POST',route('get.closest.point'), $data)
            ->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_get_point_in_range()
    {
        $data = [
            'name' => $this->faker->unique()->word,
            'lat'  => $this->faker->randomFloat(6,0, 90),
            'lng'  => $this->faker->randomFloat(6, 0, 180),
            'threshold' => $this->faker->randomFloat(6, 0, 30000),

        ];

        $this->json('POST',route('get.point.in.range'), $data)
            ->assertStatus(200);
    }
}
