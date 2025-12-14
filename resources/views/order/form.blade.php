<br>
<h2>Aplikasi POS</h2>
<hr>
  <!-- Produk per Kategori -->
  @foreach ($categories as $category)
    <h5 class="mb-2 mt-3 text-secondary">{{ $category->name }}</h5>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 item-product">
      @forelse ($category->products as $product)
      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body p-2 d-flex flex-column justify-content-between">

            <h6 class="card-title mb-1" style="margin:0; font-size:0.95rem;">
              {{ $product->name }}
            </h6>

            <div class="text-muted small">
              Rp {{ number_format($product->price, 2, ',', '.') }}
            </div>

            <div class="d-flex justify-content-end align-items-center mt-2">
              <input 
                type="hidden" 
                class="id_product" 
                value="{{ $product->id }}" 
                data-price="{{ $product->price }}">
              <button 
                class="btn btn-sm btn-outline-primary btn-add">
                <span class="small">Add</span>
              </button>
            </div>

          </div>
        </div>
      </div>
      @empty
        <p class="text-muted fst-italic">Belum ada produk dalam kategori ini.</p>
      @endforelse
    </div>
  @endforeach


  <!-- Modal Konfirmasi -->
  <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Pesanan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          Total yang harus dibayar: <strong id="confirm-total"></strong>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Batal
          </button>

          <button type="button" id="confirm-submit-btn" class="btn btn-primary">
            Kirim
          </button>
        </div>

      </div>
    </div>
  </div>

</form>