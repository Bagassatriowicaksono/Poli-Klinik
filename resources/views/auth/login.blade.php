<x-layouts.guest title="Login">
    <div class="login-box d-flex flex-column justify-content-center align-items-center w-100 vh-100">
        <div class="card card-outline card-primary shadow-lg" style="min-width: 360px;">
            <div class="card-header text-center">
                <h3 class="text-primary mb-0"><b>Poli</b>klinik</h3>
            </div>

            <div class="card-body">
                <p class="login-box-msg">Silakan login ke akun Anda</p>

                {{-- Tampilkan pesan error jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- Email --}}
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text bg-primary text-white">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text bg-primary text-white">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol login --}}
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>

                {{-- Link ke register --}}
                <div class="text-center mt-3">
                    <p>Belum punya akun?
                        <a href="{{ route('register') }}" class="text-primary font-weight-bold">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
