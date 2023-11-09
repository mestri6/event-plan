@extends ('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Edit Kategori Layanan</h4>
                </div>
            </div>
                <div class="card-body">
                    <form action="{{ route('kategori.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="nama">Nama Kategori</label>
                                    <input type="text" class="form-control
                                    @error('nama') is-invalid @enderror"
                                    name="nama" id="nama" value="{{ $item->nama }}">
                                    @errorr('nama')
                                    <div class="invalid-feedback">{{ $message }} </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                            <div class="row mt-5">
                                <div class="col-12 col-lg-12">
                                    <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary mr-2">
                                        Edit Kategori
                                    </button>
                                    <a href="{{ route('kategori.index') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
        </div>
    </div>
</div>

@andsection