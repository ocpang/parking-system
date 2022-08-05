@extends('adminlte::page')

@section('title')
    Check In
@endsection

@section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Check In</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Check In</li>
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
                                        <div class="col-md-6">Create Check In</div>
                                    </div>
                                    <div class="card-body">
                                        <form id="form_data" role="form" action="{{ route('check-in.save') }}" method="POST">
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
                                                                        <label class="col-xl-2 col-lg-2 col-form-label">Vehicle No*</label>
                                                                        <div class="col-lg-10 col-xl-10 vehicle_no_field">
                                                                            <input class="form-control form-control-solid form-control-lg" name="vehicle_no" type="text" maxlength="15" value="">
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
                                                        <div class="col-lg-12 text-center">
                                                            <button type="button" onclick="send(this);" class="btn btn-success font-weight-bolder">
                                                                Save
                                                            </button>
                                                            <button type="reset" class="btn btn-default ml-2 font-weight-bold">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3"></div>

                    </div>
                </div>
            </div>
        </section>

@endsection

@section('js')
<script type="text/javascript">
    $(function() {
        
    });

    setTimeout(function() {
        $('.alert').delay(3000).slideUp(300);
    });

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

                    $(".vehicle_no_field .fv-plugins-message-container").removeClass("text-danger");
                    $(".vehicle_no_field .fv-plugins-message-container").addClass("text-success");
                    $(".vehicle_no_field .fv-plugins-message-container").text(data.message);

                    setTimeout(function(){ window.location.replace("{{ route('check-in') }}"); }, 1000);

                }
                else{
                    toast.fire({
                        icon: 'error',
                        title: data.message
                    })
                    
                    $(".vehicle_no_field .fv-plugins-message-container").removeClass("text-success");
                    $(".vehicle_no_field .fv-plugins-message-container").addClass("text-danger");
                    $(".vehicle_no_field .fv-plugins-message-container").text(data.message);
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