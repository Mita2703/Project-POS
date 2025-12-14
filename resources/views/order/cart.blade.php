{{-- <form action="order-form" method="POST" action="{{ url ('order') }}">
    @csrf
    <div class="mb-2">
        <label for="customer_id" class="form-label">Pelanggan</label>
        <select name="customer_id" id="customer_id" class="form-select form-select-sm">
            @foreach ($members as $c)
            <option value="{{ $c -> id }}">{{ $c -> name }}</option>
            @endforeach
        </select>
    </div>

    <table class="table table-sm align-middle" id="tbl-cart">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-end"><strong>Total</strong></td>
            <td id="total-cell">0</td>
        </tr>
    </tfoot>
</table>

    <input type="hidden" name="order_payload" id="order_payload" value="">
    <button type="submit" id="submit-order" class="btn btn-success">Submit Order</button>
</form> --}}

{{-- <form id="order-form" method="POST" action="{{ url('order') }}">
    @csrf
    <div class="mb-2">
        <label for="customer_id" class="form-label">Pelanggan</label>
        <select name="customer_id" id="customer_id" class="form-select form-select-sm">
            @foreach($customers as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div> --}}
{{-- 
<form id="order-form" method="POST" action="{{ url('order') }}">
  @csrf
  <div class="mb-2">
    <label for="member_id" class="form-label">Pelanggan</label>
    <select name="member_id" id="member_id" class="form-select form-select-sm">
      @foreach($members as $c)
      <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <table class="table table-sm align-middle" id="tbl-cart">
    <thead>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="text-end"><strong>Total</strong></td>
        <td id="total-cell">0</td>
      </tr>
    </tfoot>
  </table>

  <input type="hidden" name="order_payload" id="order_payload" value="">
  <button type="submit" id="submit-order" class="btn btn-success">Submit Order</button>
</form> --}}

<form id="order-form" action="{{ url('order') }}" method="POST">
  @csrf

  <!-- PILIH MEMBER -->
  <div class="mb-3">
    <label for="member_id" class="form-label">Pilih Member</label>
      <select name="member_id" id="member_id" class="form-select" required>
      <option value="">....</option>
      @foreach ($members as $member)
        <option value="{{ $member->id }}">{{ $member->name }}</option>
      @endforeach
    </select>
  </div>

  <table id="tbl-cart" class="table table-sm align-middle">
    <thead>
      <tr>
        <th>Nama Produk</th>
        <th width="60">Qty</th>
        <th width="100">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <!-- isi produk via JS -->
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="text-end"><strong>Total:</strong></td>
        <td id="total-cell"><strong>Rp 0</strong></td>
      </tr>
    </tfoot>
  </table>

  <!-- HARUS pakai name="order_payload" -->
  <input type="hidden" id="order_payload" name="order_payload">

    <!-- Tombol Submit -->
  <button 
    type="button" 
    id="submit-order" 
    class="btn btn-success w-100 mt-2" 
    disabled>
    Submit Order
  </button>
</form>
