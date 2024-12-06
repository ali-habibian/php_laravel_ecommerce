@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش دسته بندی')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش دسته بندی</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text"
                               value="{{ old('name', $category->name) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="parent_id">والد</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="" selected>بدون والد</option>
                            @foreach($parentCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}"
                                    @selected(old('parent_id', $category->parent_id) == $parentCategory->id)
                                >
                                    {{ $parentCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" @selected(old('is_active', $category->getRawOriginal('is_active')))>فعال
                            </option>
                            <option value="0" @selected(!old('is_active', $category->getRawOriginal('is_active')))>غیر
                                فعال
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="attributeSelect">ویژگی ها</label>
                        <select class="form-control selectpicker" id="attributeSelect" name="attribute_ids[]"
                                multiple data-live-search="true" title="انتخاب ویژگی ها">
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}"
                                    @selected(in_array($attribute->id, $category->attributeList()->pluck('id')->toArray()))
                                >
                                    {{ $attribute->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="attributeIsFilterSelect">ویژگی های قابل فیلتر</label>
                        <select class="form-control selectpicker" id="attributeIsFilterSelect"
                                name="attribute_is_filter_ids[]"
                                multiple data-live-search="true" title="انتخاب ویژگی های قابل فیلتر">
                            @foreach($category->attributeList()->wherePivot('is_filterable', true)->get() as $attribute)
                                <option value="{{ $attribute->id }}" selected>{{ $attribute->name }}</option>
                            @endforeach
                            @foreach($category->attributeList()->wherePivot('is_filterable', false)->get() as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="variationSelect">ویژگی متغیر</label>
                        <select class="form-control selectpicker" id="variationSelect" name="variation_id"
                                data-live-search="true" title="انتخاب ویژگی متغیر">
                            @foreach($category->attributeList()->wherePivot('is_variation', true)->get() as $attribute)
                                <option value="{{ $attribute->id }}" selected>{{ $attribute->name }}</option>
                            @endforeach
                            @foreach($category->attributeList()->wherePivot('is_variation', false)->get() as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="icon">آیکون</label>
                        <input class="form-control" id="icon" name="icon" type="text"
                               value="{{ old('icon', $category->icon) }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description"
                                  name="description">{{ old('description', $category->description) }}</textarea>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#selectpicker').selectpicker();

        $('#attributeSelect').on('changed.bs.select', function () {
            let selectedAttributes = $(this).val(); // Get selected attributes
            let attributes = @json($attributes); // Laravel passes data as JSON
            let filterableAttributes = [];

            let attributeIsFilterSelectElement = $('#attributeIsFilterSelect');
            let variationSelectElement = $('#variationSelect');

            // Filter attributes based on selected ones
            attributes.forEach(function (attribute) {
                if (selectedAttributes.includes(attribute.id.toString())) {
                    filterableAttributes.push(attribute);
                }
            });

            // Clear existing options
            attributeIsFilterSelectElement.empty();
            variationSelectElement.empty();

            // Add new options
            filterableAttributes.forEach(function (attribute) {
                let optionsForAttributeIsFilterSelect = $('<option>', {
                    value: attribute.id,
                    text: attribute.name
                });
                attributeIsFilterSelectElement.append(optionsForAttributeIsFilterSelect);

                let optionsForVariationSelect = $('<option>', {
                    value: attribute.id,
                    text: attribute.name
                });
                variationSelectElement.append(optionsForVariationSelect);
            });

            // Refresh the selectpicker after appending new options
            attributeIsFilterSelectElement.selectpicker('refresh');
            variationSelectElement.selectpicker('refresh');
        });
    </script>
@endpush
