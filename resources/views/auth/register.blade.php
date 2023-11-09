@extends('layouts.auth')

@section('title', 'Pendaftaran')

@section('content')
<main class="main-content  mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-5 col-lg-5 col-md-5 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card shadow-lg">
                            <div class="card-header pb-0 text-center">
                                <img src="{{ asset('assets/logo-eventplan.png') }}" class="img-fluid mb-3" style="max-height: 80px" alt="EventPlan" />

                                <h4 class="font-weight-bolder">Daftar Sekarang</h4>
                                <p class="mb-0">
                                    Masukan data diri anda untuk mendaftar pada sistem
                                </p>
                            </div>
                            <div class="card-body">
                                <form role="form" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input id="name" type="text"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                            placeholder="Nama Lengkap">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input id="email" type="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input id="password" type="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password"
                                            placeholder="Kata sandi">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input id="password-confirm" type="password"
                                            class="form-control form-control-lg" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="Konfirmasi kata sandi">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg btn-warning btn-lg w-100 mt-4 mb-0">Daftar
                                            Sekarang</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}"
                                        class="text-warning font-weight-bold">Masuk
                                        Sekarang</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection