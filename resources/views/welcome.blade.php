<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Connectivity - Login & sign up')</title>
        <link rel="stylesheet" type="text/css" href="{{ url("css/app.css") }}">
        <script type="text/javascript" src="{{ url("js/app.js") }}"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url("css/jquery.growl.css") }}" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
        <script src="{{ url("js/jquery.growl.js") }}" type="text/javascript"></script>
        <style type="text/css">
            .bg-white{
                background: #fff;
            }
            .pd-10{
                padding: 10px;
            }
            .pdt-40{
                padding-top: 40px;
            }
            .responsive{
                height: auto;
                width: 100%;
            }
            .h-60{
                height: 60px;
            }
            .w-100{
                width: 100%;
            }
        </style>
    </head>
    <body>
        @section('sidebar')
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
          <a class="navbar-brand" href="{{ url("/") }}">Social</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item d-block d-sm-none">
                <a class="nav-link" href="{{ url("/login") }}">Login</a>
              </li>
            </ul>
            @php
                $name = Route::currentRouteName();
            @endphp

            @if($name!="login")
            <form class="form-inline my-2 my-lg-0" id="loginformmenu">
                <div class="form-group d-none d-sm-block">
                    <input class="form-control" type="email" placeholder="Email" name="email" aria-label="email">
                    <input class="form-control" type="password" placeholder="Password" name="password" aria-label="password">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
            </form>
            @endif
          </div>
        </nav>
        @show
        <div class="container">

            @yield('content')
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav  h-60">
                      <li class="nav-item">
                        <a class="nav-link active" href="#">Privacy</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Terms of use</a>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $('#datepicker').datepicker(
                { 
                    format: 'yyyy-dd-mm' ,
                    uiLibrary: 'bootstrap4'
                }
            );
        </script>

        <script type="text/javascript">
            $("#loginformmenu").submit(function(event) {
                event.preventDefault();
                formData = $("#loginformmenu").serialize();
                $.growl.notice({title: "Processing!!", message: "We are processing your request" });
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    url: '{{ url("/login") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response){
                        if(response.status){
                            $.growl.notice({title: "Processing!!", message: "Trying to logged in" });
                            if(response.login){
                                $.growl.notice({title: "Success!!", message: "Logged in and redirecting" });
                                setTimeout(function(){
                                    window.location = "/home";
                                }, 2000);
                            }
                        }else{
                            $.growl.error({ title: "Errors!!", message: response.message });
                        }
                    }
                })
                .fail(function(response) {
                    console.log(response);
                });
            });
        </script>

    </body>
</html>
