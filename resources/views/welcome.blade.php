<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{asset('/css/main.css')}}">
        <link rel="stylesheet" href="{{asset('/css/grid.min.css')}}">
        <title>Laravel vue</title>

        <!-- Fonts -->
            <script>
                (function() {
                    window.laravel = {
                        csrfToken:'{{ csrf_token() }}'
                    };
                })();
            </script>

        <!-- Styles -->

    </head>
    <body>
       
       <div id="app">
           @if(Auth::check())
           <mainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></mainapp>
           @else
           <mainapp :user="false"></mainapp>
           @endif
       </div>
    </body>
    <script src="{{asset('/js/app.js')}}"></script>
</html>
