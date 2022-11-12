<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_list_product()
    {
        Product::factory()->count(10)->create();
        $response = $this->getJson(route('products.index'));
        $response->assertSuccessful();
        $response->assertJsonCount(10);
    }

    /** @test */
    public function should_filter_product_by_name()
    {
        Product::factory()->count(10)->create();
        $product = Product::factory()->create(['name' => 'product-name']);

        $response = $this->getJson(route('products.index', ['name' => 'product-name']));
        $response->assertSuccessful();
        $response->assertExactJson([$product->toArray()]);
    }

    /** @test */
    public function should_filter_product_by_category()
    {
        Product::factory()->count(10)->create();
        $products = Product::factory()->count(2)->create(['category' => 'product-category']);

        $response = $this->getJson(route('products.index', ['category' => 'product-category']));
        $response->assertSuccessful();
        $response->assertExactJson($products->toArray());
    }

    /** @test */
    public function should_filter_product_with_null_image_url()
    {
        Product::factory()->count(10)->create();
        $products = Product::factory()->count(5)->create(['image_url' => null]);

        $response = $this->getJson(route('products.index', ['image_url_null' => 'true']));
        $response->assertSuccessful();
        $response->assertJsonCount(5);
        $response->assertExactJson($products->toArray());
    }

    /** @test */
    public function should_filter_product_with_not_null_image_url()
    {
        $products = Product::factory()->count(10)->create();
        Product::factory()->count(5)->create(['image_url' => null]);

        $response = $this->getJson(route('products.index', ['image_url_not_null' => 'true']));
        $response->assertSuccessful();
        $response->assertJsonCount(10);
        $response->assertExactJson($products->toArray());
    }

    /** @test */
    public function should_get_product_by_id()
    {
        $products = Product::factory()->count(10)->create();
        $response = $this->getJson(route('products.show', 1));
        $response->assertSuccessful();
        $response->assertExactJson($products->first()->toArray());
    }

    /** @test */
    public function should_store_product()
    {
        $product = Product::factory()->make();
        $response = $this->postJson(route('products.store'), $product->toArray());
        $response->assertSuccessful();
        $this->assertDatabaseHas('products', $product->toArray());
    }

    /** @test */
    public function should_return_validate_error_unique_name()
    {
        Product::factory()->create(['name' => 'unique-name']);
        $product = Product::factory()->make(['name' => 'unique-name']);
        $response = $this->postJson(route('products.store'), $product->toArray());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name' => 'O nome ja existe',
        ]);
    }

    /** @test */
    public function should_return_validate_error_invalid_url()
    {
        $product = Product::factory()->make(['image_url' => 'invalid-url']);
        $response = $this->postJson(route('products.store'), $product->toArray());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'image_url' => 'Image url inválida',
        ]);
    }

    /** @test */
    public function should_return_validate_error_required_field()
    {
        $product = Product::factory()->make([
            'name'          => '',
            'price'         => '',
            'description'   => '',
            'category'      => ''
        ]);

        $response = $this->postJson(route('products.store'), $product->toArray());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name'          => 'O nome é obrigatório',
            'price'         => 'O preço é obrigatório',
            'description'   => 'A descrição é obrigatória',
            'category'      => 'A categoria é obrigatória',
        ]);
    }

    /** @test */
    public function should_update_product()
    {
        $product = Product::factory()->create();
        $newProduct = [...$product->toArray(), 'name' => 'new name'];
        $response = $this->putJson(route('products.update', $product->id), $newProduct);
        $response->assertSuccessful();
        $this->assertDatabaseHas('products', $newProduct);
    }

    /** @test */
    public function should_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->deleteJson(route('products.update', $product->id));
        $response->assertSuccessful();
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}
