
@foreach($subcategories as $subcategory)
        <ul>
            <i class="fas fa-level-down-alt icon-path"></i>
            <label style="font-size: 16px;">
                <input type="radio" name="lecture_category_id" value= "{{ $subcategory->id }}"
                {{ old('lecture_category_id',$model->lecture_category_id) == $subcategory->id ?'checked' : '' }}>


            {{ $subcategory->name }}</label>

	    @if(count($subcategory->subcategory))
            @include('backend.lectures.lectures.subCategoryListEdit',['subcategories' => $subcategory->subcategory])
        @endif
        </ul>

@endforeach


