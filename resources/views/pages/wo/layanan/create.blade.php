@extends ('layouts.app')

@section('title', 'Layanan')

@section('content')

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
                <div class="card-body">
                    <form action="{{ route('layanan-wo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="nama_paket">Nama Layanan</label>
                                    <input type="text" class="form-control
                                    @error('nama_paket') is-invalid @enderror"
                                    name="nama_paket" id="nama_paket" value="{{ old('nama_paket') }}"
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
                                    name="harga" id="harga" value="{{ old('harga') }}"
                                    placeholder="Masukkan Harga" required>
                                    @error('harga')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>
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
                                name="thumbnail[]" id="thumbnail" value="{{ old('thumbnail') }}" multiple required>
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

        //preview image before upload
        if($('#thumbnail').length > 0){
            $('#thumbnail').change(function(){
                var totalFile = document.getElementById('thumbnail').files.length;
                for(var i = 0; i < totalFile; i++){
                    $('#preview-thumbnail').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' class='img-thumbnail'>");
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