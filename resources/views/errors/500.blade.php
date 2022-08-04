@extends('adminlte::page')

@section('title', '500 - Server Error')

@section('content')
    <section class="content">
	    <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-page">
                        <h2 class="headline text-warning"> 500</h2>

                        <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! The process you are looking for is having a problem with the server.</h3>

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
