<div class="row">
    <div class="col-md-12">
        @if ($notifications->isEmpty())
            <h4 style="display: flex; justify-content: center">Belum ada Notifikasi</h4>
        @endif
        <!-- The time line -->
        <ul class="timeline">
        @foreach ($notifications as $notification)
        <!-- /.timeline-label -->
        <!-- timeline item -->
        @php
        $bg_color = '';
        if (is_null($notification->read_at)) {
            $bg_color = 'bg-blue';
        } else {
            $bg_color = 'bg-secondary';
        }
        $read_at = $notification->read_at;
        $title = explode('\\',$notification->type)[2];
        $data = json_decode($notification->data);
        $arrData = json_decode(json_encode($data->attributes[0]), true);
        @endphp
        <li>
            <i class="fa fa-circle {{ $bg_color }}"></i>

            <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> {{ $notification->created_at }}</span>

            <h3 class="timeline-header"><a href="#">{{ $title }}</a> - {!! is_null($read_at) ? '<i class="bg-primary" style="border-radius: 25% 10%; padding: 3px 5px">belum dibaca</i>' : '<i>sudah dibaca</i>' !!}</h3>

            <div class="timeline-body">
                Notification {{ $title }} dengan keterangan <br>
                @foreach ($arrData as $key => $value)
                    @if (!is_array($value))
                    {{ $key.' dengan nilai = '.$value }} <br>
                    @endif
                @endforeach
            </div>
            <div class="timeline-footer">
            @if (is_null($read_at))
                <a class="btn btn-primary btn-xs" href="{{ route('notifications.markAsRead', $notification) }}">mark as read</a>
                @endif
                <a class="btn btn-success btn-xs" href="{{ route('notifications.markAsRead', ['notifications' => $notification, 'redirect' => true]) }}">cek notification</a>
            </div>
            </div>
        </li>
        @endforeach
        </ul>
    </div>
</div>
{{ $notifications->links() }}
