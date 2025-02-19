<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped">

        <thead>
            <tr>
                <th style="max-width: 2%" class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('articles.article-name') }}</th>
                <th style="max-width: 6%" class="wd-20p border-bottom-0">{{ trans('articles.article-category') }}</th>
                <th style="max-width: 6%" class="wd-10p border-bottom-0">{{ trans('articles.status') }}</th>
                <th style="max-width: 6%" class="wd-15p border-bottom-0">{{ trans('articles.publish-date') }}</th>
               
            </tr>
        </thead>
        <tbody wire:sortable="updateArticleOrder">
            @if ($articles)
                @foreach ($articles as $article)
                    <tr class="reOrder" wire:sortable.item="{{ $article->id }}" wire:key="article-{{ $article->id }}"
                        wire:sortable.handle>
                        <td>{{ $article->id }}</td>
                        <td style="width: 200px">{{ $article->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->status() }}</td>
                        <td style="width : 70px">{{ $article->publish_date->format('Y-m-d') }}</td>
                       
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
