<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped">

        <thead>
            <br>
            <tr>
                 <th style="max-width: 2%" class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('books.book-name') }}</th>
                <th style="max-width: 6%" class="wd-20p border-bottom-0">{{ trans('books.book-category') }}</th>
                <th style="max-width: 6%" class="wd-10p border-bottom-0">{{ trans('books.status') }}</th>
                <th style="max-width: 6%" class="wd-15p border-bottom-0">{{ trans('books.publish-date') }}</th>


            </tr>
        </thead>
        <tbody wire:sortable="updateBookOrder">
            @if ($books)
                @foreach ($books as $book)
                    <tr class="reOrder" wire:sortable.item="{{ $book->id }}" wire:key="book-{{ $book->id }}"
                        wire:sortable.handle>
                        <td>{{ $book->id }}</td>
                        <td  style="width: 200px">{{ $book->name }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>{{ $book->status() }}</td>
                        <td style="width : 70px">{{ $book->publish_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
