<?php

namespace App\DataWrappers;

use App\Models\Product;
use Exception;

class Cart
{
    protected $products = [];

    public function add(Product $product,  float $quantity, array $meta = []): void
    {
        if($product->quanity < $quantity)
            throw new Exception('Not enough product quantity');
            
        if (isset($this->products[$product->id])) {
            $product[$product->id]['quantity'] += $quantity;
            array_merge($product[$product->id]['meta'], $meta);
        } else {
            $this->products[$product->id] = [
                'quantity' => $quantity,
                'meta' => $meta
            ];
        }
    }

    protected function remove(Product $product, float $quantity, array $meta = []): bool
    {
        if (!isset($this->products[$product->id]))
            return false;


        #check quantity isn't more than
        $this->products[$product->id]['quantity'] -= $quantity;

        return true;
    }

    public function empty(): void
    {
        $this->products = [];
    }

    public function getproducts(): array
    {
        return $this->products;
    }
}
