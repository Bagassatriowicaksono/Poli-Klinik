<x-layouts.app title="Data Dokter">
   <h1>Selamat Datang Dokter</h1>
<form method="POST" action="/logout">
    @csrf
    <button>Logout</button>
</form>
</x-layouts.app>