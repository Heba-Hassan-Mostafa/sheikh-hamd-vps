<!-- Title -->
<title>@yield('title')</title>
<!-- fonts -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;700&amp;display=swap" rel="stylesheet" />
<!-- Icons css -->
<link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />
<!--  Sidebar css -->
<link href="{{ URL::asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">
{{-- file manager for ckeditor --}}
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
<link rel="icon" href="{{ asset('/Files/settings/'.setting()->icon) }}" />


@livewireStyles
@yield('css')

@if (App::getLocale() == 'en')

     <!-- Sidemenu css -->
     <link rel="stylesheet" href="{{ URL::asset('assets/css/sidemenu.css') }}">
     <!--- Style css -->
     <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
     <!--- Dark-mode css -->
     <link href="{{ URL::asset('assets/css/style-dark.css') }}" rel="stylesheet">
     <!---Skinmodes css-->
     <link href="{{ URL::asset('assets/css/skin-modes.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/css/main-ltr.css') }}">
     @else
       <!-- Sidemenu css -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css-rtl/sidemenu.css') }}">
    <!--- Style css -->
    <link href="{{ URL::asset('assets/css-rtl/style.css') }}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{ URL::asset('assets/css-rtl/style-dark.css') }}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{ URL::asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css-rtl/main-rtl.css') }}">

@endif


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />



