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
       <div class="container">
           <h1 style="margin: 0 auto;margin-top: 27%;text-align: center;" class="pt-6" style="margin:0 auto;">You dont have permission to access this page </h1>
       </div>
    </body>
    <script src="{{asset('/js/app.js')}}"></script>
</html>
