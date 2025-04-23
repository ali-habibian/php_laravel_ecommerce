@extends('admin.layouts.admin-layout')

@section('title', 'لیست نقش‌ها')

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
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست نقش‌ها ({{ $roles->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.roles.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد نقش‌
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
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $key }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->guard_name }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">عملیات
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.roles.show', ['role' => $role]) }}">نمایش</a>

                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.roles.edit', ['role' => $role]) }}">ویرایش</a>

                                        <hr>
                                        <a class="dropdown-item text-right delete-button text-danger"
                                           data-id="{{ $role->id }}"
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
                {{ $roles->render() }}
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
                    const roleId = this.dataset.id;

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
                            form.action = "{{ route('admin.roles.destroy', ['role' => ':id']) }}".replace(':id', roleId);
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
