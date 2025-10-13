<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Login' }}</title>

    {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-8vvBrAnXG9HSLJ/f7a1q0bQy2YdrcwdfJThBSlCR7PB8Fc51Ck+w/U5GJ4MZVLlx9kYxS9XAH9bg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-aOkaWFIFENlD7g0PKvIubICETPNea2dzip95cMHq1GnbVLnLD6Np941vN4="
        crossorigin="anonymous">

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed min-vh-100">
    {{ $slot }}

    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-89AJv6mH5J6NlU06Bjr3T0T6Gkqb2o5mKXp4YFvhH8abtTE1Pi6jizolucdIZ7YINkL84ez74O6+vEA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

    @stack('scripts')
</body>
</html>
