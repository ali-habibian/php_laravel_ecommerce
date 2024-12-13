@extends('admin.layouts.admin-layout')

@section('title', 'لیست بنرها')

@push('styles')
    <style>
        .truncate-description {
            max-width:300px;
            text-align: right;
            white-space: nowrap;
            text-overflow:ellipsis;
            overflow: hidden;
            word-wrap: break-word;
        }
    </style>
@endpush

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست بنرها ({{ $banners->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.banners.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد بنر
                    </a>
                </div>
            </div>
            <!-- End Topbar -->

            <!-- Brands Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>متن</th>
                        <th>اولویت</th>
                        <th>وضعیت</th>
                        <th>نوع</th>
                        <th>متن دکمه</th>
                        <th>لینک دکمه</th>
                        <th>آیکون دکمه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($banners as $key => $banner)
                        <tr>
                            <td>{{ $banners->firstItem() + $key }}</td>
                            <td>
                                <a target="_blank"
                                   href="{{ asset($banner->image) }}">{{explode('/', $banner->image)[array_key_last(explode('/', $banner->image))]}}</a>
                            </td>
                            <td>{{ $banner->title }}</td>
                            <td class="truncate-description">{{ $banner->description }}</td>
                            <td>{{ $banner->priority }}</td>
                            <td>
                                <span
                                    class="{{ $banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                    {{ $banner->is_active }}
                                </span>
                            </td>
                            <td>{{ $banner->type }}</td>
                            <td>{{ $banner->button_text }}</td>
                            <td>{{ $banner->button_link }}</td>
                            <td>{{ $banner->button_icon }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">عملیات
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.banners.show', ['banner' => $banner]) }}">نمایش</a>

                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.banners.edit', ['banner' => $banner]) }}">ویرایش</a>

                                        <hr>
                                        <a class="dropdown-item text-right delete-button text-danger"
                                           data-id="{{ $banner->id }}"
                                           href="#">حذف</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Brands Table -->

            <div class="d-flex justify-content-center mt-5">
                {{ $banners->render() }}
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bannerId = this.dataset.id;

                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: "این عملیات قابل بازگشت نیست!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'بله، حذف کن!',
                        cancelButtonText: 'لغو'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit it to delete the brand
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('admin.banners.destroy', ['banner' => ':id']) }}".replace(':id', bannerId);
                            form.innerHTML = `
                            @csrf
                            @method('DELETE')
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
