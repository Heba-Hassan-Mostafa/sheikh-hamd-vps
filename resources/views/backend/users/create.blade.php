@extends('backend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection
@section('title')
    {{ trans('users.user-create') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('users.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('users.user-create') }}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ trans('users.user-create') }}</h4>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('users.users') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.users.store') }}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.first-name') }}</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                                        class="form-control">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.last-name') }}</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="form-control">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.email') }}</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                <label for="password">{{ trans('users.password') }}</label>
                                <input type="password" name="password" value="{{ old('password') }}" class="form-control">
                                  @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                             </div>


                        <div class="col-4">
                            <div class="form-group">
                            <label for="password_confirmation">{{ trans('users.confirm-password') }}</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control">
                              @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="phone">{{ trans('users.phone') }}</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="form-control">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>



                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <label for="image">{{ trans('users.img') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" name="image" class='form-control'>
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mt-5">
                                <label for="roles">{{ trans('users.roles') }}</label>
                                <select name="roles[]" class="form-control select2" multiple="multiple">
                                    @forelse($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="form-group pt-4">
                            <button type="submit" name="save" class="btn btn-primary">
                                {{ trans('btns.save') }}</button>

                        </div>


                    </form>


                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- Container closed -->
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {

            //select2 with search
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            $(".select2").select2({
                tags: true,
                closeOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });
        });
    </script>
@endsection
