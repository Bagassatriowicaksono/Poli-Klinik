<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light ">Poliklinik</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://www.gravatar.com/avatar/2c7d9f6f281ecd3bd65ab915bca6dd57s=100"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Halo! {{ Auth::user()->nama }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- Menu untuk Role Pasien --}}
                @auth
                @if(auth()->user()->role === 'pasien')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pasien.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    {{-- ✅ LINK PENDAFTARAN POLI --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pasien.daftar') }}">
                            <i class="fas fa-edit"></i>
                            <span>Daftar Poli</span>
                        </a>
                    </li>
                @endif

                 @if(auth()->user()->role === 'dokter')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pasien.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    {{-- ✅ LINK PENDAFTARAN POLI --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pasien.daftar') }}">
                            <i class="fas fa-edit"></i>
                            <span>Jadwal periksa</span>
                        </a>
                    </li>
                @endif
                @endauth

                {{-- Tambahkan menu untuk role lain di sini --}}
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>