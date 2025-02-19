@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="احكام,اجوبة,فتاوى,الشيخ,حمد">
<meta name="description" content="اسئلة واحكام واجوبة الاستاذ الدكتور حمد بن محمد الهاجرى استاذ الفقة المقارن والسياسة الشرعية كلية الشريعة جامعة الكويت">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.fatwa') }}
@endsection
@section('content')
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.fatwa') }}" title="{{ trans('frontend.fatwa') }}"/>
    </div>
    <h1 class="text-center"> {{ trans('frontend.fatwa') }} </h1>
    <div class="fatawaContent row justify-content-center align-items-center m-0">

        <div class="col-md-5 mt-4 formAsk">
            <h4 class="text-center"> {{ trans('frontend.fatwa-req') }}</h4>
            <p class="text-center"> {{ trans('frontend.fatwa-title') }}</p>
            <p class="text-center" style="color:var(--main-color)">{{ trans('btns.login-first') }}</p>

            <form action="" method="" id="offerForm" class="fatawaPageForm">
                @csrf
                <div class="row m-auto justify-content-center inputHead">
                    <input class="col-sm-12 col-lg-6 form-control" name="name"  id="nameContent" type="text"
                        placeholder="{{ trans('clients.name') }}" />
                    <!--<input class="col-sm-12 col-lg-6 form-control" name="phone" id="phoneContent" type="text"-->
                    <!--    placeholder="{{ trans('clients.phone') }}" />-->
                </div>
                <input class="email-input form-control" type="email" name="email" id="emailContent" placeholder="{{ trans('clients.email') }}" />
                <textarea class="p-2 form-control" name="message" id="textAreaContent" placeholder="{{ trans('frontend.message') }}"></textarea>
                <button class="main-btns m-auto d-block mt-4" id="save_fatwa" title="{{ trans('frontend.send') }}">{{ trans('frontend.send') }}</button>
            </form>
        </div>
        <div class="col-md-5 text-center">
            <img class="fatawaSvg" src="{{ asset('frontend/img/Questions-bro.svg') }}" alt="  {{ trans('frontend.fatwa') }}"  title="  {{ trans('frontend.fatwa') }}"/>
        </div>
    </div>

    <!-- start all Qustions & Answers -->
    <div class="allQues text-center mt-3 pb-5">
        <div class="shadow-head">
            <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.visitors-ques') }}" title="{{ trans('frontend.visitors-ques') }}" />
        </div>
        <h2>{{ trans('frontend.visitors-ques') }} </h2>
        <div class="asksTable">
            @forelse ($questions as $question)
            <div class="askBox">
                <i class="askBoxSvg fas fa-question-circle"></i>
                <a class="askBoxLink" href="{{ route('frontend.fatwa.answers',$question->id) }}" title="{{ $question->message }}">
                   {{ $question->message }}
                </a>
            </div>
            @empty

            <span>{{ trans('frontend.no-questions') }}</span>
            @endforelse

            <div class="float-right">
                {!! $questions->appends(request()->all())->links() !!}
            </div>

        </div>
    </div>
    <!-- end all Qustions & Answers -->
@endsection
@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>


    {{-- add fatwa --}}
    <script>
        $(document).ready(function() {
            $('#save_fatwa').on('click', function(e) {

                e.preventDefault();
                 Swal.fire({
                    title: "Loading...",
                    html: "Please wait a moment"
                    })
                    Swal.showLoading()

                var formData = new FormData($('#offerForm')[0]);

                $.ajax({
                    url: "{{ route('frontend.fatwa') }}",
                    type: "POST",
                    datType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        })
                        if ($.isEmptyObject(data.error)) {
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            })
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            })
                        }
                    },

                });
                $("#nameContent").val("");
               // $("#phoneContent").val("");
                $("#emailContent").val("");
                $("#textAreaContent").val("");

            });
        });
    </script>
@endsection
