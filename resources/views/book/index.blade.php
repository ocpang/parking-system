@extends('adminlte::page')

@section('title')
    Master Books
@endsection

@section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Master Books</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Master Books</li>
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header row">
                                        <div class="col-md-6">Create Master Book</div>
                                    </div>
                                    <div class="card-body">
                                        <form id="form_data" role="form" action="{{ route('book.save') }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                                        <div class="col-xl-12">
                                                            <div class="row justify-content-center">
                                                                <div class="col-xl-9">
                                                                    @if ($errors->any())
                                                                    <div class="alert alert-custom alert-outline-danger fade show mb-5" role="alert">
                                                                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                                                        <div class="alert-text">
                                                                            <p><strong>Whoops!</strong> There were several errors in your input :</p>
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    <!--begin::Group-->
                                                                    <div class="form-group row fv-plugins-icon-container">
                                                                        <label class="col-xl-2 col-lg-2 col-form-label">Title*</label>
                                                                        <div class="col-lg-10 col-xl-10 title_field">
                                                                            <input class="form-control form-control-solid form-control-lg" name="title" type="text" maxlength="100" value="">
                                                                            <div class="fv-plugins-message-container text-danger"></div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Group-->

                                                                    <!--begin::Group-->
                                                                    <div class="form-group row fv-plugins-icon-container">
                                                                        <label class="col-xl-2 col-lg-2 col-form-label">Author*</label>
                                                                        <div class="col-lg-10 col-xl-10 author_field">
                                                                            <input class="form-control form-control-solid form-control-lg" name="author" type="text" maxlength="100" value="">
                                                                            <div class="fv-plugins-message-container text-danger"></div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Group-->

                                                                    <!--begin::Group-->
                                                                    <div class="form-group row fv-plugins-icon-container">
                                                                        <label class="col-xl-2 col-lg-2 col-form-label">Genre*</label>
                                                                        <div class="col-lg-10 col-xl-10 genre_field">
                                                                            <input class="form-control form-control-solid form-control-lg" name="genre" type="text" maxlength="100" value="">
                                                                            <div class="fv-plugins-message-container text-danger"></div>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Group-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-lg-9">
                                                            <button type="button" onclick="send(this);" class="btn btn-success font-weight-bolder">
                                                                Save
                                                            </button>
                                                            <button type="reset" class="btn btn-default ml-2 font-weight-bold">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="mt-2">&nbsp;</div>
                                        <hr>
                                        <div class="mt-2">&nbsp;</div>

                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped" id="book-table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Title</th>
                                                        <th>Author</th>
                                                        <th>Genre</th>
                                                        <th>Vote Count</th>
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
                        <h5 class="modal-title" id="detailModalLabel">Detail of Master Book</h5>
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
        $('#book-table').DataTable({
            destroy: true,
        }).destroy();

        $('#book-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: false,
            ajax: {
                url:"{{ route('book.getdata') }}",
                type:"GET",
                data:{
                    rangedate: $('#rangedate').val(),
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'title', name: 'title'},
                { data: 'author', name: 'author'},
                { data: 'genre', name: 'genre'},
                { data: 'vote_count', name: 'vote_count'},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [1, "asc"],
            columnDefs: [
                {
                    targets: [0, 5],
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
    });

    setTimeout(function() {
        $('.alert').delay(3000).slideUp(300);
    });

    function showDetail(id){
        $.ajax({
            type: "POST",
            url: "{{ route('book.show') }}",
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

    function send(obj){
        form = $(obj).parents('form:first');
        id = form.find('input#id_data:first').val();
        var data = form.serialize();
        var url = form.attr('action');
        $(".fv-plugins-message-container").text('');                   

        $.ajax({
            type: form.attr('method'),
            url: url,
            data:data,
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend:function(data){
                $('#body-app').waitMe({
                    effect : 'roundBounce',
                    text : 'Please wait',
                    bg : 'rgba(255,255,255,0.7)',
                    color : '#000',
                    maxSize : '',
                    waitTime : -1,
                    textPos : 'vertical',
                    fontSize : '',
                    source : '',
                    // onClose : function() {}
                });
            },
            success:function(data){
                if(data.status=="success"){
                    if(typeof id == 'undefined' || id == ''){
                        /*reset value*/
                        form[0].reset();
                    }
                    
                    toast.fire({
                        icon: 'success',
                        title: data.message
                    })

                    setTimeout(function(){ window.location.replace("{{ route('book') }}"); }, 1000);

                }
                else{
                    toast.fire({
                        icon: 'error',
                        title: data.message
                    })
                    $('#body-app').waitMe("hide");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) { // if error occured
                $('#body-app').waitMe("hide");

                data = JSON.parse(jqXHR.responseText);
                if(data.message == 'The given data was invalid.'){
                    err = data.errors;
                    $.each(err, function(key, val) {
                        $("."+key+"_field .fv-plugins-message-container").text(val);                   
                        $("."+key+"_field .fv-plugins-message-container").show();
                    });

                    toast.fire({
                        icon: 'error',
                        title: data.message
                    })
                }
                else{
                    toast.fire({
                        icon: 'error',
                        title: "Error occured. "+jqXHR.status+" "+ textStatus +" "+" please try again"
                    })
                }
            }
        });
    }
    
</script>
@stop