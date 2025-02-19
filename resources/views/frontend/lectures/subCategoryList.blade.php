@foreach ($subcategories as $subcategory)

      <li style="border-right: 1px solid #ddd">

        <ul>
            <i class="fas fa-level-down-alt"></i>
            <a href="{{ route('frontend.lectures.category.lectures', $subcategory->slug) }}"
                title="{{ $subcategory->name }}">
                {{ $subcategory->name }} <span style="color: var(--scoundry-color)">(<span style="color: var(--black-color)">{{$subcategory->lectures->count()}}</span>)</span>
            </a>

    @if (count($subcategory->subcategory))
        @include('frontend.lectures.subCategoryList', ['subcategories' => $subcategory->subcategory])
    @endif
        </ul>
     </li>

@endforeach
