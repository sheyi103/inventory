<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.head')
</head>
<body class="hold-transition sidebar-mini">
    <div id="app" class="wrapper">
        @include('layouts.nav')

        @include('layouts.sidebar')

        <div>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show session-message" role="alert">
                <strong>{{session('success')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show session-message" role="alert">
                <strong>{{session('warning')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @yield('content')
        </div>

        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <!-- jQuery -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/adminlte.js')}}"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{asset('js/demo.js')}}"></script>

    <!-- PAGE PLUGINS -->
    <!-- SparkLine -->
    <script src="{{asset('js/jquery.sparkline.min.js')}}"></script>
    <!-- jVectorMap -->
    <script src="{{asset('js/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
    <!-- ChartJS 1.0.2 -->
    <script src="{{asset('js/Chart.min.js')}}"></script>

    <!-- Data Table -->
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.js')}}"></script>

    <!-- Select 2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- JQuery Date Picker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>

        $(function() {

            //active class
            var url = window.location;

            //for sidebar menu entirely but not cover treeview
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');

            $("a.active").parent().parent().parent().addClass('menu-open');

            $('li.menu-open a.item').addClass('active');
        });  

    </script>
    @yield('script')
</body>
</html>    