@extends('layouts.apps')

@section('title', '401 - Unauthorized Action')

@section('body')
    <section class="content">
	    <div class="container-fluid">
            <p class="mt-5">&nbsp;</p>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="error-page">
                        <h2 class="headline text-warning"> 401</h2>

                        <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! You don't have authorized to access the request page.</h3>

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
