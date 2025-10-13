<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Admin Dashboard' }}</title>

  {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  @vite(['resources/js/app.js', 'resources/css/app.css'])

  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.2/css/all.min.css"
    integrity="sha512-EVx4w8ARkAqW0n4a5cIL/fA1bD0JbxdCroxvdJxFLshCSkR5PBfeaCR5Hw/U6SL2LNlvuk/s9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHSD9e5MhA1yIdnLMwLD69Npvy4H1+N" crossorigin="anonymous">
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('components.partials.sidebar')
    <div class="content-wrapper">
      @include('components.partials.header')
      {{ $slot }}
    </div>
    @include('components.partials.footer')
  </div>

  {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YeM4G+5sZh9E6M0v6s0KFF9fZ6OFwMdVmC1Hc5NT5vvSaNCDpPu1T9qvDydxhb2Pp5iiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
  @stack('scripts')
</body>
</html>
