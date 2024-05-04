
 <!DOCTYPE html>
 <html lang="en">
 
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>اکسپورت انلاین دیتا آب و فاضلاب</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/table.css">
     <style>
        @import url('https://v1.fontapi.ir/css/Nazanin');

        * {
            font-family: Nazanin, sans-serif !important;
          }

     </style>


      <script src="{{asset('assets/js/persianD.js')}}"></script>
      <script src="{{asset('assets/js/persianDate.js')}}"></script>
     
      <script src="{{asset('assets/js/date.js')}}"></script>
 </head>
 
 <body>
   @livewire('export-data')

   <script src="{{url('assets')}}/js/table.js"></script>

 </body>
 
 </html>