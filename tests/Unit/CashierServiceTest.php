<?php

namespace Tests\Unit;

use App\DataWrappers\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\CashierService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class CashierServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var CashierService
     */
    protected $cashierService;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();

        $this->cashierService = $this->partialMock(CashierService::class, function (MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods();
        });
    }

    /**
     * Cashier Service test
     *
     * @return void
     */
    public function test_price_collation()
    {
        $cart = new Cart;

        $cart->add(Product::factory()->create([
            'price' => 400,
            'quantity' => 2
        ]), 2);

        $this->assertEquals(800, $this->cashierService->collate_price($cart));
    }

    public function test_generate_invoice()
    {
        $user = User::factory()->create();

        $cart = new Cart;

        $cart->add($Product = Product::factory()->create([
            'price' => 400,
            'quantity' => 2
        ]), 2);

        $this->cashierService->generateInvoice(
            $user,
            $cart,
            $this->cashierService->collate_price($cart)
        );

        $Product->refresh();

        //no more product
        $this->assertDatabaseHas('products', [
            'id' => $Product->id,
            'quantity' => 0
        ]);

        #assert I have an invoice
        #$this->assert

        #asserting I have some invoice item
        $this->assertDatabaseHas('invoice_items', [
            'total_amount' => 800
        ]);
    }
}
