@extends('admin.layouts.admin-layout')

@section('title', 'لیست دیدگاه ها')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست دیدگاه ها (</h5>
            </div>
            <!-- End Topbar -->

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام کاربر</th>
                        <th>نام محصول</th>
                        <th>متن دیدگاه</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($comments as $key => $comment)
                        <tr>
                            <td>{{ $comments->firstItem() + $key }}</td>
                            <td>{{ $comment->user->name }}</td>
                            <td>
                                <a href="{{ route('admin.products.show', $comment->product) }}">{{ $comment->product->name }}</a>
                            </td>
                            <td>{{ $comment->text }}</td>
                            <td>
                            <span
                                    class="{{ $comment->getRawOriginal('approved') ? 'text-success' : 'text-danger' }}">
                                {{ $comment->approved }}
                            </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">عملیات
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.comments.show', $comment) }}">مشاهده</a>

                                        <a class="dropdown-item text-right {{ $comment->getRawOriginal('approved') ? 'text-warning' : 'text-success' }}"
                                           href="{{ route('admin.comments.change-approval-status', $comment) }}">{{ $comment->getRawOriginal('approved') ? 'عدم تایید' : 'تایید' }}</a>

                                        <a class="dropdown-item text-right delete-button text-danger"
                                           data-id="{{ $comment->id }}"
                                           href="#">حذف</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Products Table -->

            <div class="d-flex justify-content-center mt-5">
                {{ $comments->render() }}
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
                    const commentId = this.dataset.id;

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
                            form.action = "{{ route('admin.comments.destroy', ['comment' => ':id']) }}".replace(':id', commentId);
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
