<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $productName, $productPrice, $adminUser, $normalUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->adminUser = User::factory()->admin()->create();
        $this->normalUser = User::factory()->create();
        $this->productName = "Product Name";
        $this->productPrice = "1000000";
    }

    public function testANonAdminUserOrGuestCantCreateAProduct()
    {
        $response = $this->postJson('/dashboard/product');
        $response->assertStatus(401);

        $this->actingAs($this->normalUser);
        $response = $this->postJson('/dashboard/product');
        $response->assertStatus(401);
    }

    public function testAnAdminCanCreateAProduct()
    {
        $this->actingAs($this->adminUser);

        $response = $this->postJson('/dashboard/product', [
            'name' => $this->productName,
            'price' => $this->productPrice,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => $this->productName]);
        $response->assertJson(['product' => ['name' => $this->productName, 'price' => $this->productPrice]]);
    }
}
