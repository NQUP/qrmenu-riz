<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = trim((string) $request->query('status', ''));

        $query = Order::query();

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if (in_array($status, ['baru', 'diproses', 'selesai', 'batal'], true)) {
            $query->where('status', $status);
        }

        $orders = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order,
            'items' => $this->decodeItems($order->items),
        ]);
    }

    public function confirm(Order $order): RedirectResponse
    {
        if ($order->status !== 'baru') {
            return back()->with('error', 'Pesanan ini tidak berada pada status baru.');
        }

        $order->update(['status' => 'diproses']);

        $phone = $this->normalizePhone($order->phone);
        if (! $phone) {
            return redirect()
                ->route('admin.orders.show', $order)
                ->with('success', 'Pesanan dikonfirmasi, tetapi nomor telepon tidak valid untuk WhatsApp.');
        }

        $total = (float) ($order->total ?? 0);
        $message = 'Pesanan telah selesai dibuat, mohon ambil dan bayar di meja kasir dengan total Rp ' . number_format($total, 0, ',', '.');
        $url = 'https://wa.me/' . $phone . '?text=' . urlencode($message);

        return redirect()->away($url);
    }

    public function complete(Order $order): RedirectResponse
    {
        if ($order->status !== 'diproses') {
            return back()->with('error', 'Pesanan ini belum bisa diselesaikan.');
        }

        $order->update(['status' => 'selesai']);

        return back()->with('success', 'Pesanan ditandai selesai. Total masuk ke pendapatan dashboard.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    private function decodeItems(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        $items = json_decode((string) $value, true);

        return is_array($items) ? $items : [];
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);
        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '8')) {
            return '62' . $digits;
        }

        return $digits;
    }
}
