@extends('layouts.apps')

@section('title', '419 - Page Expired')

@section('body')
    <section class="content">
	    <div class="container-fluid">
            <p class="mt-5">&nbsp;</p>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="error-page">
                        <h2 class="headline text-warning"> 419</h2>

                        <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! The page you are trying to access has expired.</h3>

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
