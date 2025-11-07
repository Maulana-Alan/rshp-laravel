<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'RSHP Unair')</title>
</head>
<body bgcolor="#f4f4f4">

    <table width="100%" bgcolor="#003366" cellpadding="10">
        <tr>
            <td align="center">
                <img src="{{ asset('gambar/UNIVERSITAS-AIRLANGGA-scaled.jpg') }}" width="500" style="background-color: white;">
                <font color="white">
                    <h1>Selamat Datang di Rumah Sakit Hewan Pendidikan (RSHP)</h1>
                    <h2>Universitas Airlangga</h2>
                </font>
            </td>
        </tr>
    </table>

    <table width="100%" bgcolor="#ffcc00" cellpadding="10">
        <tr align="center">
            <td width="20%"><b><a href="{{ route('home') }}">HOME</a></b></td>
            <td width="20%"><a href="{{ route('struktur') }}">STRUKTUR ORGANISASI</a></td>
            <td width="20%"><a href="{{ route('layanan') }}">LAYANAN & DOKTER</a></td>
            <td width="20%"><a href="{{ route('visimisi') }}">VISI & MISI</a></td>
            <td width="20%"><a href="{{ route('login') }}">LOGIN</a></td>
            </tr>
    </table>

    <main>
        @yield('content')
    </main>

    </body>
</html>






























