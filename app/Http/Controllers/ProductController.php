<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function checkout(Cart $cart){
        $service = new ProductServiceProvider;

        $service->processPurchase($product, $user);
    }
}
