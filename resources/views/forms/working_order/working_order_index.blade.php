@extends('layouts.layout')

@section('auth')
<h4 class="pull-left page-title">Working Order</h4>
<ol class="breadcrumb pull-right">
    <li><a href="#">{{Auth::user()->name}}</a></li>
    <li class="active">Working Order</li>
</ol>
<div class="clearfix"></div>
@endsection

@section('content')
<div class="container">
    <div class="card-header">
        <div class="alert alert-danger" {{$hidden_status}}>{{$return_msg}}</div>
        <div class="btn-group" role="group">
            <div class="form-group">
                <button title="show/hide data filter options" type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#main-table-data-filter" aria-expanded="false" aria-controls="main-table-data-filter">{{ucfirst(__('data filter'))}}..</button>
                @if($access)
                <button type="button" name="create_new" id="create_new" class="btn btn-secondary" onclick="location.replace('{{url('form-input/working-order/create')}}');"><i class="fa fa-plus"></i> {{ucwords(__('Tambah Baru'))}}</button>
                @endif
            </div>
        </div>
    </div>

    <div class="collapse" id="main-table-data-filter">
        <div class="card card-body">
            <form method="POST" id="search-form" class="form" role="form">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        {{-- NOMOR WORK ORDER --}}
                        <div class="row mb-2">
                            <label class="col-md-2">NOMOR WORK ORDER</label>
                            <div class="col-md-6">
                                <input maxlength="50" id="wo_number" type="text" class="text-uppercase form-control" name="wo_number" title="NOMOR WORK ORDER" placeholder="NOMOR WORK ORDER">
                            </div>
                        </div>
                        <br>

                        {{-- NOMOR SPK --}}
                        <div class="row mb-2">
                            <label class="col-md-2">NOMOR SPK</label>
                            <div class="col-md-6">
                                <input maxlength="50" id="spk_number" type="text" class="text-uppercase form-control" name="spk_number" title="NOMOR SPK" placeholder="NOMOR SPK">
                            </div>
                        </div>
                        <br>

                        {{-- KATEGORI WORK ORDER --}}
                        <div class="row mb-2">
                            <label class="col-md-2">KATEGORI WORK ORDER</label>
                            <div class="col-md-6">
                                <select title="STATUS" id="wo_category" class="form-control">
                                    <option value="" selected>SEMUA KATEGORI</option>
                                    <option value="LAPORAN GANGGUAN">LAPORAN GANGGUAN</option>
                                    <option value="PEKERJAAN">PEKERJAAN</option>
                                </select>
                            </div>
                        </div>
                        <br>

                        {{-- DEPARTEMEN --}}
                        <div class="row mb-2">
                            <label class="col-md-2">DEPARTEMEN</label>
                            <div class="col-md-6">
                                <select title="DEPARTEMEN" id="department" class="form-control">
                                    <option value="" selected>SEMUA DEPARTEMEN</option>
                                    @foreach ($departments as $item)
                                        <option value={{ $item->id }}>{{ $item->department }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        {{-- STATUS WO --}}
                        <div class="row mb-2">
                            <label class="col-md-2">STATUS WORK ORDER</label>
                            <div class="col-md-6">
                                <select title="DEPARTEMEN" id="wo_status" class="form-control">
                                    <option value="" selected>SEMUA STATUS</option>
                                    @foreach ($wo_status as $item)
                                        <option value={{ $item->reff1 }}>{{ $item->reff1 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        <!-- {{-- LOKASI --}}
                        <div class="row mb-2">
                            <label class="col-md-2">LOKASI</label>
                            <div class="col-md-6">
                                <select title="LOKASI" id="location" class="form-control">
                                    <option value="" selected>SEMUA LOKASI</option>
                                    @foreach ($locations as $item)
                                        <option value={{ $item->id }}>{{ $item->location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->
                        <br>
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
                    <h3 class="panel-title">Data Work Order</h3>
                </div>
                <div class="panel-body">
                    <span id="form_result"></span>
                    <table id="main-table" class="table table-striped table-bordered " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Nomor WO</th>
                                <th>WO Kategori</th>
                                <th>Nomor SPK</th>
                                <th>Departemen</th>
                                <th>Kategori Pekerjaan</th>
                                <th>Status</th>
                                <th>Disetujui Oleh</th>
                                <th>Disetujui Pada</th>
                                <th>Pelapor</th>
                                <th>Tanggal Efektif</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->
</div>

<!-- Plugins js -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript') }}"></script>
<script src="{{ asset('plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript') }}"></script>
<script src="{{ asset('pages/form-advanced.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(function() {
        var oTable = $('#main-table').DataTable({
            filter: false,
            processing: true,
            serverSide: true,
            // deferLoading: 0, //disable auto load
            stateSave: false,
            // scrollY: 500,
            // scrollX: true,
            ordering: false,
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
                'url': "{!! route('form-input.working-order.dashboard-data') !!}",
                'type': 'POST',
                'headers': {
                    'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                },
                'data': function(d) {
                    d.wo_number = $('#wo_number').val();
                    d.spk_number = $('#spk_number').val();
                    d.wo_category = $('#wo_category').val();
                    d.department = $('#department').val();
                    d.wo_status = $('#wo_status').val();
                }
            },
            columns: [
                {data: 'action', name: 'action', orderable: false, searchable: false},
                {data: 'wo_number',              name: 'wo_number'                  },
                {data: 'wo_category',            name: 'wo_category'                },
                {data: 'spk_number',             name: 'spk_number'                 },
                {data: 'department',             name: 'department'                 },
                {data: 'job_category',           name: 'job_category'               },
                {data: 'status',                 name: 'status',                    },
                {data: 'approve_by',             name: 'approve_by',                },
                {data: 'approve_at',             name: 'approve_at',                },
                {name: 'created_by',             data: 'created_by',                },
                {data: 'effective_date',         name: 'effective_date',            },
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

    function showItem(id) {
        {
            var urlcek = "{{route('form-input.working-order.cekdetail', '')}}" + "/" + id;
            var urldet = "{{route('form-input.working-order.detail', '')}}" + "/" + id;
            $.ajax({
                url: urlcek,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                dataType: "json",
                data: id,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.errors) {
                        $('#form_result').html(data.message);
                        setTimeout(function() {
                            $('#form_result').html('');
                        }, 4000);
                    }
                    if (data.success) {
                        window.location.href = urldet;
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error Status:', status);
                    console.log('Error:', error);
                    console.log('Response:', xhr.responseText);
                    var html = '<div class="alert alert-danger">Terjadi kesalahan : ' + error + '</div>';
                    $('#form_result').html(html);
                }
            });
            // window.location.href = url;
        }
    }
</script>
@endsection