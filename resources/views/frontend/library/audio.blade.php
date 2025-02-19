@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="المكتبة,الصوتية,الشيخ,حمد,الهاجرى,دينية,اسلامية,مقاطع,صوتية,مرئية,تحميل">
<meta name="description" content="المكتبة الصوتية للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.audio-library') }}
@endsection
@section('content')

<div class="headCategoriesImg">
    @if (setting()->audio_banner)
    <img src="{{ asset('Files/settings/'.setting()->audio_banner) }}" alt="{{ trans('frontend.audio-library') }}" title="{{ trans('frontend.audio-library') }}"/>
    {{-- @else
    <img src="{{ asset('frontend/img/audio-back.png') }}" alt="" /> --}}
    @endif
  </div>
  <div class="categoriesSearch">
    <form class="search-form">
        @csrf
        <input type="text" name="search" id="search" placeholder="{{ trans('frontend.search') }}"
            class="form-control search-input" />
        <button type="button" title="{{ trans('frontend.search') }}"><i class="fas fa-search"></i></button>
    </form>

</div>
  <!-- start row  with categories-->
  <div class="row m-0 cardCat align-items-start">
    <div class="col-md-3 sideCategories">
      <div class="allCategories">
        <h1>
          <i class="fas fa-bars"></i>
          {{ trans('frontend.categories') }}
        </h1>
      </div>
      <div class="categoriesList">
        <div class="allLinks">
          <i class="fas fa-bars allCa"></i>
          <h2><a href="{{ route('frontend.audio-library.audio') }}" style="color: var(--main-color);" title="{{ trans('frontend.all') }}">
            {{ trans('frontend.all') }} <span>({{ App\Models\Audio::whereHasMorph(
                'audioable','*',
                function (Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('embed_link', '!=' ,'')
                            ->orWhere('audio_file', '!=' , '')
                    ->Active()->ActiveCategory();

                })->count() }})</span>
        </a></h2>
        </div>
        <div class="categoriesListUl">
          <ul>
            <li>
              <i class="fas fa-level-down-alt"></i>
              <a href="{{ route('frontend.audio-library.lesson.audio') }}" title="{{ trans('frontend.lessons') }}">
                {{ trans('frontend.lessons') }} <span>({{ App\Models\Audio::whereHasMorph(
                    'audioable',[App\Models\Lesson::class],
                    function (Illuminate\Database\Eloquent\Builder $query) {
                        $query->where('embed_link', '!=' ,'')
                                ->orWhere('audio_file', '!=' , '')
                        ->Active()->ActiveCategory();

                    })->count() }})</span></a>
            </li>
            <li>
                <i class="fas fa-level-down-alt"></i>
                <a href="{{ route('frontend.audio-library.lecture.audio') }}" title="{{ trans('frontend.lectures') }}">
                    {{ trans('frontend.lectures') }} <span>({{ App\Models\Audio::whereHasMorph(
                        'audioable',[App\Models\Lecture::class],
                        function (Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('embed_link', '!=' ,'')
                                    ->orWhere('audio_file', '!=' , '')
                            ->Active()->ActiveCategory();

                        })->count() }})</span></a>
              </li>
              <li>
                <i class="fas fa-level-down-alt"></i>
                <a href="{{ route('frontend.audio-library.article.audio') }}" title="{{ trans('frontend.articles') }}">
                    {{ trans('frontend.articles') }} <span>({{ App\Models\Audio::whereHasMorph(
                        'audioable',[App\Models\Article::class],
                        function (Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('embed_link', '!=' ,'')
                                    ->orWhere('audio_file', '!=' , '')
                            ->Active()->ActiveCategory();

                        })->count() }})</span></a>
              </li>
              <li>
                <i class="fas fa-level-down-alt"></i>
                <a href="{{ route('frontend.audio-library.speech.audio') }}" title="{{ trans('frontend.speeches') }}">
                    {{ trans('frontend.speeches') }} <span>({{ App\Models\Audio::whereHasMorph(
                        'audioable',[App\Models\Speech::class],
                        function (Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('embed_link', '!=' ,'')
                                    ->orWhere('audio_file', '!=' , '')
                            ->Active()->ActiveCategory();

                        })->count() }})</span></a>
              </li>
              <li>
                <i class="fas fa-level-down-alt"></i>
                <a href="{{ route('frontend.audio-library.benefit.audio') }}" title="{{ trans('frontend.benefits') }}">
                    {{ trans('frontend.benefits') }} <span>({{ App\Models\Audio::whereHasMorph(
                        'audioable',[App\Models\Benefit::class],
                        function (Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('embed_link', '!=' ,'')
                                    ->orWhere('audio_file', '!=' , '')
                            ->Active()->ActiveCategory();

                        })->count() }})</span></a>
              </li>
          </ul>
        </div>
        <div class="categoriesListUl">
            <?php
            $categories = App\Models\AudioCategory::Active()->orderBy('order_position','asc')->get();

            ?>
            <ul>
                <i class="fas fa-bars allCa"></i>
                <a class="otherAudio" href="{{ route('frontend.audio-library.another.audio') }}" title="{{ trans('frontend.another-audioes') }}">
                    {{ trans('frontend.another-audioes') }} <span>({{ App\Models\Audio::whereHasMorph(
                        'audioable',[App\Models\Audio::class],
                        function (Illuminate\Database\Eloquent\Builder $query) {
                            $query->where('embed_link', '!=' ,'')
                                    ->orWhere('audio_file', '!=' , '')
                            ->Active()->ActiveCategory();

                        })->count() }})</span>
                </a>
                @forelse ($categories as $category)
                <li>
                    <i class="fas fa-level-down-alt"></i>
                    <a href="{{ route('frontend.library.category',$category->slug) }}" title="{{ $category->name }}">
                        {{ $category->name }} <span>({{ $category->audioes->count() }})</span></a>
                </li>
                @empty

                <!--<span>{{ trans('frontend.no-cats') }}</span>-->
                @endforelse

            </ul>
          </div>
      </div>
    </div>
    <div class="col-md-8 row my_card allCategoriesCard">
      <div class="audioLib row row-cols-1 row-cols-md-3 g-4 justify-content-center ">
        @forelse ($audioes as $audio)
        <div class="col-sm-6 col-md-4">
            <div class="card h-100">
              <img src="{{ asset('frontend/img/hqdefault.png') }}" class="card-img-top" alt="{{ $audio->name }}" title="{{ $audio->name }}"/>
              <div class="card-body">
                <div class="d-inline-flex">
                  <i class="fas fa-pen-square title-icon"></i>
                  <h6 class="card-title">
                  {{ $audio->name }}
                  </h6>
                </div>
                <div class="date-details">
                  <i class="fas fa-calendar-alt date-icon"></i>
                  <span>{{ $audio->publish_date->format('Y-m-d') }}</span>
                </div>
                <div class="text-center mt-4">
                  <a href="{{ route('frontend.audio-library.audio.content',$audio->slug) }}" class="btn-card-more" title="{{ trans('frontend.listen') }}">{{ trans('frontend.listen') }}</a>
                </div>
              </div>
            </div>
          </div>

        @empty

        <span class="text-center">{{ trans('frontend.no-audioes') }}</span>
        @endforelse
      </div>
      <div class="float-right">
        {!! $audioes->appends(request()->all())->links() !!}
    </div>
    </div>
  </div>
  <!-- end row  with categories-->
  <!-- end categories content -->

@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <script defer src="{{ asset('frontend/js/lightgallery.min.js') }}"></script>
    <script defer src="{{ asset('frontend/js/lg-autoplay.min.js') }}"></script>
    <script defer src="{{ asset('frontend/js/light.js') }}"></script>

    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>

    <script>
        $(document).ready(function() {

               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });

               $('#search').on('keyup',function(){

                   var value = $(this).val();
                   // console.log(value);
                   $.ajax({
                          url: " {{ route('frontend.library.library.search') }}" ,
                           type: "GET",
                           datType: "json",
                            data:{'search':value},
                       success:function(data)
                       {
                          $('.my_card').html(data);
                       }

                   });
               });
           });
   </script>
@endsection

