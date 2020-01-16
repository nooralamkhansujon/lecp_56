<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link type="text/css" href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" >
    <!-- Styles -->
    <link type="text/css" href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"  
    href="{{asset('css/admin.css')}}" >
    
    
</head>
<body>

<div id="app">
    <main class="py-4">
    <div class="container-fluid">
       <div class="row">
      @include('admin.partials.navbar')
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                @yield('breadcrumbs')
              </ol>
            </nav>
        </div>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            
            <h1 class="h2">@yield('header')</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                @yield('button_link')
              </div>
            </div>
           
            
          </div>
          
          <div class="table-responsive">
              @yield('content')
          </div>
      </main>
  </div>
</div>
         
   

    </main>
</div>

     <!-- Scripts -->
     <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
     <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" 
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
      @yield('scripts')

</body>
</html>
