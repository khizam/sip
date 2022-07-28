<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{ config('app.name') }} | @yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  {{-- <link rel="icon" href="{{ url($setting->path_logo) }}" type="image/png"> --}}

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('template/bower_components/select2/dist/css/select2.min.css')}}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
      <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{asset('template/bower_components/Ionicons/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/spinner_ripple.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

  @includeIf('layouts.header')
  <!-- Left side column. contains the logo and sidebar -->
  @includeIf('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
      </h1>
      <ol class="breadcrumb">
      @section('breadcrumb')
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      @show
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- /.row -->
      @yield('content')
      <!-- Main row -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 @includeIf('layouts.footer')

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<!-- jQuery 3 -->
<script src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('template/bower_components/moment/min/moment.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
<!-- Validator -->
<script src="{{ asset('js/validator.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('template/bower_components/chart.js/Chart.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('template/dist/js/pages/dashboard2.js')}}"></script>

<script src="{{ asset('js/app.js') }}"></script>
{{-- <script src="{{ asset('js/pusher_channel.js') }}"></script> --}}
<script text="text/javascript" fetchpriority="high">
    let url_notification = "{{ route('notifications.index') }}";

    let role = {{ Auth::user()->roles->pluck('id')[0] }}

    if (role == {{ \App\Models\Enums\RolesEnum::Produksi }}) {
        Echo.private(`pushNotification.${role}`)
            .listen('.push.notification', (response) => {
                emptyElement();
                addElement(response.data);
            });
    }

    $(function () {
        $.get(url_notification)
        .done(function (data) {
            addElement(data);
        });
    });

    function addElement(data) {
        let element = `<span class="label label-warning" >${data.totalUnread}</span>`;
        let menu_element = '';
        data.unread.forEach(result => {
            let type = result.type.split('\\');
            menu_element += `
                <li>
                    <a href="{{ url('/notifications/mark-as-read/${result.id}/true') }}">
                        <i class="fa fa-bell text-yellow"></i> ${type[2]}
                    </a>
                </li>`
        });
        $('#notification_user').after(element);
        $('.header_notification').text(`Kamu punya ${data.totalUnread} notification`);
        $('.menu_notification').append(menu_element);
    }

    function emptyElement() {
        $('.menu_notification').empty();
        $('#notification_user').next('span').remove();
        $('.header_notification').empty();
     }

</script>
@stack('scripts')
</body>
</html>
