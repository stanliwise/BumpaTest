<?php

namespace App\Services;

use App\DataWrappers\Cart;
use App\Events\PurchaseCompleted;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Exception;

class CashierService
{
    public function __construct()
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
     * Collate price in a basket
     * 
     * @return float
     */
    protected function collate_price(Cart $cart): float
    {
        $total_amount = 0;
        $product_ids = collect($cart->getproducts());

        if ($product_ids->isEmpty())
            return $total_amount;

        //eager load the products
        $products = $cart->eagerLoadProducts();

        foreach ($products as $product) {
            $total_amount += $product->price * $product_ids[$product->id]['quantity'];
        }

        return $total_amount;
    }

    protected function generateInvoice(User $user, Cart $cart, float $price, $comment = ''): Invoice
    {
        /**
         * @var Invoice
         */
        $invoice = Invoice::create([
            'total_amount' => $price,
            'grand_total' => $price,
            'comment' => '',
            'user_id' => $user->id
        ]);

        foreach ($cart->eagerLoadProducts() as $product) {
            $invoice->items()->create([
                'product_id' => $product->id,
                'per_item_price' => $product->price,
                'total_amount' => $product->price * $cart->getProductQuantity($product->id),
                'quantity' => $cart->getProductQuantity($product->id),
            ]);

            $product->forceFill([
                'quantity' => $product->quantity - $cart->getProductQuantity($product->id)
            ])->save();
        }

        return $invoice;
    }

    protected function processInvoice(Invoice $invoice)
    {
        if ($invoice->status == 'paid')
            return;

        #deduct user
        /**@var User */
        $user = $invoice->user;

        $balance_before = $user->amount;

        $user->forceFill(['amount' => $user->amount - $invoice->grand_total])->save();
        $invoice->update(['status' => 'paid']);
        $invoice->refresh();

        #record transaction
        $transaction = Transaction::create([
            'status' => 'successful',
            'amount' => $invoice->grand_total,
            'user_id' => $user->id,
            'type' => 'debit',
            'balance_before' => $balance_before,
            'balance_after' => $user->refresh()->amount,
        ]);
    }

    public function process(Cart $cart, User $user)
    {
        //pipeline
        $total_bill = $this->collate_price($cart);

        if ($user->amount < $total_bill)
            throw new Exception('Insufficient Balance to buy cart product');

        #TODO: this code should use a lock while generating invoice to mark out product

        /**
         * @var Invoice
         */
        $invoice = $this->generateInvoice($user, $cart, $total_bill);

        $this->processInvoice($invoice);

        PurchaseCompleted::dispatch($invoice);
        
        return $invoice;
    }
}
