<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Category;
use App\Models\Product;
use App\Models\Member;
use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman utama pemesanan.
     */
    public function index()
    {
        $data['categories'] = Category::get();
        $data['members'] = Member::get();
        return view('order.index')->with($data);
    }

    /**
     * Simpan order baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'order_payload' => 'required|string',
        ]);

        $payload = json_decode($validated['order_payload'], true);

        if (!is_array($payload) || empty($payload['items'])) {
            return back()->with('error', 'Data order tidak valid atau kosong.');
        }

        DB::beginTransaction();

        try {
            // Cari user yang login
            $userId = Auth::id();
            
            // Jika tidak ada user yang login, cari user pertama
            if (!$userId) {
                $user = User::first();
                if (!$user) {
                    // Buat user default jika tidak ada sama sekali
                    $user = User::create([
                        'name' => 'System User',
                        'email' => 'system@pos.com',
                        'password' => bcrypt('password'),
                    ]);
                }
                $userId = $user->id;
            }

            $order = new Order();
            $order->invoice = 'INV' . now()->format('YmdHis');
            $order->total = $payload['total'] ?? collect($payload['items'])
                ->sum(fn($item) => $item['price'] * $item['qty']);
            $order->user_id = $userId;
            $order->member_id = $validated['member_id'];
            $order->save();

            foreach ($payload['items'] as $item) {
                if (empty($item['id']) || empty($item['qty']) || empty($item['price'])) {
                    throw new \Exception('Format item tidak valid.');
                }

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['qty'],
                    'price'      => $item['price'] * $item['qty'],
                ]);
            }

            DB::commit();

            // Kalau lewat AJAX (JavaScript)
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order berhasil disimpan.',
                    'print_url' => route('order.print', $order->id),
                    'pdf_url' => route('order.pdf', $order->id),
                ]);
            }

            // Kalau bukan AJAX
            return redirect()
                ->route('order.print', $order->id)
                ->with('success', 'Order berhasil disimpan.');

        } catch (\Throwable $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan order: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal menyimpan order: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan faktur (print view).
     */
    public function print(Order $order)
    {
        $details = OrderDetail::where('order_id', $order->id)->get();
        $productIds = $details->pluck('product_id')->unique()->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $member = Member::find($order->member_id);

        return view('order.print', [
            'order' => $order,
            'details' => $details,
            'products' => $products,
            'member' => $member,
        ]);
    }

    /**
     * Download faktur dalam bentuk PDF.
     */
    public function pdf(Order $order)
    {
        $details = OrderDetail::where('order_id', $order->id)->get();
        $productIds = $details->pluck('product_id')->unique()->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $member = Member::find($order->member_id);

        $pdf = Pdf::loadView('order.print_pdf', [
            'order' => $order,
            'details' => $details,
            'products' => $products,
            'member' => $member,
        ]);

        return $pdf->download($order->invoice . '.pdf');
    }

    /**
     * Tampilkan invoice.
     */
    public function invoice($id)
    {
        $order = Order::with('member')->findOrFail($id);
        $details = OrderDetail::where('order_id', $id)->get();
        $products = Product::whereIn('id', $details->pluck('product_id'))->get()->keyBy('id');

        return view('order.invoice', compact('order', 'details', 'products'));
    }
}