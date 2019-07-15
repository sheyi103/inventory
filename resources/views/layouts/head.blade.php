<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'JU') }} - @yield('title')</title>

{{-- Favicion Icon --}}
<link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet">
