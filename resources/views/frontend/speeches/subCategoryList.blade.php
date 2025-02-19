@foreach ($subcategories as $subcategory)

      <li style="border-right: 1px solid #ddd">

        <ul>
            <i class="fas fa-level-down-alt"></i>
            <a href="{{ route('frontend.speeches.category.speeches', $subcategory->slug) }}" title="{{ $subcategory->name }}">
                {{ $subcategory->name }} <span style="color: var(--scoundry-color)">(<span style="color: var(--black-color)">{{$subcategory->speeches->count()}}</span>)</span>
            </a>

    @if (count($subcategory->subcategory))
        @include('frontend.speeches.subCategoryList', ['subcategories' => $subcategory->subcategory])
    @endif
        </ul>
     </li>

@endforeach
