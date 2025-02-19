@extends('backend.layouts.master')
@section('css')
<style>
  section {
    background: #0162e824;
    padding: 10px;
    border-radius: 6px;
    box-shadow: 1px 1px 10px #ddd;
  }
  section h3 {
    color: #24b7ab;
    font-weight: bold;
  }
</style>
@endsection
@section('title')
    {{ trans('users.role-create') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('users.roles') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('users.role-create') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('users.role-create') }}</h4>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('users.roles') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.roles.store') }}" method="Post">
                        @csrf
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.role-name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label
                                        style="font-weight: bold;
                                               font-size: 28px;
                                               color: #03aad7;"
                                        for="permission">{{ trans('users.permissions') }}</label>
                                    <br>
                                    <input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)">
                                    <label for='selectAll'> {{ trans('users.permission-select_all') }} </label>
                                    <br>
                                    <div class="row mt-5">
                                        @forelse ($permissions as $permission)
                                            <label class="col-md-3 rolesName">
                                                <input type="checkbox" name="permission[]" value="{{ $permission->id }}" class="box1">
                                                {{ $permission->name }}
                                            </label>
                                        @empty
                                        @endforelse
                                    </div>
                                    @error('permission')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <section class="EventsSection mt-3" >
                            <h3>Events</h3>
                        </section>
                        <section class="FatwaSection mt-3">
                            <h3>Fatwa</h3>
                        </section>
                        <section class="SliderSection mt-3">
                            <h3>Slider</h3>
                        </section>
                        <section class="lessonSection mt-3">
                             <h3>Lessons</h3>
                        </section>
                        <section class="lectureSection mt-3">
                            <h3>Lecture</h3>
                        </section>
                        <section class="speechesSection mt-3">
                            <h3>Speeches</h3>
                        </section>
                        <section class="articlesSection mt-3">
                            <h3>Articles</h3>
                        </section>
                        <section class="booksSection mt-3">
                            <h3>Books</h3>
                        </section>
                        <section class="BenefitsSection mt-3">
                            <h3>Benefits</h3>
                        </section>
                        <section class="GallerySection mt-3">
                            <h3>Gallery</h3>
                        </section>
                        <section class="matwyaatSection mt-3">
                            <h3>Matwiaat</h3>
                        </section>
                        <section class="LiveSection mt-3">
                            <h3>Live Air</h3>
                        </section>
                        <section class="audioSection mt-3">
                            <h3>Audio Library</h3>
                        </section>
                        <section class="VideoSection mt-3">
                            <h3>Video Library</h3>
                        </section>
                        <section class="UsersSection mt-3">
                            <h3>Users</h3>
                        </section>
                        <section class="SubscribersSection mt-3">
                            <h3>Subscribers</h3>
                        </section>
                        <section class="ClientsSection mt-3">
                            <h3>Clients</h3>
                        </section>
                        <section class="ContactSection mt-3">
                            <h3>Contact-US</h3>
                        </section>
                        <section class="RolesSection mt-3">
                            <h3>Roles</h3>
                        </section>
                        <section class="SettingSection mt-3">
                            <h3>Settings</h3>
                        </section>
                        <section class="ReportsSection mt-3">
                            <h3>Reports</h3>
                        </section>
                        <section class="ActivitySection mt-3">
                            <h3>Activity-Log</h3>
                        </section>

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
<script>
    let rolesName = document.querySelectorAll(".rolesName");
    let lessonSection = document.querySelector(".lessonSection");
    let lectureSection = document.querySelector(".lectureSection");
    let speechesSection = document.querySelector(".speechesSection");
    let articlesSection = document.querySelector(".articlesSection");
    let booksSection = document.querySelector(".booksSection");
    let BenefitsSection = document.querySelector(".BenefitsSection");
    let GallerySection = document.querySelector(".GallerySection");
    let matwyaatSection = document.querySelector(".matwyaatSection");
    let LiveSection = document.querySelector(".LiveSection");
    let audioSection = document.querySelector(".audioSection");
    let VideoSection = document.querySelector(".VideoSection");
    let UsersSection = document.querySelector(".UsersSection");
    let SubscribersSection = document.querySelector(".SubscribersSection");
    let ClientsSection = document.querySelector(".ClientsSection");
    let ContactSection = document.querySelector(".ContactSection");
    let SliderSection = document.querySelector(".SliderSection");
    let EventsSection = document.querySelector(".EventsSection");
    let FatwaSection = document.querySelector(".FatwaSection");
    let RolesSection = document.querySelector(".RolesSection");
    let ReportsSection = document.querySelector(".ReportsSection");
    let ActivitySection = document.querySelector(".ActivitySection");
    let SettingSection = document.querySelector(".SettingSection");

    rolesName.forEach(function(el) {
        if(el.innerText.includes('Lesson')){
            lessonSection.append(el)
        }
        if(el.innerText.includes('Lecture')){
            lectureSection.append(el)
        }
        if(el.innerText.includes('Speeches')){
            speechesSection.append(el)
        }
        if(el.innerText.includes('Articles')){
            articlesSection.append(el)
        }
        if(el.innerText.includes('Books')){
            booksSection.append(el)
        }
        if(el.innerText.includes('Benefits')){
            BenefitsSection.append(el)
        }
        if(el.innerText.includes('Gallery')){
            GallerySection.append(el)
        }
        if(el.innerText.includes('Matwiaat')){
            matwyaatSection.append(el)
        }
        if(el.innerText.includes('Live')){
            LiveSection.append(el)
        }
        if(el.innerText.includes('Audio')){
            audioSection.append(el)
        }
        if(el.innerText.includes('Video')){
            VideoSection.append(el)
        }
        if(el.innerText.includes('Users')){
            UsersSection.append(el)
        }
        if(el.innerText.includes('Subscribers')){
            SubscribersSection.append(el)
        }
        if(el.innerText.includes('Clients')){
            ClientsSection.append(el)
        }
        if(el.innerText.includes('Contact')){
            ContactSection.append(el)
        }
        if(el.innerText.includes('Slider')){
            SliderSection.append(el)
        }
        if(el.innerText.includes('Event')){
            EventsSection.append(el)
        }
        if(el.innerText.includes('Fatwa')){
            FatwaSection.append(el)
        }
        if(el.innerText.includes('Roles')){
            RolesSection.append(el)
        }
        if(el.innerText.includes('Reports')){
            ReportsSection.append(el)
        }
        if(el.innerText.includes('Activity')){
            ActivitySection.append(el)
        }
        if(el.innerText.includes('Setting')){
            SettingSection.append(el)
        }
    });

</script>

@endsection
