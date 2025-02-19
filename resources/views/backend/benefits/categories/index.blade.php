@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('benefits.categories') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('benefits.categories') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('benefits.main') }} </span>
            </div>
        </div>
    </div>
@endsection
@section('content')


<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ trans('benefits.category-list') }}</h4>


                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.benefit-categories.create') }}" class="btn btn-success font-weight-bold" role="button"
                aria-pressed="true"> <i class="fa fa-plus"></i> {{ trans('btns.create-category') }} </a><br><br>


                <div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card overflow-hidden">
							<div class="card-header pb-0">
								<h3 class="card-title">{{ trans('benefits.categories') }}</h3>
								<p class="text-muted card-sub-title mb-0"></p>
							</div>
							<div class="card-body">
								<div class="panel-group1" id="accordion11">
									<div class="panel panel-default  mb-4">
										<div class="panel-heading1 bg-primary ">
											<h4 class="panel-title1">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion11" href="#collapseFour1" aria-expanded="false">
                                                    <i class="fe fe-arrow-left ml-2"></i>  {{ trans('benefits.all-main-categories') }}</a>
											</h4>
										</div>
										<div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
											<div class="panel-body border">
                                                @livewire('benefit-category-reorder')
											</div>
										</div>
									</div>
                                    <div class="panel panel-default mb-0">
										<div class="panel-heading1  bg-primary">
											<h4 class="panel-title1">
												<a class="accordion-toggle mb-0 collapsed" data-toggle="collapse" data-parent="#accordion11" href="#collapseFive2" aria-expanded="false">
                                                     <i class="fe fe-arrow-left ml-2"></i>{{ trans('benefits.all-sub-categories') }}</a>
											</h4>
										</div>
										<div id="collapseFive2" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
											<div class="panel-body border">

												<div class="table-responsive">
                                                    <table class="table text-md-nowrap" id="example1">
                                                        <thead>
                                                            <tr>
                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                <th class="wd-15p border-bottom-0">{{ trans('benefits.category-name') }}</th>
                                                                <th class="wd-20p border-bottom-0">{{ trans('benefits.benefit-count') }}</th>
                                                                <th class="wd-15p border-bottom-0">{{ trans('benefits.category-parent') }}</th>
                                                                <th class="wd-10p border-bottom-0">{{ trans('benefits.status') }}</th>
                                                                <th class="wd-10p border-bottom-0">{{ trans('benefits.creatred-at') }}</th>
                                                                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($subCategories)
                                                            @foreach ($subCategories as $subCategory )
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $subCategory->name }}</td>
                                                                <td>{{ $subCategory->benefits->count() }}</td>
                                                                <td>{{ $subCategory->parent != '' ? $subCategory->parent->name : '---' }}</td>
                                                                <td>{{ $subCategory->status() }}</td>
                                                                <td>{{ $subCategory->created_at->format('d-m-Y') }}</td>
                                                                <td>
                                                                    <div class="btn-group">

                                                                        <a href="{{ route('admin.benefit-categories.edit', $subCategory->id) }}"
                                                                            class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                                            <i class="fa fa-edit"></i></a>


                                                                    <form action="{{ route('admin.benefit-categories.destroy', $subCategory->id) }}" method="POST"
                                                                        class="dnone">
                                                                        @csrf
                                                                        @method('Delete')
                                                                        <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                                            data-name="{{ $subCategory->name }}" data-toggle="modal"
                                                                            data-target="#Delete_Fee{{ $subCategory->id }}"
                                                                            title="{{ trans('btns.delete') }}">
                                                                            <i class="fa fa-trash"></i></button>
                                                                    </form>
                                                                </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @endif


                                                        </tbody>
                                                            </table>
                                                        </div>

											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>




                    </div>
                </div>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- Container closed -->
</div>

@endsection
@section('js')

@include('backend.layouts.datatable-js')
@endsection
