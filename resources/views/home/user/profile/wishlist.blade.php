@extends('home.layouts.home')

@section('title', 'پروفایل - علاقه‌مندی ها')

@section('content')
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{ route('home.index') }}">صفحه اصلی</a>
                </li>
                <li class="active"> لیست علاقه‌مندی ها </li>
            </ul>
        </div>
    </div>
</div>

    <!-- my account wrapper start -->
<div class="my-account-wrapper pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row text-right" style="direction: rtl;">
                        <div class="col-lg-3 col-md-4">
                            @include('home.sections.profile.sidebar')
                        </div>
                        <!-- My Account Tab Menu End -->

                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">

                                <div class="myaccount-content">
                                    <h3> لیست علاقه مندی ها </h3>
                                    @if($wishlist->count() === 0)
                                        <div class="alert alert-danger text-center">
                                             لیست علاقه‌مندی های شما خالی است
                                        </div>
                                    @else
                                        <div class="table-content table-responsive cart-table-content">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th> تصویر محصول </th>
                                                        <th> نام محصول </th>
                                                        <th> حذف </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($wishlist as $wish)
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <a href="{{ route('home.products.show', $wish->product->slug) }}">
                                                                    <img width="90px" src="{{ asset($wish->product->primary_image) }}" alt="{{ $wish->product->name }}">
                                                                </a>
                                                            </td>
                                                            <td class="product-name">
                                                                <a href="{{ route('home.products.show', $wish->product->slug) }}"> {{ $wish->product->name }}</a>
                                                            </td>
                                                            <td class="product-name">
                                                                <a href="#" class="delete-button" data-id="{{ $wish->product->id }}">
                                                                    <i class="sli sli-trash" style="font-size: 20px"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div> <!-- My Account Page End -->
            </div>
        </div>
    </div>
</div>
    <!-- my account wrapper end -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.dataset.id;

                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'بله، حذف کن',
                        cancelButtonText: 'لغو'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit it to delete the wish
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('home.profile.wishlist.remove', ['product' => ':id']) }}".replace(':id', productId);
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