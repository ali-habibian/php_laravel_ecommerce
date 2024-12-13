@extends('admin.layouts.admin-layout')

@section('title', 'لیست محصولات')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">لیست محصولات ({{ $products->total() }})</h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.create') }}">
                        <i class="fa fa-plus"></i>
                        ایجاد محصول
                    </a>
                </div>
            </div>
            <!-- End Topbar -->

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>نام برند</th>
                        <th>نام دسته بندی</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{ $products->firstItem() + $key }}</td>
                            <td>
                                <a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.brands.show', $product->brand) }}">{{ $product->brand->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.show', $product->category) }}">{{ $product->category->name }}</a>
                            </td>
                            <td>
                            <span
                                class="{{ $product->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $product->is_active }}
                            </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">عملیات
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.products.edit', $product) }}">ویرایش محصول</a>

                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.products.images.edit', $product) }}">ویرایش تصاویر</a>

                                        <a class="dropdown-item text-right"
                                           href="{{ route('admin.products.edit.category-attributes', $product) }}">ویرایش دسته بندی و ویژگی ها</a>

                                        <hr>
                                        <a class="dropdown-item text-right delete-button text-danger"
                                           data-id="{{ $product->id }}"
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
                {{ $products->render() }}
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
