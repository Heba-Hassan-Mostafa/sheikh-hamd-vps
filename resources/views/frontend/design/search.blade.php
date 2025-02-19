@extends('frontend.design.master')
@section('css')
@endsection
@section('title')
{{ trans('frontend.search') }}
@endsection
@section('content')
<div class="shadow-head">
    <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="" />
  </div>

  <div class="libraryPage">
    <h1 class="text-center"> {{ trans('frontend.search-list') }}</h1>
    <div class="row align-items-center libBox">
       <h5 class="text-center"> There are {{ $results->count() }} results</h5>
        @forelse($results->groupByType() as $type => $modelSearchResults)
    <div class="font-bold mt-4 mb-4 m-auto searchCatTitle btn btn-dark">
        {{ ($type == 'lessons') ? trans('frontend.lessons')
        : (($type == 'lectures') ? trans('frontend.lectures')
        : (($type == 'speeches') ? trans('frontend.speeches')
        :(( $type == 'books') ? trans('frontend.books')
        : (($type == 'benefits') ? trans('frontend.benefits')
        : (($type == 'articles') ? trans('frontend.articles')
        : ' ')))))}}
        </div>
    <ul class="list-inside">
        @foreach($modelSearchResults as $searchResult)
            <li class="list-disc mb-2 searchResult">
               <i class="fas fa-pen-square"></i>
               <a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a>
            </li>
        @endforeach
    </ul>
@empty
    No results.
@endforelse

    </div>
  </div>


@endsection
@section('script')
<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
