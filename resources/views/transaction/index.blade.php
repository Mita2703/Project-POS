@extends('template.layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid"></div>
</section>

<!-- Main content -->
<section class="content">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" id="nav-data" data-toggle="collapse" href="#dataTransaction" role="button" aria-expanded="false" aria-controls="collapseExample">
        Data Transaksi
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="nav-form" data-toggle="collapse" href="#formTransaction" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fas fa-plus nav-icon"></i>&nbsp;Pesanan Baru
      </a>
    </li>
  </ul>

  <div class="card" style="border-top:0px">
    <form action="transaction" method="post">
        @include('transaction.form')
        @include('transaction.data')

        <input type="hidden" name="id_member" id="id_member">
    </form>
  </div>
</section>
<!-- /.content -->
@endsection


@push('scripts')
    <script>
        // Script untuk #menu data dan form transaksi
        $('#dataTransaction').collapse('show')

        $('#dataTransaction').on('show.bs.collapse', function(){
            $('#formTransaction').collapse('hide');
            $('#nav-form').removeClass('active');
            $('#nav-data').addClass('active');
        })

        $('#formTransaction').on('show.bs.collapse', function(){
            $('#dataTransaction').collapse('hide');
            $('#nav-data').removeClass('active');
            $('#nav-form').addClass('active');
        })

        //Initialize
        $(function() {
            $('#tblMember').DataTable();
        })
        //end of initialize


        $('#tblMember').on('click','.pilihMemberBtn', function(){
            pilihMember(this)
            $('#modalMember').modal('hide')
        })
        //

        //function pilih member
        function pilihMember(x){
            const tr = $(x).closest('tr')
            const namaJK = tr.find('td:eq(1)').text()+"/"+tr.find('td:eq(2)').text()
            const idMember = tr.find('.idMember').val()
            $('#nama-pelanggan').text(namaJK)
            $('#id_member').val(idMember)
        }
        //

        //end #menu
    </script>
@endpush

