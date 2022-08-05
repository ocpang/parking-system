@extends('adminlte::page')

@section('title')
    Check Out
@endsection

@section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Check Out</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Check Out</li>
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
                                        <div class="col-md-6">Create Check Out</div>
                                    </div>
                                    <div class="card-body">
                                        <form id="form_data" role="form" action="{{ route('check-out.save') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" id="id">
                                            <input type="hidden" name="code" id="code">
                                            <input type="hidden" name="vehicle_no" id="vehicle_no">
                                            <input type="hidden" name="check_in" id="check_in">
                                            <input type="hidden" name="check_out" id="check_out">
                                            <input type="hidden" name="hours" id="hours">
                                            <input type="hidden" name="price" id="price">
                                            <input type="hidden" name="total" id="total">
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
                                                                        <label class="col-xl-2 col-lg-2 col-form-label">Code*</label>
                                                                        <div class="col-lg-8 col-xl-8 code_field">
                                                                            <input class="form-control form-control-solid form-control-lg" name="val_code" id="val_code" type="text" maxlength="8" value="">
                                                                            <div class="fv-plugins-message-container text-danger"></div>
                                                                        </div>
                                                                        <div class="col-lg-2 col-xl-2">
                                                                            <button type="button" onclick="checkCode()" class="btn btn-lg btn-default font-weight-bolder">
                                                                                Check
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Group-->
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <table class="table table-hover table-bordered table-striped" id="table-detail" width="100%" style="display: none;">
                                                                <tr>
                                                                    <th width="40%">Code</th>
                                                                    <td><span id="txt_code"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Vehicle No</th>
                                                                    <td><span id="txt_vehicle_no"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Check In</th>
                                                                    <td><span id="txt_check_in"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Check Out</th>
                                                                    <td><span id="txt_check_out"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Hours</th>
                                                                    <td><span id="txt_hours"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Price per hour</th>
                                                                    <td><span id="txt_price"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total</th>
                                                                    <td><span class="font-weight-bolder" id="txt_total"></span></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <button type="button" onclick="send(this);" class="btn btn-success font-weight-bolder" id="btnSave" style="display: none;">
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
    
    function checkCode(){
        if($('#val_code').val() == ""){
            toast.fire({
                icon: 'error',
                title: 'Code cannot empty'
            })
            $(".code_field .fv-plugins-message-container").text("Code cannot empty");                   
        }
        else{
            $.ajax({
                type: "POST",
                url: "{{ route('check-out.check') }}",
                data: "code="+$('#val_code').val(),
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
                        toast.fire({
                            icon: 'success',
                            title: data.message
                        })

                        $('#id').val(data.data.id);
                        $('#code').val(data.data.code);
                        $('#vehicle_no').val(data.data.vehicle_no);
                        $('#check_in').val(data.data.check_in);
                        $('#check_out').val(data.data.check_out);
                        $('#hours').val(data.data.hours);
                        $('#price').val(data.data.price);
                        $('#total').val(data.data.total);

                        $('#txt_code').text(data.data.code);
                        $('#txt_vehicle_no').text(data.data.vehicle_no);
                        $('#txt_check_in').text(data.data.check_in);
                        $('#txt_check_out').text(data.data.check_out);
                        $('#txt_hours').text(data.data.txt_hours);
                        $('#txt_price').text(data.data.txt_price);
                        $('#txt_total').text(data.data.txt_total);

                        $(".code_field .fv-plugins-message-container").removeClass("text-danger");
                        $(".code_field .fv-plugins-message-container").addClass("text-success");
                        $(".code_field .fv-plugins-message-container").text(data.message);

                        $("#btnSave").show();
                        $("#table-detail").show();
                    }
                    else{
                        toast.fire({
                            icon: 'error',
                            title: data.message
                        })
                        
                        $(".code_field .fv-plugins-message-container").removeClass("text-success");
                        $(".code_field .fv-plugins-message-container").addClass("text-danger");
                        $(".code_field .fv-plugins-message-container").text(data.message);

                        $("#btnSave").hide();
                        $("#table-detail").hide();
                    }

                    $('#body-app').waitMe("hide");

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

                    $(".code_field .fv-plugins-message-container").removeClass("text-danger");
                    $(".code_field .fv-plugins-message-container").addClass("text-success");
                    $(".code_field .fv-plugins-message-container").text(data.message);

                    setTimeout(function(){ window.location.replace("{{ route('check-out') }}"); }, 1000);

                }
                else{
                    toast.fire({
                        icon: 'error',
                        title: data.message
                    })

                    $(".code_field .fv-plugins-message-container").removeClass("text-danger");
                    $(".code_field .fv-plugins-message-container").addClass("text-success");
                    $(".code_field .fv-plugins-message-container").text(data.message);

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