@extends('admin.layouts.admin-layout')

@section('title', 'ایجاد بنر')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ایجاد بنر</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="title">عنوان</label>
                        <input class="form-control" id="title" name="title" type="text" value="{{ old('title') }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="priority">اولویت</label>
                        <input class="form-control" id="priority" name="priority" type="number" value="{{ old('priority') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">فعال</option>
                            <option value="0">غیر فعال</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="type">نوع بنر</label>
                        <input class="form-control" id="type" name="type" type="text" value="{{ old('type') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="button_text">متن دکمه</label>
                        <input class="form-control" id="button_text" name="button_text" type="text" value="{{ old('button_text') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="button_link">لینک دکمه</label>
                        <input class="form-control" id="button_link" name="button_link" type="text" value="{{ old('button_link') }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="button_icon">آیکون دکمه</label>
                        <input class="form-control" id="button_icon" name="button_icon" type="text" value="{{ old('button_icon') }}">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">متن</label>
                        <textarea class="form-control" id="description" rows="3"
                                  name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="image">انتخاب تصویر</label>
                        <div class="custom-file">
                            <input class="custom-file-input" id="image" name="image" type="file">
                            <label class="custom-file-label" for="image">انتخاب فایل</label>
                        </div>
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
        $('#image').change(function () {
            // get the file name
            const fileNameWithExtension = $(this).val().split('\\').pop();
            // Split the file name by '.' and take all parts except the last one
            const nameParts = fileNameWithExtension.split('.');
            // Join the parts back together, excluding the last part (the extension)
            const fileName = nameParts.slice(0, -1).join('.');
            // replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
@endpush
