<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function products(Request $request)
    {
        return $this->products->getProducts($request);
    }
}
