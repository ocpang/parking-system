<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                            
                <div class="row">
                    <div class="col-md-12">
                        
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="title" id="title" class="form-control" aria-label="Title" placeholder="title">
                            <div class="input-group-append">
                                <span class="input-group-text"><span onclick="showSearch()" style="cursor: pointer;">Search</span></span>
                            </div>
                        </div>

                        <div id="contentResult"></div>

                    </div>
                </div>

                <div class="mt-5"></div>
                <h4 align="left">Programming Book</h4>
                <div id="contentProgramming" class="row"></div>
            </div>
        </div>
    </body>
    <script>
    $(function(){
        $.ajax({
            type: "GET",
            url: "https://www.googleapis.com/books/v1/volumes?q=programming",
            dataType:'json',
            success:function(data){
                var res = data.items;
                var results = "";
                $.each(res, function( key, value ) {
                    results += '<div class="col-md-4"><img src="'+ value.volumeInfo.imageLinks.thumbnail +'"/> <h3>'+ value.volumeInfo.title +'</h3> '+ value.searchInfo.textSnippet +' <a href="'+ value.volumeInfo.infoLink +'">Read more..</a></div>'
                });
                $('#contentProgramming').html(results);
            },
            error: function(jqXHR, textStatus, errorThrown) { // if error occured
                alert("Error occured. "+jqXHR.status+" "+ textStatus +" "+" please try again");
            }
        });
    });

    function showSearch(){
        var title = $("#title").val();
        $.ajax({
            type: "GET",
            url: "{{ route('finder.search') }}",
            data: "title=" + title,
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){				
                $('#contentResult').html(data.html);
            },
            error: function(jqXHR, textStatus, errorThrown) { // if error occured
                alert("Error occured. "+jqXHR.status+" "+ textStatus +" "+" please try again");
            }
        });
    }

    function addVote(id){
        $.ajax({
            type: "GET",
            url: "{{ route('finder.vote') }}",
            data: "id=" + id,
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
                alert(data.status);
                				
                $('#count_' + id).html(data.total);
            },
            error: function(jqXHR, textStatus, errorThrown) { // if error occured
                alert("Error occured. "+jqXHR.status+" "+ textStatus +" "+" please try again");
            }
        });
    }

    </script>
</html>
