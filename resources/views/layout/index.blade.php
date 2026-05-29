 <!DOCTYPE html>
 <html lang="vi">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>FoodDS - Đồ ăn và thức uống</title>
     <link rel="stylesheet" href="{{ asset('component/css/foodds.css') }}">
     <!-- link md bootstrap(thư viên của bootstrap) -->
     <link rel="stylesheet" href="{{ asset('component/css/mdb.min.css') }}">
     <!-- Link icon  -->
     <link rel="Website icon" type="png" href="{{ asset('logo-website/login.png') }}">
     <!-- Link fontawesome  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <!-- link google icon -->
     <link rel="stylesheet"
         href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
     <!-- Google Fonts -->
     <link rel="stylesheet"
         href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600&display=swap">

     <!-- Bootstrap Icons -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

     <!-- css default -->
     <style>
         body {
             margin: 0;
             padding: 0;
             overflow-x: hidden;
             font-family: 'Roboto', sans-serif;
             background: #f8fafc !important;
             color: #1f2937;
         }

         li {
             list-style: none;
         }

         a {
             text-decoration: none;

         }

         img {
             cursor: pointer;
         }
     </style>
 </head>

 <body>
     @if (session('payment-success'))
         <div class="fd-container" style="margin-top: 16px;">
             <div class="fd-alert success">{{ session('payment-success') }}</div>
         </div>
     @endif

     @if (session('payment-error'))
         <div class="fd-container" style="margin-top: 16px;">
             <div class="fd-alert warning">{{ session('payment-error') }}</div>
         </div>
     @endif

     <!-- header Giang -->
     <header>
         @include('component.header.header')
     </header>

     <!-- content ca -->
     <main class="content">
         @include('component.content.content')
     </main>

     <!-- belowContent duyHung -->
     <div class="belowContent">
         @include('component.belowContent.belowContent')
         @include('component.belowContent.content-ca')
     </div>

     <!-- Footer dinh -->
     <footer>
         @include('component.footer.footer')
     </footer>

     <!-- link bootstrap js  -->
     <script src="{{ asset('component/js/bootstrap.bundle.min.js') }}"></script>

     <!-- link md bootstrap js  -->
     <script src="{{ asset('component/js/mdb.umd.min.js') }}"></script>
 </body>

 </html>
