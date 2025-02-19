@foreach ($subcategories as $subcategory)

      <li style="border-right: 1px solid #ddd">

        <ul>
            <i class="fas fa-level-down-alt"></i>
            <a href="{{ route('frontend.lessons.category.lessons', $subcategory->slug) }}" title="{{ $subcategory->name }}">
                {{ $subcategory->name }} <span style="color: var(--scoundry-color)">(<span style="color: var(--black-color)">{{$subcategory->lessons->count()}}</span>)</a>

    @if (count($subcategory->subcategory))
        @include('frontend.lessons.subCategoryList', ['subcategories' => $subcategory->subcategory])
    @endif
        </ul>
     </li>

@endforeach
