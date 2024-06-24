@extends('layouts.layout')

@section('auth')
<h4 class="pull-left page-title">Data Karyawan</h4>
<ol class="breadcrumb pull-right">
    <li><a href="#">{{Auth::user()->name}}</a></li>
    <li class="active">Data Karyawan</li>
</ol>
<div class="clearfix"></div>
@endsection

@section('content')
<div class="container">
    <div class="card-header">
        <div class="btn-group" role="group">
            <div class="form-group">
                <button title="show/hide data filter options" type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#main-table-data-filter" aria-expanded="false" aria-controls="main-table-data-filter">{{ucfirst(__('data filter'))}}..</button>
                <button type="button" name="create_new" id="create_new" class="btn btn-secondary" onclick="location.replace('{{url('masters/employee/create-new')}}');"><i class="fa fa-plus"></i> {{ucwords(__('New'))}}</button>
            </div>
        </div>
    </div>

    <div class="collapse" id="main-table-data-filter">
        <div class="card card-body">
            <form method="POST" id="search-form" class="form" role="form">
                <div class="panel panel-primary">
                    {{-- <div class="panel-heading">
                        <h3 class="panel-title">Form Header</h3>
                    </div> --}}

                    <div class="panel-body">
                        <div class="row mb-2">
                            <label class="col-md-2">NAMA KARYAWAN</label>
                            <div class="col-md-6">
                                <input id="employee_name" type="text" class="text-uppercase form-control" name="employee_name" title="NAMA KARYAWAN" placeholder="NAMA KARYAWAN">
                                <input name="employee_name_id" id="employee_name_id" type="hidden" />
                                <!-- <div class="input-group-append">
                                    <button class="btn btn-info" type="button" onclick="employeeName();"><i class="fa fa-ellipsis-h"></i></button>
                                </div> -->
                            </div>
                        </div>
                        <br>

                        {{-- NIK KARYAWAN --}}
                        <div class="row mb-2">
                            <label class="col-md-2">NIK KARYAWAN</label>
                            <div class="col-md-6">
                                <input id="employee_nik" type="text" class="text-uppercase form-control" name="employee_nik" title="NIK KARYAWAN" placeholder="NAMA KARYAWAN">
                                <!-- <input name="employee_name_id" id="employee_name_id" type="hidden" /> -->
                                <!-- <div class="input-group-append">
                                    <button class="btn btn-info" type="button" onclick="employeeName();"><i class="fa fa-ellipsis-h"></i></button>
                                </div> -->
                            </div>
                        </div>

                        <br>
                        <br>
                        {{-- SEARCH --}}
                        <div class="row">
                            <div class="col col-md-3"><button type="submit" class="btn btn-primary" title="search"><i class="fa fa-search"></i> {{ucwords(__('search'))}}</button> </div>
                        </div>
                    </div> <!-- panel-body -->
                </div> <!-- panel -->
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Data Karyawan</h3>
                </div>
                <div class="panel-body">
                    <table id="main-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th>Jenis Kelamin</th>
                                <th>Email</th>
                                <th>Tanggal Aktif</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->
</div>

<script>
    $(function() {
        var oTable = $('#main-table').DataTable({
            filter: false,
            processing: true,
            serverSide: true,
            // deferLoading: 0, //disable auto load
            stateSave: false,
            scrollY: 500,
            scrollX: true,
            language: {
                paginate: {
                    first: "<i class='fa fa-step-backward'></i>",
                    last: "<i class='fa fa-step-forward'></i>",
                    next: "<i class='fa fa-caret-right'></i>",
                    previous: "<i class='fa fa-caret-left'></i>"
                },
                lengthMenu: "<div class=\"input-group\">_MENU_ &nbsp; / page</div>",
                info: "_START_ to _END_ of _TOTAL_ item(s)",
                infoEmpty: ""
            },
            ajax: {
                'url': "{!! route('master/employee/dashboard-data') !!}",
                'type': 'POST',
                'headers': {
                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                },
                'data': function(d) {
                    d.employee_name = $('#employee_name').val();
                    d.employee_nik = $('#employee_nik').val();
                }
            },
            columns: [{
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'department',
                    name: 'department'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'start_effective',
                    name: 'start_effective',
                },
            ],
            // order: [[ 2, "desc" ]],
            rowCallback: function(row, data, iDisplayIndex) {
                var api = this.api();
                var info = api.page.info();
                var page = info.page;
                var length = info.length;
                var index = (page * length + (iDisplayIndex + 1));
                //    $('td:eq(1)', row).html(index);
            },
        });

        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });
    });
</script>
@endsection