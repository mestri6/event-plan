@extends ('layouts.app')

@section('title', 'Edit Layanan')

@section('content')

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
                <div class="card-body">
                    <form action="{{ route('layanan-wo.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="nama_paket">Nama Layanan</label>
                                    <input type="text" class="form-control
                                    @error('nama_paket') is-invalid @enderror"
                                    name="nama_paket" id="nama_paket" value="{{ $item->nama_paket }}"
                                    placeholder="Masukkan Nama Paket" required>
                                    @error('nama_paket')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control
                                    @error('harga') is-invalid @enderror"
                                    name="harga" id="harga" value="{{ $item->harga }}"
                                    placeholder="Masukkan Harga" required>
                                    @error('harga')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3" id="gambarLama">
                        @forelse ($gallery as $item)
                            <div class="col-6 col-md-3 mb-3">
                                <figure class="figure gallery-container mb-3">
                                    <img src="{{ Storage::url($item->thumbnail) }}" class="w-100 img-fluid figure-img img-thumbnail" alt="">
                                    <a href="javascript:void(0)" onclick="hapusGambar({{ $item->id }});" class="delete-gallery">
                                        <img src="{{ asset('assets/images/ic_delete.svg') }}" class="img-fluid w-75 h-75" alt="icon-delete" />
                                    </a>
                            </figure>
                            </div>
                        @empty
                            <div class="col-md-12 mb-3">
                                <div class="text-center">
                                    <p>
                                        Anda Belum Memiliki Gambar Untuk Paket Ini
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="w-100 img-fluid" id="preview-thumbnail">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control
                                @error('thumbnail') is-invalid @enderror"
                                name="thumbnail[]" id="thumbnail" value="{{ old('thumbnail') }}" multiple >
                                @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }} </div>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="d--grid gap-2 d-flex">
                        <a href="{{ route('layanan-wo.index') }}" class="btn btn-danger col"> Batal </a>
                        <button type="submit" class="btn btn-primary col" id="btnSave">
                            Simpan
                        </button>
                    </div>
                    </form>
                </div>
        </div>
    </div>
</div>

@endsection

@push('after-script')
    <script>

        //memanggil formatRupiah
        $('#harga').val(formatRupiah($('#harga').val(), 'Rp. '));


        //preview image before upload
        if($('#thumbnail').length > 0){
            $('#thumbnail').change(function(){
                var totalFile = document.getElementById('thumbnail').files.length;
                for(var i = 0; i < totalFile; i++){
                    $('#preview-thumbnail').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' class='img-thumbnail'>");
                }
            })
        }

        //hapus gambar dgn tanda silang 
        function hapusGambar(id){
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Anda akan menghapus gambar ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('wo/layanan-wo/delete-gallery') }}/" + id,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(response){
                            Swal.fire(
                                'Berhasil!',
                                'Gambar berhasil dihapus',
                                'success'
                            ).then((result) => {
                                if(result.isConfirmed){
                                    location.reload();
                                }
                            })
                        },
                        error: function(xhr){
                            Swal.fire(
                                'Gagal!',
                                'Gambar gagal dihapus',
                                'error'
                            )
                        }
                    })
                }
            })
        }


        //format rupiah
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        var rupiah = document.getElementById('harga');
        rupiah.addEventListener('keyup', function(e){
            rupiah.value = formatRupiah(this.value, 'Rp. ');
        });
    </script>
@endpush

@push('after-style')
    <style>
        .gallery-container{
            position: relative !important;
        }

        .gallery-container .delete-gallery{
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1;
            transform: translate(25%, -25%);
        }
    </style>
@endpush