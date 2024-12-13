@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش تصاویر محصول')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش تصاویر: {{ $product->name }}</h5>
            </div>

            <hr>

            @include('admin.sections.errors')

            {{-- Show primary image --}}
            <div class="row">
                <div class="col-12 col-md-12 mb-5">
                    <p>تصویر اصلی:</p>
                </div>

                <div class="col-md-3 mb-5">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ asset($product->primary_image) }}" class="card-img-top"
                                 alt="{{ $product->name }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Show oher images --}}
            <div class="row">
                <div class="col-12 col-md-12 mb-5">
                    <hr>
                    <p>سایر تصویر:</p>
                </div>

                @foreach($product->productImages as $image)
                    <div class="col-md-3 mb-5">
                        <div class="card" style="height: 100%">
                            <div class="card-body text-center">
                                <img src="{{ asset($image->image) }}" class="card-img-top" alt="{{ $product->name }}">

                            </div>
                            <div class="card-footer text-center">
                                <div class="mt-3">
                                    <form id="setPrimaryForm-{{ $image->id }}"
                                          action="{{ route('admin.products.images.set-primary', $product) }}"
                                          method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                                        <button type="button"
                                                class="btn btn-sm btn-primary mb-3"
                                                onclick="confirmAction('setPrimaryForm-{{ $image->id }}', 'تصویر اصلی قبلی حذف خواهد شد، آیا مطمئن هستید که می‌خواهید این تصویر را به عنوان تصویر اصلی انتخاب کنید؟')">
                                            انتخاب به عنوان تصویر اصلی
                                        </button>
                                    </form>

                                    <form id="deleteForm-{{ $image->id }}"
                                          action="{{ route('admin.products.images.destroy', $product) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                                        <button type="button"
                                                class="btn btn-sm btn-danger mb-3"
                                                onclick="confirmAction('deleteForm-{{ $image->id }}', 'آیا مطمئن هستید که می‌خواهید این تصویر را حذف کنید؟')">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <form action="{{ route('admin.products.images.add', $product) }}" method="post"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Product image section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>اضافه کردن تصاویر جدید:</p>
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

    <script>
        /**
         * Displays a confirmation dialog using SweetAlert2 and submits a form if the user confirms the action.
         *
         * @param {string} formId - The ID of the form to be submitted if the user confirms the action.
         * @param {string} message - The message to be displayed in the confirmation dialog.
         */
        function confirmAction(formId, message) {
            Swal.fire({
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله، انجام بده!',
                cancelButtonText: 'لغو'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endpush
