@extends('admin.layouts.admin-layout')

@section('title', 'لیست کاربران')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست کاربران ({{ $users->total() }})</h5>
            </div>
            <!-- End Topbar -->

            <!-- Brands Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>آواتار</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>شماره تلفن</th>
                        <th>عضویت از طریق</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $key => $user)

                        <tr>
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td><img width="48px" src="{{ $user->avatar ? $user->avatar : asset('images/home/default-user-avatar.png') }}" alt="avatar"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->provider_name ?? 'ثبت نام با ایمیل' }}</td>
                            <td>
                                <div class="text-center">
                                    <!-- Edit Button -->
                                    <a class="btn text-primary" href="{{ route('admin.users.edit', $user) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <a class="btn delete-button text-danger" data-id="{{ $user->id }}" href="#">
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
                {{ $users->render() }}
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
                    const userId = this.dataset.id;

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
                            form.action = "{{ route('admin.users.destroy', ['user' => ':id']) }}".replace(':id', userId);
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
