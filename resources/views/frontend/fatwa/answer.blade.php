@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="اسئلة,احكام,اجوبة,فتاوى,الشيخ,حمد">
<meta name="description" content="اسئلة واجوبة الاستاذ الدكتور حمد بن محمد الهاجرى استاذ الفقة المقارن والسياسة الشرعية كلية الشريعة جامعة الكويت">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.fatwa') }}
@endsection
@section('content')
    <!-- start ask & ques content -->
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.fatwa') }}" title="{{ trans('frontend.fatwa') }}" />
    </div>
    <!-- start ask & ques content -->
    <h1 class="text-center"> {{ trans('frontend.fatwa') }}</h1>
    <div class="asksTable answer">
        <div class="askBox">
            <i class="askBoxSvg fas fa-question-circle"></i>
            <p class="askBoxLink">
                {{ $answer->fatwa->message }}
            </p>
        </div>
        <hr />
        <div class="answerBox d-flex">
            <i class="askBoxSvg fas fa-hand-holding-heart"></i>
            <div class="answercontent">
                <p class="p-2"> {!! $answer->answer !!}</p>

                <div class="audioFile mt-5">
                    @if (!empty($answer->audio_file))
                        <audio controls="" download="">
                            <source src="{{ asset('Files/fatwa/' . $answer->fatwa->name . '/' . $answer->audio_file) }}" />
                        </audio>
                    @endif

                </div>
                @if (!empty($answer->youtube_link))
                <div class="embeedAudio">
                    <?php
                        $url = getYoutubeId($answer->youtube_link);
                    ?>
                    @if ($url)
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $url }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
