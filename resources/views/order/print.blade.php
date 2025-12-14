@extends('template.layout')

@section('content')
<div class="container mt-4" id="invoice-area">
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="text-center mb-3">
        <h4 class="mb-0">INVOICE</h4>
        <small>{{ $order->invoice }}</small>
        <hr>
      </div>

      <div class="mb-3">
        <p><strong>Member:</strong> {{ $order->member->name ?? '—' }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
      </div>

      <table class="table table-sm table-bordered align-middle">
        <thead class="table-light">
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

      <div class="mt-3 d-flex justify-content-between">
        <a href="{{ url('order') }}" class="btn btn-secondary btn-sm">Kembali</a>
        <button id="print-now" class="btn btn-primary btn-sm">Print</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  // auto print on load
  window.addEventListener('load', function() {
    setTimeout(() => window.print(), 500)
  })

  // manual print
  document.getElementById('print-now').addEventListener('click', () => window.print())
</script>

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #invoice-area, #invoice-area * {
    visibility: visible;
  }
  #invoice-area {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
  #print-now, .btn-secondary {
    display: none !important;
  }
}
</style>
@endpush
