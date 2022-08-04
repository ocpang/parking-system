@extends('adminlte::page')

@section('title', '403 - Forbidden Action')

@section('content')
    <section class="content">
	    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-page">
                        <h2 class="headline text-warning"> 403</h2>

                        <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! You don't have permission to access the request page.</h3>

                        <p>
                            We are unable to provide the page you requested.<br>
                            Meanwhile, you may <a href="{{ route('home') }}">return to dashboard</a>.
                        </p>

                        </div>
                        <!-- /.error-content -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
