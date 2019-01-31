<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;

class ProductControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_a_product()
    {

        $faker = Factory::create();
        // $this->assertTrue(true);
        // Given
            // User is authenticated
        // When
            // post request create product
        $response = $this->json('POST', '/api/products', [
            'name' => $name = $faker->company,
            'slug' => str_slug($name),
            'price' => $price = random_int(10, 100),
        ]);
        // Then
            // product exists
        $response
        ->assertJsonStructure([
            'id',
            'name',
            'slug',
            'price',
            'created_at'
        ])
        ->assertJson([
            'name' => $name,
            'slug' => str_slug($name),
            'price' => $price,
        ])
        ->assertStatus(201);
        $this->assertDatabaseHas('products',[
            'name' => $name,
            'slug' => str_slug($name),
            'price' => $price,
        ]);
    }
}
