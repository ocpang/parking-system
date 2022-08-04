@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
    @yield('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/waitme/waitMe.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @if(Auth::user())
    <style>
    </style>
    @endif
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">

            {{-- Content Header --}}
            <div class="content-header">
                <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                    @yield('content_header')
                </div>
            </div>

            {{-- Main Content --}}
            <div class="content">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    @yield('content')
                </div>
            </div>

        </div>

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script src="{{ asset('plugins/waitme/waitMe.min.js') }}"></script>
    
    <script>
        $('.select2').select2({
            placeholder: 'Select an option'
        });

        var toast;
        
        $(function () {
            $('.ipaddress').inputmask({
                "alias" : "ip",
                "placeholder" : "_"
            });
            
			toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
		});

        function goBack() {
            window.history.back();
        }

        function deleteData (id, uri) {
            // body...
            if(typeof id === 'undefined'){
                toast.fire({
                    icon: 'error',
                    title: 'Something wrong for this data record.'
                });

                return false;
            }

            var r = confirm("Are you sure to delete this data ?");
            if (r == true) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: uri + '/' + id,
                    type: 'GET',
                    dataType:'json',
                    cache: false,
                    success: function (data) {
                        if(data.status == 'success'){
                            setTimeout(function(){$('.dataTable').DataTable().ajax.reload();}, 1000);

                            toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        }else{
                            toast.fire({
                                icon: 'error',
                                title: data.message
                            });
                        }
                    },
                    error: function(jqXHR, text) { // if error occured
                        toast.fire({
                            icon: 'error',
                            title: "Error occured, "+ text +" "+ jqXHR.status+". please try again"
                        });
                    }
                })
            }
        }

    </script>
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

@stop
