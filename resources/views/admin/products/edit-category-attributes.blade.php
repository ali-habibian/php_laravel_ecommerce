@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش دسته بندی و ویژگی های محصول')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش دسته بندی و ویژگی های محصول: {{ $product->name }}</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.products.update.category-attributes', $product) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    {{-- Category & Attribute section --}}
                    <div class="form-group col-md-3">
                        <label for="categorySelect">دسته بندی</label>
                        <select class="form-control selectpicker" id="categorySelect" name="category_id"
                                data-live-search="true" title="انتخاب دسته بندی">
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" @selected(old('category_id', $product->category_id) === $category->id)>
                                    {{ $category->name }} - {{ $category->parentName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12" id="attributesContainer">
                        <div class="row" id="attributesRow">
                            @foreach($product->productAttributes as $productAttribute)
                                <div class="form-group col-md-3">
                                    <label
                                        for="attribute_{{ $productAttribute->attribute->id }}">{{ $productAttribute->attribute->name }}</label>
                                    <input class="form-control" id="attribute_{{ $productAttribute->attribute->id }}"
                                           name="attribute_ids[{{ $productAttribute->attribute->id }}]" type="text"
                                           value="{{ $productAttribute->value }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <p>افزودن قیمت و موجودی برای ویژگی متغیر <span class="font-weight-bold"
                                                                           id="variationNameSpan"></span>: </p>
                        </div>

                        <div class="form-container">
                            @if(count($product->productVariations) > 0)
                                @foreach($product->productVariations as $productVariation)
                                    <div class="repeater row">
                                        <div class="mr-3 ml-4">
                                            <button type="button" class="remove-row btn btn-outline-danger btn-sm"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                        <div class="row repeater-row col-md-11">
                                            <div class="form-group col-md-3">
                                                <label class="form-label">نام</label>
                                                <input class="form-control repeater-input"
                                                       name="variation_values[value][]"
                                                       type="text"
                                                       value="{{ $productVariation->value }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="form-label">قیمت</label>
                                                <input class="form-control repeater-input"
                                                       name="variation_values[price][]"
                                                       type="text"
                                                       value="{{ $productVariation->price }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="form-label">تعداد</label>
                                                <input class="form-control repeater-input"
                                                       name="variation_values[quantity][]"
                                                       type="text"
                                                       value="{{ $productVariation->quantity }}">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="form-label">شناسه انبار (SKU)</label>
                                                <input class="form-control repeater-input"
                                                       name="variation_values[sku][]"
                                                       type="text"
                                                       value="{{ $productVariation->sku }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="repeater row">
                                    <div class="mr-3 ml-4">
                                        <button type="button" class="remove-row btn btn-outline-danger btn-sm"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                    <div class="row repeater-row col-md-11">
                                        <div class="form-group col-md-3">
                                            <label class="form-label">نام</label>
                                            <input class="form-control repeater-input" name="variation_values[value][]"
                                                   type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">قیمت</label>
                                            <input class="form-control repeater-input" name="variation_values[price][]"
                                                   type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">تعداد</label>
                                            <input class="form-control repeater-input"
                                                   name="variation_values[quantity][]"
                                                   type="text">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="form-label">شناسه انبار (SKU)</label>
                                            <input class="form-control repeater-input" name="variation_values[sku][]"
                                                   type="text">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="add-row btn btn-outline-primary btn-sm mt-3"><i
                                class="fa fa-plus"></i> افزودن
                        </button>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#selectpicker').selectpicker();

        $('#attributesContainer').show();
        $('#categorySelect').on('changed.bs.select', function () {
            // Get the selected category ID
            const categoryId = $(this).val();
            // Construct the URL to fetch category attributes
            let url = "{{ route('admin.category.attributes', ':id') }}";
            url = url.replace(':id', categoryId);

            // Perform an AJAX GET request to fetch attributes for the selected category
            $.get(url, function (response, status) {
                if (status === 'success') {
                    // Show the attributes container
                    $('#attributesContainer').fadeIn();

                    // Clear existing attributes in the form
                    $('#attributesRow').empty();

                    // Iterate over each attribute in the response and append it to the form
                    response.attributes.forEach(attribute => {
                        let attributeFormGroup = `
                <div class="form-group col-md-3">
                    <label for="attribute_${attribute.id}">${attribute.name}</label>
                    <input class="form-control" id="attribute_${attribute.id}" name="attribute_ids[${attribute.id}]" type="text">
                </div>
            `;

                        $('#attributesRow').append(attributeFormGroup);
                    });

                    $('#variationNameSpan').text(response.variation.name);

                } else {
                    // Alert the user if there was an issue fetching attributes
                    alert('مشکلی در دریافت ویژگی ها به وجود آمده است');
                }
            }).fail(function () {
                // Alert the user if the AJAX request failed
                alert('مشکلی در دریافت ویژگی ها به وجود آمده است');
            });
        });

        $(document).on('click', '.add-row', function () {
            const $clone = $('.repeater:first').clone();
            $clone.find('input').val('');
            $('.form-container').append($clone);
        });

        $(document).on('click', '.remove-row', function () {
            if ($('.repeater').length > 1) {
                $(this).closest('.repeater').remove();
            }
        });

    </script>
@endpush
