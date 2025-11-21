<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
        </li>
        {{-- Tambahan Menu Profile yang tadi --}}
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('profile.edit') }}" class="nav-link">Edit Profile</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                {{-- Menampilkan Nama User yang Login --}}
                <span class="d-none d-md-inline ml-1 font-weight-bold">{{ Auth::user()->nama ?? 'User' }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Pengaturan Akun</span>
                <div class="dropdown-divider"></div>
                
                {{-- Menu Profile --}}
                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="fas fa-user-edit mr-2"></i> Edit Profile
                </a>

                <div class="dropdown-divider"></div>
                
                {{-- TOMBOL LOGOUT --}}
                <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> 
                    <strong>Logout</strong>
                </a>
                
                {{-- Form Rahasia buat Logout (Wajib ada di Laravel) --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>