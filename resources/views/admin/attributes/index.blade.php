@extends('admin.layouts.admin-layout')

@section('title', 'لیست ویژگی ها')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست ویژگی ها ({{ $attributes->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.attributes.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد ویژگی
                </a>
            </div>
            <!-- End Topbar -->

            <!-- Brands Table -->
            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th class="col-md-3">عملیات</th>
                </tr>
                </thead>

                <tbody>
                @foreach($attributes as $key => $attribute)
                    <tr>
                        <td>{{ $attributes->firstItem() + $key }}</td>
                        <td>{{ $attribute->name }}</td>
                        <td class="col-md-3">
                            <a class="btn btn-sm btn-outline-success" href="{{ route('admin.attributes.show', ['attribute' => $attribute]) }}">نمایش</a>
                            <a class="btn btn-sm btn-outline-info mr-3" href="{{ route('admin.attributes.edit', ['attribute' => $attribute]) }}">ویرایش</a>
                            <button class="btn btn-sm btn-outline-danger delete-button mr-3" data-id="{{ $attribute->id }}">حذف</button>
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
                    const attributeId = this.dataset.id;

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
                            form.action = "{{ route('admin.attributes.destroy', ['attribute' => ':id']) }}" . replace(':id', attributeId);
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
