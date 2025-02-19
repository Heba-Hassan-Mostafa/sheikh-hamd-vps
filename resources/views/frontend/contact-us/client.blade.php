@extends('frontend.design.master')
@section('meta')
@endsection
@section('title')
    {{ trans('frontend.client-page') }}
@endsection
@section('content')

<div class="shadow-head">
    <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt=" {{ trans('frontend.client-page') }}" title=" {{ trans('frontend.client-page') }}"/>
  </div>

  <div class="row m-0 userpage mt-5">
    <div class="col-md-5 col-lg-3 text-center userpageAside">
      <i class="fas fa-user-circle"></i>
      <div class="text-start mt-4">
        <h5>{{ auth()->guard('client')->user()->full_name }}<i class="fas fa-user svgWhite"></i></h5>
        <p>{{ auth()->guard('client')->user()->email }}<i class="fas fa-envelope svgWhite"></i></p>
        <p>{{ auth()->guard('client')->user()->phone }}<i class="fas fa-phone-alt svgWhite"></i></p>
        <p>
            @if (auth('client')->check())
            <form method="GET" action="{{ route('logout', 'client') }}">
          @endif
          @csrf
          <a class="text-white" href="#" title=" {{ trans('frontend.logout') }}"
              onclick="event.preventDefault();this.closest('form').submit();">
               {{ trans('frontend.logout') }} <i class="fas fa-sign-in-alt svgWhite"></i></a>
          </form>
           </p>
      </div>
    </div>
    <div class="col-md-7 col-lg-8">
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button title="{{ trans('frontend.fav-subj') }}" class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
              {{ trans('frontend.fav-subj') }}
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="favLinks">

                    @if ($lists)
                    @forelse ($lists as $list)
                    <a title="{{ $list->wishable->name }}"
                  href="
                  {{ ($list->wishable_type == 'App\Models\Lesson')
                   ? route('frontend.lessons.lesson_content',$list->wishable->slug )
                  :(($list->wishable_type == 'App\Models\Speech')
                   ?route('frontend.speeches.speech_content',$list->wishable->slug)
                   :(($list->wishable_type == 'App\Models\Lecture')
                   ?route('frontend.lectures.lecture_content',$list->wishable->slug)
                   :(($list->wishable_type == 'App\Models\Article')
                   ?route('frontend.articles.article_content',$list->wishable->slug)
                   :(($list->wishable_type == 'App\Models\Book')
                   ?route('frontend.books.book_content',$list->wishable->slug)
                   :(($list->wishable_type == 'App\Models\Benefit')
                   ?route('frontend.benefits.benefit_content',$list->wishable->slug)
                   : '')))))}}"
                  >
                      <i class="fas fa-pen-square title-icon"></i>
                      {{ $list->wishable->name }}
                    </a>

                    @empty
                    <span>{{ trans('frontend.no-fav-subj') }}</span>
                    @endforelse
                    @endif


                  </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button title=" {{ trans('frontend.my-comments') }}" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                {{ trans('frontend.my-comments') }}
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="favLinks">
                    @if ($comments)
                    @forelse ($comments as $comment)
                    <a title="{{ $comment->commentable->name }}"
                  href="
                  {{ ($comment->commentable_type == 'App\Models\Lesson')
                   ? route('frontend.lessons.lesson_content',$comment->commentable->slug )
                  :(($comment->commentable_type == 'App\Models\Speech')
                   ?route('frontend.speeches.speech_content',$comment->commentable->slug)
                   :(($comment->commentable_type == 'App\Models\Lecture')
                   ?route('frontend.lectures.lecture_content',$comment->commentable->slug)
                   :(($comment->commentable_type == 'App\Models\Article')
                   ?route('frontend.articles.article_content',$comment->commentable->slug)
                   :(($comment->commentable_type == 'App\Models\Book')
                   ?route('frontend.books.book_content',$comment->commentable->slug)
                   : ''))))}}"
                  >
                      <i class="fas fa-pen-square title-icon"></i>
                      {{ $comment->commentable->name }}
                    </a>

                    @empty
                    <span>{{ trans('frontend.no-my-comments') }}</span>
                    @endforelse
                    @endif

                  </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button title="{{ trans('frontend.my-ques') }}" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                  {{ trans('frontend.my-ques') }}
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="favLinks">
                    @if ($questions)
                    @forelse ($questions as $question)
                    <a href="{{ route('frontend.fatwa.questions') }}" title="{{ $question->message }}">
                        <i class="fas fa-pen-square title-icon"></i>
                      {{ $question->message }}
                      </a>
                    @empty
                    <span>{{ trans('frontend.no-my-ques') }}</span>
                    @endforelse
                    @endif


                  </div>
              </div>
            </div>
          </div>
    </div>
  </div>
  <!-- start login form -->
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
