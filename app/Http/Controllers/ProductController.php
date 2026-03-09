<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Reactの動作確認を行いたいため、今は最小限の実装で記述
    public function index(Request $request)
    {
        $q = (string) $request->query('q', '');
        $onlyInStock = $request->boolean('onlyInStock');

        $query = Product::query();

        if ($q !== '') {
            $query->where('name', 'like', '%'.$q.'%');
        }

        if ($onlyInStock) {
            $query->where('stocked', true);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stocked' => ['sometimes', 'boolean'],
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }
}
