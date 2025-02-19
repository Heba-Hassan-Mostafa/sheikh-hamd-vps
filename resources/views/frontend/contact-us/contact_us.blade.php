@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="تواصل,معنا,اتصل, بنا">
<meta name="description" content=" تواصل معناواتصل بنا">
<meta name="author" content="{{ setting()->site_name }}">
@endsection

@section('title')
    {{ trans('frontend.contact-us') }}
@endsection
@section('content')
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="" />
    </div>
    <!-- contact Us content -->
    <div class="contactUs m-auto">
        <h1 class="text-center">{{ trans('frontend.contact-us') }}</h1>
        <section class="fatwa">

            <form action="{{ route('frontend.contact.us') }}" method="POST" class="fadeFatwa">
                @csrf
                <div class="row m-auto justify-content-center inputHead">
                    <input class="col-sm-12 col-lg-6 form-control" type="text" name="name"
                        placeholder="{{ trans('clients.name') }}" />
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                        <input class="col-sm-12 col-lg-6 form-control" type="text" name="phone"
                        placeholder="{{ trans('clients.phone') }}" />
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                </div>
                <input class="email-input form-control" type="email" name="email" placeholder="{{ trans('clients.email') }}" />
                @error('email')
                <span class="text-danger">{{ $message }}</span>
              @enderror
                <textarea class="p-2" name="message" placeholder="{{ trans('frontend.message') }}"></textarea>
                @error('message')
                <span class="text-danger">{{ $message }}</span>
              @enderror
               {!! RecaptchaV3::field('contact_us') !!}
              @error('g-recaptcha-response')
              <span class="text-danger">{{ $message }}</span>
              @enderror
           
                <button type="submit" value="send" class="main-btns m-auto d-block mt-4">{{ trans('frontend.send') }}</button>
            </form>
        </section>
    </div>
    <!-- start login form -->
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>

@endsection
