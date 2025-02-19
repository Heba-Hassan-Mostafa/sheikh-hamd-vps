

@include('frontend.design.head')
<body>
  <header>
    <!-- start first-nav-->

  </header>

     <div
     style="
     text-align: center;
     font-weight:bold;
     color:red;
     margin-top:50px;
     font-family: 'Cairo', sans-serif">
       {!! setting()->message_maintenance !!}
       </div>



<div class="rep" style="position: relative;hight:50px">
    <img
    style="position: absolute;
    margin-left: auto;
    margin-right: auto;
    left: 0;
    right: 0;
    top:100px;
    max-width:25%;
    "
    src="{{ asset('frontend/img/main.svg') }}"
    alt="maintenance">


</div>


</body>
</html>
