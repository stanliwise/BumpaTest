<?php

namespace App\Services;

use App\DataWrappers\Cart;
use App\Events\PurchaseCompleted;
use App\Models\Product;
use App\Models\User;

class CashierService
{
    protected $walletService;
    protected $receiptService;

    public function __construct($walletService, $receiptService)
    {
    }

    /**
     * 
     */
    protected function validate_purchase(Cart $cart)
    {
        return true;
    }

    /**
     * 
     */
    protected function collate_price(Cart $cart)
    {
        $product_ids = collect($cart->getproducts());

        $products = Product::whereIn('id', [$product_ids])->get();

        foreach ($cart->getproducts() as $product) {
        }
    }

    public function process(Cart $cart, User $user)
    {
        //pipeline
        $this->validate_purchase($cart);
        $price = $this->collate_price($cart);
        $invoice = $this->InvoiceService->generate($cart, $price);
        $this->walletService->debit($user, $invoice->amount());
        #$this->InvoiceService->generate_receipt($invoice);

        PurchaseCompleted::dispatch($invoice);

        return true;
    }
}
