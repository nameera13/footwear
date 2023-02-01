<div class="form-group">
    <label for="parent_id">Select Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
        <option  value="0" @if(isset($category['parent_id']) && $category['parent_id']==0) selected="" @endif>Main Category</option>
        @if(!empty($getcategories))
            @foreach($getcategories as $parentcategory)
            <option @selected($parentcategory['id']==$categories['parent_id'])  value="{{ $parentcategory['id']}}" >{{$parentcategory['category_name']}}</option>
            @if(!empty($parentcategory['subcategories']))
                @foreach($parentcategory['subcategories'] as $subcategory)
                <option @selected($subcategory['id']==$categories['parent_id']) value="{{ $subcategory['id']}}" >&nbsp;&raquo;&nbsp;{{$subcategory['category_name']}}</option>
                @endforeach
                @endif
            @endforeach
        @endif
    </select>
    @error('parent_id')
        <div class="invalid-feedback">{{$message}}</div>
    @enderror
</div>