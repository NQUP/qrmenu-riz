<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $product = null;
        $products = Product::where('is_active', true)->orderBy('name')->get();

        if ($request->filled('product')) {
            $product = Product::find($request->input('product'));
            //
        }

        return view('site.pages.order', [
            'product' => $product,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'table_number' => ['nullable', 'string', 'max:20'],
            'items_product_id' => ['required', 'array', 'min:1'],
            'items_product_id.*' => ['required', 'integer', 'exists:products,id'],
            'items_qty' => ['required', 'array', 'min:1'],
            'items_qty.*' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        $productIds = $data['items_product_id'];
        $qtys = $data['items_qty'];

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $items = [];
        $total = 0;

        foreach ($productIds as $index => $productId) {
            $product = $products->get((int) $productId);
            $qty = (int) ($qtys[$index] ?? 0);

            if (! $product || $qty < 1) {
                continue;
            }

            $subtotal = (float) $product->price * $qty;
            $total += $subtotal;

            $items[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        if (empty($items)) {
            return back()
                ->withErrors(['items_product_id' => 'Pilih minimal 1 produk.'])
                ->withInput();
        }

        Order::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
            'table_number' => $data['table_number'] ?? null,
            'items' => $items,
            'notes' => $data['notes'] ?? null,
            'total' => $total,
        ]);

        return redirect()
            ->route('orders.create')
            ->with('order_success', 'Pesanan berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}
