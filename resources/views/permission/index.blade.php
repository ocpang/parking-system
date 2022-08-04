@extends('adminlte::page')

@section('title')
    Permissions
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
                            <li class="breadcrumb-item active">Permissions</li>
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
                            @can('create permission')
                            <div class="col-md-3 offset-md-9">
                                <a href="{{route('permission.create')}}" class="btn btn-primary font-weight-bolder float-right">
                                    <i class="fa fa-plus"></i> Create
                                </a>
                            </div>
                            @endcan
                        </div>

                        <div class="mb-3"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped" id="permission-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Permission</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($permissions as $key => $permission)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$permission}}</td>
                                                        
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
        $('#permission-table').DataTable({
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