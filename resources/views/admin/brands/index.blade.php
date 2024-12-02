@extends('admin.layouts.admin-layout')

@section('title', 'لیست برندها')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست برندها ({{ $brands->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.brands.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد برند
                </a>
            </div>
            <!-- End Topbar -->

            <!-- Brands Table -->
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>وضعیت</th>
                    <th class="col-md-3">عملیات</th>
                </tr>
                </thead>

                <tbody>
                @foreach($brands as $key => $brand)
                    <tr>
                        <td>{{ $brands->firstItem() + $key }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <span class="{{ $brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $brand->is_active }}
                            </span>
                        </td>
                        <td class="col-md-3">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('admin.brands.show', ['brand' => $brand]) }}">نمایش</a>
                            <a class="btn btn-sm btn-outline-info mr-3" href="{{ route('admin.brands.edit', ['brand' => $brand]) }}">ویرایش</a>
                            <button class="btn btn-sm btn-outline-danger delete-button" data-id="{{ $brand->id }}">حذف</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- End Brands Table -->

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const brandId = this.dataset.id;

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
                            form.action = "{{ route('admin.brands.destroy', ['brand' => ':id']) }}" . replace(':id', brandId);
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
