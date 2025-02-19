<div class="card-body">
<form action="{{ route('admin.lessons.index') }}" method="GET">
    @csrf
    <div class="row">
        <div class="col-2">
            <div class="form-group">
                <select name="order_by" class="form-control" id="filter">
                    <option value="">Order By</option>
                    <option value="asc" {{ old('order_by' ,request()->input('order_by')) == 'asc' ? 'selected' : ''}}>Ascending</option>
                    <option value="desc" {{ old('order_by' ,request()->input('order_by')) == 'desc' ? 'selected' : ''}}>Descending</option>
                </select>
            </div>
        </div>



        <div class="col-1">
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-link">Search</button>
            </div>
        </div>



    </div>

</form>
</div>
