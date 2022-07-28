@extends('layouts.master')

@section('title')
    Notification
@endsection

@section('breadcrumb')
@parent
<li class="active">Notification</li>
@endsection

@section('content')
 <div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_unread" data-url="{{ route('notifications.show',['read_at'=>'unread']) }}">Belum dibaca</a></li>
                <li><a href="#tab_read" data-url="{{ route('notifications.show',['read_at'=>'read']) }}">Sudah dibaca</a></li>
                <li><a href="#tab_all" data-url="{{ route('notifications.show',['read_at'=>'all']) }}">Semua</a></li>
            </ul>
            <div class="tab-content" style="position: relative;">
                <div id="spinner"><div></div><div></div></div>
                <div class="tab-pane active" id="tab_all">
                    @include('notification.load_content')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_read">
                    <!-- /.tab-pane body -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_unread">
                </div>
            <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
        </div>
    <!-- /.col -->
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function () {

    // Load HTML ketika klik pagination
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();

        $('#spinner').addClass('lds-ripple')
        let url = $(this).attr('href');
        let element = $(this).closest('.tab-pane.active');
        element.attr('style', 'visibility: hidden')
        getNotification(
            url,
            function (data) {
                $(element).html(data);
                $('#spinner').removeClass('lds-ripple')
                $(element).attr('style', 'visibility: visible')
            }
        );
        window.history.pushState("", "", url);
    });

    // Pindah tab pane
    $('.nav-tabs li a').click(function (e) {
        e.preventDefault();
        let element = $(this).attr('href'); // ambil id dari href link yang diklik
        let url = $(this).attr('data-url'); // ambil data url dari link yang diklik
        $(this).tab('show'); //tampilkan body tab

        let tab_pane = $(this).closest('.tab-pane.active');
        tab_pane.attr('style', 'visibility: hidden')
        $('#spinner').addClass('lds-ripple')
        getNotification(
            url,
            function (data) {
                $(element).html(data);
                $('#spinner').removeClass('lds-ripple')
                $(tab_pane).attr('style', 'visibility: visible')
            }
        );
    });
});
function getNotification(url, callback) {
    $.ajax({
        url : url
    }).done(callback)
    .fail(function () {
        alert('Notification gagal diload.');
    });
}
</script>
@endpush
