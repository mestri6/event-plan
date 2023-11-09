@extends ('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="row">
              <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Layanan</h4>
                                <a href="{{ route('layanan-wo.create') }}" class="btn btn-primary ml-auto">
                                    <i class="mdi mdi-plus"></i>
                                    Tambah Layanan
                                </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb_layanan" class="table table-hover scroll-horizontal-vertikal w=100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Layanan</th>
                                        <th>Harga</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
              </div>
</div>
@endsection

@push('after-script')
    <script>
        $('#tb_layanan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url()->current() !!}',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'nama_paket', name: 'nama_paket'},
                {data: 'harga', name: 'harga'},
                {data: 'thumbnail', name: 'thumbnail'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        })
    </script>
@endpush