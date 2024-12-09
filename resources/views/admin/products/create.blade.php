@extends('admin.layouts.admin-layout')

@section('title', 'ایجاد محصول')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد محصول</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brandSelect">برند</label>
                        <select class="form-control selectpicker" id="brandSelect" name="brand_id"
                                data-live-search="true" title="انتخاب برند">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">فعال</option>
                            <option value="0">غیر فعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tagSelect">تگ ها</label>
                        <select class="form-control selectpicker" id="tagSelect" name="tag_ids[]"
                                multiple data-live-search="true" title="انتخاب تگ ها">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description"
                                  name="description">{{ old('description') }}</textarea>
                    </div>

                    {{-- Product image section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>تصاویر محصول:</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="primary_image">انتخاب تصویر اصلی</label>
                        <div class="custom-file">
                            <input class="custom-file-input" id="primary_image" name="primary_image" type="file">
                            <label class="custom-file-label" for="primary_image">انتخاب فایل</label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="images">انتخاب تصاویر</label>
                        <div class="custom-file">
                            <input class="custom-file-input" id="images" name="images[]" type="file" multiple>
                            <label class="custom-file-label" for="primary_image">انتخاب فایل ها</label>
                        </div>
                    </div>

                    {{-- Category & Attribute section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>دسته بندی و ویژگی ها:</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="categorySelect">دسته بندی</label>
                        <select class="form-control selectpicker" id="categorySelect" name="category_id"
                                data-live-search="true" title="انتخاب دسته بندی">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}
                                    - {{ $category->parentName() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12" id="attributesContainer">
                        <div class="row" id="attributesRow"></div>

                        <div class="col-md-12">
                            <hr>
                            <p>افزودن قیمت و موجودی برای ویژگی متغیر <span class="font-weight-bold"
                                                                           id="variationNameSpan"></span>: </p>
                        </div>

                        <div class="form-container">
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
                                        <input class="form-control repeater-input" name="variation_values[quantity][]"
                                               type="text">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">شناسه انبار (SKU)</label>
                                        <input class="form-control repeater-input" name="variation_values[sku][]"
                                               type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="add-row btn btn-outline-primary btn-sm mt-3"><i
                                class="fa fa-plus"></i> افزودن
                        </button>


                    </div>

                    {{-- Delivery Cost section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>هزینه ارسال:</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال</label>
                        <input class="form-control" id="delivery_amount" name="delivery_amount" type="text"
                               value="{{ old('delivery_amount') }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال به ازای هر محصول اضافی</label>
                        <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product"
                               type="text" value="{{ old('delivery_amount_per_product') }}"
                               autofocus>
                    </div>

                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#selectpicker').selectpicker();

        $('#primary_image').change(function () {
            // get the file name
            const fileNameWithExtension = $(this).val().split('\\').pop();
            // Split the file name by '.' and take all parts except the last one
            const nameParts = fileNameWithExtension.split('.');
            // Join the parts back together, excluding the last part (the extension)
            const fileName = nameParts.slice(0, -1).join('.');
            // replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });


        $('#images').change(function () {
            // get multiple files names
            const files = $(this)[0].files;
            const fileNames = Array.from(files).map(file => {
                // Split the file name by '.' and take all parts except the last one
                const nameParts = file.name.split('.');
                // Join the parts back together, excluding the last part (the extension)
                return nameParts.slice(0, -1).join('.');
            }).join(', ');
            // replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileNames);
        });

        $('#attributesContainer').hide();
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
