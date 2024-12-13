@extends('admin.layouts.admin-layout')

@section('title', 'نمایش بنر')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">نمایش بنر: {{ $banner->title }}</h5>
            </div>

            <hr>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="title">عنوان</label>
                    <input class="form-control" id="title" name="title" type="text"
                           value="{{ $banner->title }}"
                           disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="priority">اولویت</label>
                    <input class="form-control" id="priority" name="priority" type="number"
                           value="{{ $banner->priority }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="is_active">وضعیت</label>
                    <input class="form-control" id="is_active" name="is_active" type="text"
                           value="{{ $banner->is_active }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="type">نوع بنر</label>
                    <input class="form-control" id="type" name="type" type="text"
                           value="{{ $banner->type }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="button_text">متن دکمه</label>
                    <input class="form-control" id="button_text" name="button_text" type="text"
                           value="{{ $banner->button_text }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="button_link">لینک دکمه</label>
                    <input class="form-control" id="button_link" name="button_link" type="text"
                           value="{{ $banner->button_link }}" disabled>
                </div>

                <div class="form-group col-md-3">
                    <label for="button_icon">آیکون دکمه</label>
                    <input class="form-control" id="button_icon" name="button_icon" type="text"
                           value="{{ $banner->button_icon }}" disabled>
                </div>

                <div class="form-group col-md-12">
                    <label for="description">متن</label>
                    <textarea class="form-control" id="description" rows="3" disabled
                              name="description">{{ $banner->description }}</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 mb-3">
                    <hr>
                    <p>تصویر:</p>
                </div>

                <div class="col-md-3 mb-5">
                    <div class="card" style="height: 100%">
                        <div class="card-body text-center">
                            <img src="{{ asset($banner->image) }}" class="card-img-top" alt="{{ $banner->name }}">
                        </div>

                    </div>
                </div>
            </div>

            <a href="{{ route('admin.banners.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
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
