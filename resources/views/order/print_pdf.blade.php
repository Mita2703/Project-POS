{{-- <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice {{ $order->invoice }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h2, h4, p { margin: 0; padding: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background: #f2f2f2; }
    .text-end { text-align: right; }
    .text-center { text-align: center; }
  </style>
</head>
<body>
  <h2 style="text-align:center;">INVOICE</h2>
  <p style="text-align:center;">{{ $order->invoice }}</p>
  <hr>

  <p><strong>Member:</strong> {{ $order->member->name ?? '—' }}</p>
  <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

  <table>
    <thead>
      <tr>
        <th>Produk</th>
        <th width="60">Qty</th>
        <th width="100">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach($details as $d)
      <tr>
        <td>{{ $products[$d->product_id]->name ?? 'Produk #' . $d->product_id }}</td>
        <td class="text-center">{{ $d->quantity }}</td>
        <td class="text-end">Rp {{ number_format($d->price, 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="text-end"><strong>Total:</strong></td>
        <td class="text-end"><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
      </tr>
    </tfoot>
  </table>

  <p style="margin-top:20px;text-align:center;">Terima kasih telah berbelanja!</p>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $order->invoice }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        .title {
            text-align: center;
            margin-bottom: 10px;
        }
        .invoice-box {
            width: 100%;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px;
        }
        th {
            background: #f0f0f0;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .mt-2 { margin-top: 10px; }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="title">
        <h2>INVOICE</h2>
        <small>{{ $order->invoice }}</small>
    </div>

    <p><strong>Member:</strong> {{ $order->member->name ?? '-' }}</p>
    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr class="text-center">
                <th>Produk</th>
                <th width="60">Qty</th>
                <th width="100">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $d)
            <tr>
                <td>{{ $products[$d->product_id]->name ?? 'Produk #' . $d->product_id }}</td>
                <td class="text-center">{{ $d->quantity }}</td>
                <td class="text-right">Rp {{ number_format($d->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right"><strong>Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>
