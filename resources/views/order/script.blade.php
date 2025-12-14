{{-- <script> 
  $(function(){ 
    // array untuk menyimpan daftar pesanan sementara 
    const orderedList = [] 
    // variabel untuk total 
    let total = 0 
 
    const $submitBtn = $('#submit-order') 
    // helper: update total cell, hidden payload and submit button state 
    // format number to Indonesian Rupiah style for display, keep payload numeric 
    const fmtRp = (n) => { 
      try{ 
        return 'Rp ' + Number(n).toLocaleString('id-ID') 
      }catch(e){ 
        return n 
      } 
    } 
 
    function refreshCartState(){ 
      const totalSum = orderedList.reduce((s, it) => s + Number(it.price), 0) 
      // display formatted total 
      $('#total-cell').text(fmtRp(totalSum)) 
      // payload stays numeric 
      $('#order_payload').val(JSON.stringify({items: orderedList, total: totalSum})) 
      // disable submit when cart empty 
      $submitBtn.prop('disabled', orderedList.length === 0) 
    } 
 
    // initially disable submit (no items) 
    $submitBtn.prop('disabled', true) 
 
    // pasang event handler klik pada setiap tombol tambah 
    $('.btn-add').on('click',function(e){ 
      e.preventDefault() 
      // ambil data dari card terdekat 
      const $card = $(this).closest('.card-body') 
      const name = $card.find('.card-title').text().trim() 
      // read numeric price from data-price on hidden input (set in blade) 
      const price = Number($card.find('.id_product').data('price')) 
      // jadikan id sebagai Number agar perbandingan konsisten 
      const id = Number($card.find('.id_product').val()) 
 
      // jika orderedList belum berisi item dengan id tersebut, tambahkan baris baru 
      if(orderedList.every(list => list.id !== id)){ 
        // simpan unitPrice terpisah untuk perhitungan total nanti 
        let dataN = {'id' : id, 'name' : name, 'qty' :1, 'unitPrice' : price, 'price' : price} 
        orderedList.push(dataN) 
        // buat baris tabel dengan data-id dan kelas untuk kolom qty/price agar mudah diupdate 
        let order = ` 
          <tr data-id="${id}"> 
            <td>${name}</td> 
            <td class="qty">1</td> 
            <td class="price">${fmtRp(price)}</td> 
          </tr>` 
        $('#tbl-cart tbody').append(order) 
      }else{ 
        // jika item sudah ada, cari index-nya lalu update qty dan total price di orderedList 
        const index = orderedList.findIndex(list => list.id === id) 
        // tingkatkan jumlah (qty) 
        orderedList[index].qty += 1 
        // hitung total berdasarkan unitPrice (hindari mengalikan total dengan qty) 
        orderedList[index].price = orderedList[index].qty * orderedList[index].unitPrice 
 
        // update tampilan di tabel: temukan <tr> dengan data-id yang sama lalu update kolom qty dan price 
        const $row = $(`#tbl-cart tbody tr[data-id="${id}"]`) 
        if($row.length){ 
          $row.find('.qty').text(orderedList[index].qty) 
          $row.find('.price').text(fmtRp(orderedList[index].price)) 
        } 
      } 
 
      // common: refresh totals/payload and enable submit if needed 
      refreshCartState() 
      // debug: tunjukkan orderedList terbaru 
      console.log(orderedList) 
    }) 
 
    // when clicking the submit button, show confirmation modal (Bootstrap 5) 
    $('#submit-order').on('click', function(e){ 
      if(orderedList.length === 0){ 
        alert('Keranjang kosong. Tambahkan produk terlebih dahulu.') 
        return 
      } 
      // show total in modal 
      $('#confirm-total').text(fmtRp(orderedList.reduce((s, it) => s + Number(it.price), 0))) 
      const confirmModal = new bootstrap.Modal(document.getElementById('confirmSubmitModal')) 
      confirmModal.show() 
    }) 
 
    // when user confirms in modal, submit the form via AJAX so we can show success/error inline 
    $('#confirm-submit-btn').on('click', function(){ 
      const $btn = $(this) 
      $btn.prop('disabled', true).text('Mengirim...') 
 
      const form = document.getElementById('order-form') 
      const fd = new FormData(form) 
 
      fetch(form.action, { 
        method: 'POST', 
        headers: { 
          'X-Requested-With': 'XMLHttpRequest' 
        }, 
        body: fd, 
        credentials: 'same-origin' 
      }) 
      .then(async res => { 
        const contentType = res.headers.get('content-type') || '' 
        let data = null 
        if(contentType.includes('application/json')){ 
          data = await res.json() 
        } else { 
          // fallback: treat as text 
          data = {success: res.ok} 
        } 
 
        if(!res.ok || (data && data.success === false)){ 
          const msg = (data && data.message) ? data.message : 'Failed to save order' 
          // show error to user 
          alert(msg) 
          $btn.prop('disabled', false).text('Kirim') 
          return 
        } 
 
        // success: redirect to print URL if provided, otherwise reload 
        if(data && data.print_url){ 
          window.location.href = data.print_url 
        } else { 
          window.location.reload() 
        } 
      }) 
      .catch(err => { 
        console.error(err) 
        alert('Terjadi kesalahan saat mengirim pesanan. ' + (err.message || '')) 
        $btn.prop('disabled', false).text('Kirim') 
      }) 
    }) 
  }) 
</script> --}}

<script>
$(function(){
  const orderedList = []
  const $submitBtn = $('#submit-order')
  const fmtRp = (n) => 'Rp ' + Number(n).toLocaleString('id-ID')

  // Hitung ulang total & update hidden input
  function refreshCartState(){
    const totalSum = orderedList.reduce((s, it) => s + Number(it.price), 0)
    $('#total-cell').text(fmtRp(totalSum))
    // simpan ke hidden input agar dikirim ke backend
    $('#order_payload').val(JSON.stringify({
      items: orderedList,
      total: totalSum
    }))
    $submitBtn.prop('disabled', orderedList.length === 0)
  }

  $submitBtn.prop('disabled', true)

  // Tambahkan produk ke keranjang
  $('.btn-add').on('click', function(e){
    e.preventDefault()
    const $card = $(this).closest('.card-body')
    const name = $card.find('.card-title').text().trim()
    const id = Number($card.find('.id_product').val())
    const price = Number($card.find('.id_product').data('price'))

    if (isNaN(price)) {
      console.error('Harga tidak valid untuk produk:', name)
      return
    }

    // Cek apakah produk sudah ada di keranjang
    const existing = orderedList.find(it => it.id === id)
    if (!existing) {
      const data = { id, name, qty: 1, unitPrice: price, price: price }
      orderedList.push(data)
      $('#tbl-cart tbody').append(`
        <tr data-id="${id}">
          <td>${name}</td>
          <td class="qty">${data.qty}</td>
          <td class="price">${fmtRp(price)}</td>
        </tr>
      `)
    } else {
      existing.qty++
      existing.price = existing.qty * existing.unitPrice
      const $row = $(`#tbl-cart tbody tr[data-id="${id}"]`)
      $row.find('.qty').text(existing.qty)
      $row.find('.price').text(fmtRp(existing.price))
    }

    refreshCartState()
  })

  // Klik tombol submit order (tampilkan modal konfirmasi)
  $('#submit-order').on('click', function(){
    if (orderedList.length === 0) {
      alert('Keranjang kosong!')
      return
    }

    const total = orderedList.reduce((s, it) => s + Number(it.price), 0)
    $('#confirm-total').text(fmtRp(total))

    const modal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'))
    modal.show()
  })

  // Konfirmasi & kirim order ke server
  $('#confirm-submit-btn').on('click', function(){
    const $btn = $(this)
    const customerId = $('#member_id').val()

    if (!customerId) {
      alert('Pilih member terlebih dahulu!')
      return
    }

    if (orderedList.length === 0) {
      alert('Keranjang kosong!')
      return
    }

    $btn.prop('disabled', true).text('Mengirim...')

    const form = document.getElementById('order-form')
    const fd = new FormData(form)

    // kirim pakai fetch
    fetch(form.action, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: fd,
      credentials: 'same-origin'
    })
    .then(async res => {
      let data = {}
      try { data = await res.json() } catch {}

      if (!res.ok || data.success === false) {
        alert(data.message || 'Gagal menyimpan pesanan')
        $btn.prop('disabled', false).text('Kirim')
        return
      }

      // sukses — tampilkan alert / redirect
      alert('Pesanan berhasil disimpan!')
      if (data.print_url) {
        window.location.href = data.print_url
      } else {
        window.location.reload()
      }
    })
    .catch(err => {
      console.error(err)
      alert('Terjadi kesalahan: ' + err.message)
      $btn.prop('disabled', false).text('Kirim')
    })
  })
})
</script>

