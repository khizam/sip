@extends('layouts.master')

@section('title')
    Log Activity
@endsection

@section('breadcrumb')
@parent
<li class="active">Log Activity</li>
@endsection

@section('content')

<div class="row">
      <div class="col-md-12">
        <div class="box">
        {{-- <div class="box-header with-border">
            <button type="button" onclick="deleteAll(`{{ route('log.delete_all') }}`)" class="btn btn-danger btn-xs" target="_blank">Hapus Log</a>
        </div> --}}
          <div class="box-body table-responsive">
            <table class="table table-striped table-bordered" style="table-layout: auto; width: 100%;">
              <thead>
                <th width="5%">No</th>
                <th width="10%">Log Name</th>
                <th width="10%">Description</th>
                <th width="10%">Type</th>
                <th width="10%">User</th>
                <th width="40%">Detail Perubahan</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
</div>

@includeIf('bahan.form')
@endsection

@push('scripts')

<script>
  let table;

    $(function () {
        table = $('.table').DataTable({
          processing: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('log.activity_data') }}',
            dataSrc: (result) => {
              return result.data.map((result) => {
                  let split = result.subject_type.split('\\')
                  result.subject_type = split[2]
                  result.properties = `Melakukan perubahan pada field = \n ${JSON.stringify(result.properties.attributes)}`
                  return result
                }
              )
            }
          },
          columns: [
            {data: 'DT_RowIndex', searchable: false, sortable: false},
            {data: 'log_name'},
            {data: 'description'},
            {data: 'subject_type'},
            {data: 'causer.name'},
            {data: 'properties'},
          ]
        });
    });

    // function deleteAll(url) {
    //     if(confirm("apakah semua log dihapus ?")) {
    //         location.href = url
    //     }
    //  }
</script>
@endpush
