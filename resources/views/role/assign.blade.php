@extends('adminlte::page')

@section('title')
    Assign
@endsection

@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Assign</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('role') }}">Role</a></li>
					<li class="breadcrumb-item active">Assign</li>
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
				@if(Session::has('error'))
					<div class="alert alert-danger" role="alert">
						{{Session::get('error')}}
					</div>
				@endif
				
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header row">
								<div class="col-md-6">Create Time Call</div>
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
												<form id="form_data" role="form" action="{{ route('role.saveAssign') }}" method="POST">
													@csrf
													@method('POST')
													

													<!--begin::Group-->
													<div class="form-group row fv-plugins-icon-container">
														<label class="col-xl-3 col-lg-3 col-form-label">Roles*</label>
														<div class="col-lg-9 col-xl-9 role_name_field">
															<select class="form-control select2" name="role_id" id="role_id">
																<option value="">Select</option>
																@foreach($roles as $key => $val)
																	<option {{$val->id == $role_id ? 'selected' : ''}} value="{{ $val->id }}" >{{ $val->name }}</option>
																@endforeach
															</select>
															<div class="fv-plugins-message-container text-danger"></div>
														</div>
													</div>
													<!--end::Group-->

													<!--begin::Group-->
													<div class="form-group row fv-plugins-icon-container">
														<label class="col-xl-3 col-lg-3 col-form-label">Permissions*</label>
														<div class="col-lg-9 col-xl-9 role_name_field">
															
															@foreach($permissions as $key => $val)
																<div class="form-check form-check-inline">
																  <input {{ in_array($val->id, $permissionOfRole) ? 'checked' : '' }} name="permissions[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="{{$val->id}}">
																  <label class="form-check-label" for="inlineCheckbox1">{{$val->name}}</label>
																</div>
															@endforeach
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
			</div>
		</div>
	</div>
</section>

@section('js')
<script type="text/javascript">
	$(function() {

	});

</script>
@endsection
@endsection