@extends('adminlte::page')

@section('title')
    Reports
@endsection

@section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Reports</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{Session::get('success')}}
                            </div>
                        @endif
                        
                        <div class="row">
                            <div id="filter-section" class="col-md-12">
                                <div class="card">
                                    <div class="card-header row" id="filterHeading" style="background-color: #eeeeef;">
                                        <div class="col-md-6">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                                                <i class="fa fa-filter"></i> Advanced Filter
                                                </button>
                                            </h5>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            
                                        </div>
                                    </div>

                                    <div id="collapseFilter" class="collapse" aria-labelledby="filterHeading" data-parent="#filter-section">
                                        <form method="POST" action="{{route('transaction.export_excel')}}" id="form-report">
                                            <div class="card-body">
                                                    @csrf
                                                    <div class="row">
                                                        <div id="reportrange">
                                                            <i class="fa fa-calendar"></i>&nbsp;
                                                            <span></span> <i class="fa fa-caret-down"></i>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="rangedate" id="rangedate">
                                                <br>
                                                <div class="row">
                                                    <button type="button" onclick="search()" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> Search</button> &nbsp; 
                                                    <button class="btn btn-success">
                                                        <i class="fas fa-file-excel"></i> Export
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped" id="report-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Code</th>
                                                        <th>Vehicle No</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>
                                                        <th>Hours</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                        <th>Time Created</th>
                                                        <th>Time Updated</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3"></div>
                        
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal-->
        <div class="modal fade" id="detailModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail of Transaction</h5>
                        <button type="button" class="btn btn-sm close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="contentModal" data-scroll="true" data-height="350"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default font-weight-bold" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush

@section('js')
<script type="text/javascript">
    $(function() {

        var start = moment().subtract(0, 'days'); // 0
		var end = moment(); // 0

        function cb(start, end) {
            if(start > 0 && end > 0) {
                $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

                var rangedate = start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD');
            } else {
                $('#reportrange span').html('All Data');
                var rangedate = '';
            }

            $('#rangedate').val(rangedate);
            search();
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate: moment(),
            showDropdowns: true,
            ranges: {
                'All': ['', ''],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);
    });
    
    function search() {
        $('#report-table').DataTable({
            destroy: true,
        }).destroy();

        $('#report-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: false,
            ajax: {
                url:"{{ route('transaction.getdata') }}",
                type:"GET",
                data:{
                    rangedate: $('#rangedate').val(),
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'code', name: 'code'},
                { data: 'vehicle_no', name: 'vehicle_no'},
                { data: 'check_in', name: 'check_in'},
                { data: 'check_out', name: 'check_out'},
                { data: 'hours', name: 'hours'},
                { data: 'price', name: 'price'},
                { data: 'total', name: 'total'},
                { data: 'created_at', name: 'created_at'},
                { data: 'updated_at', name: 'updated_at'},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [8, "desc"],
            columnDefs: [
                {
                    targets: [0, 10],
                    className: 'text-center'
                },
                
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }
        });
    }

    setTimeout(function() {
        $('.alert').delay(3000).slideUp(300);
    });

    function showDetail(id){
        $.ajax({
            type: "POST",
            url: "{{ route('transaction.show') }}",
            data: "id=" + id,
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){				
                $('#contentModal').html(data.html);
                $('#detailModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) { // if error occured
                alert("Error occured. "+jqXHR.status+" "+ textStatus +" "+" please try again");
            }
        });
    }

</script>
@stop