<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap" id="example1">
        <thead>
            <tr>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('videos.category-name') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('videos.video-count') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('videos.status') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('videos.creatred-at') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

            </tr>
        </thead>
        <tbody wire:sortable="updateCategoryOrder">
            @if ($categories)
            @foreach ($categories as $category )
            <tr class="reOrder" wire:sortable.item="{{ $category->id }}" wire:key="videoCategory-{{ $category->id }}"
                wire:sortable.handle>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->videos->count() }}</td>
                <td>{{ $category->status() }}</td>
                <td>{{ $category->created_at->format('Y-m-d') }}</td>
                <td>
                    <div class="btn-group">

                        <a href="{{ route('admin.video-categories.edit', $category->id) }}"
                            class="btn btn-info btn-sm" role="button" aria-pressed="true">
                            <i class="fa fa-edit"></i></a>


                    <form action="{{ route('admin.video-categories.destroy', $category->id) }}" method="POST"
                        class="dnone">
                        @csrf
                        @method('Delete')
                        <button id="delete" type="button" class="btn btn-danger btn-sm"
                            data-name="{{ $category->name }}" data-toggle="modal"
                            data-target="#Delete_Fee{{ $category->id }}"
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
