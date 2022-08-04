@extends('adminlte::page')

@section('title')
    Roles
@endsection

@section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Roles</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Roles</li>
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
                            @can('create role')
                            <div class="col-md-3 offset-md-9">
                                <a href="{{route('role.assign')}}" class="btn btn-primary font-weight-bolder float-right"><i class="fa fa-plus"></i> Create</a>
                            </div>
                            @endcan
                        </div>

                        <div class="mb-3"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped" id="role-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Role</th>
                                                        <th>Permission</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($roles as $key => $val)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$val->name}}</td>
                                                        <td>{{ implode(', ', $val->permissions()->pluck('name')->toArray() )}}</td>
                                                        <td class="text-center">
                                                            @can('update role')
                                                                <a class="btn btn-info btn-sm text-white" href="{{route('role.assign', $val->id)}}" title="Assign"><i class="fa fa-user-lock"></i></a>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
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

@endsection

@push('styles')
@endpush

@push('scripts')
@endpush

@section('js')
<script type="text/javascript">
    $(function() {
        $('#role-table').DataTable({
            processing: true,
            serverSide: false,
            scrollX: false,
        });
    });
    
    setTimeout(function() {
        $('.alert').delay(3000).slideUp(300);
    });

</script>
@stop