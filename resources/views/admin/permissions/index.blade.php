@extends('admin.layouts.admin-layout')

@section('title', 'لیست مجوز‌ها')

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
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست مجوز‌ها ({{ $permissions->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.permissions.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد مجوز‌
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
                        <th>نام</th>
                        <th>نام نمایشی</th>
                        <th>گارد (guard)</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr>
                            <td>{{ $permissions->firstItem() + $key }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->display_name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td>
                                <div class="text-center">
                                    <!-- Edit Button -->
                                    <a class="btn text-primary" href="{{ route('admin.permissions.edit', $permission) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <a class="btn delete-button text-danger" data-id="{{ $permission->id }}" href="#">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Brands Table -->

            <div class="d-flex justify-content-center mt-5">
                {{ $permissions->render() }}
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
                    const permissionId = this.dataset.id;

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
                            form.action = "{{ route('admin.permissions.destroy', ['permission' => ':id']) }}".replace(':id', permission);
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
