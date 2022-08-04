@extends('adminlte::page')

@section('title')
    Permission - Create
@endsection

@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Permissions</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('permission') }}">Permission</a></li>
					<li class="breadcrumb-item active">Create</li>
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
								<div class="col-md-6">Create Permission</div>
								<div class="col-md-6 text-right">
									<!--begin::Button-->
									<a onclick="goBack()" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Back</a>
									<!--end::Button-->
								</div>
							</div>
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
												<form id="form_data" role="form" action="{{ route('permission.save') }}" method="POST">
													@csrf
													@method('POST')
													<!--begin::Group-->
													<div class="form-group row fv-plugins-icon-container">
														<label class="col-xl-3 col-lg-3 col-form-label">Name*</label>
														<div class="col-lg-9 col-xl-9 label_field">
															<input class="form-control form-control-solid form-control-lg" name="name" type="text" maxlength="100" value="">
															<div class="fv-plugins-message-container text-danger"></div>
														</div>
													</div>
													<!--end::Group-->

													

													<div class="row mt-5">
														<div class="col-lg-9 ml-lg-auto">
															<button type="submit" class="btn btn-success font-weight-bolder">
																Save
															</button>
															<button type="reset" class="btn btn-default ml-2 font-weight-bold" onclick="goBack()">Cancel</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
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

@endsection

@section('css')
	
@endsection

@section('js')
    <script>
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

						setTimeout(function(){ window.location.replace("{{ route('permission') }}"); }, 1000);

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
@endsection