@extends('admin.layouts.admin-layout')

@section('title', 'لیست دسته بندی ها')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست دسته بندی ها ({{ $categories->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد دسته بندی
                </a>
            </div>
            <!-- End Topbar -->

            <!-- Categories Table -->
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>والد</th>
                    <th>توضیحات</th>
                    <th>وضعیت</th>
                    <th class="col-md-3">عملیات</th>
                </tr>
                </thead>

                <tbody>
                @foreach($categories as $key => $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $key }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parentName() }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <span
                                class="{{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $category->is_active }}
                            </span>
                        </td>
                        <td class="col-md-3">
                            <a class="btn btn-sm btn-outline-success"
                               href="{{ route('admin.categories.show', ['category' => $category]) }}">نمایش</a>
                            <a class="btn btn-sm btn-outline-info mr-3"
                               href="{{ route('admin.categories.edit', ['category' => $category]) }}">ویرایش</a>
                            <button class="btn btn-sm btn-outline-danger delete-button mr-3"
                                    data-id="{{ $category->id }}">حذف
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- End Categories Table -->

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const categoryId = this.dataset.id;

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
                            form.action = "{{ route('admin.categories.destroy', ['category' => ':id']) }}".replace(':id', categoryId);
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
