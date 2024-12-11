@extends('admin.layouts.admin-layout')

@section('title', 'نمایش محصول')

@push('styles')
    <style>
        /* Remove underline from the links */
        .tag-link {
            text-decoration: none; /* Remove underline */
        }

        /* Change color on hover */
        .tag-link:hover {
            color: #fff; /* White text color on hover */
            background-color: #17a2b8; /* A slightly darker blue */
        }
    </style>
@endpush

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">محصول: {{ $product->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>نام</label>
                    <input class="form-control" disabled type="text" value="{{ $product->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label>برند</label>
                    <input class="form-control" disabled type="text" value="{{ $product->brand->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label>دسته بندی</label>
                    <input class="form-control" disabled type="text" value="{{ $product->category->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" disabled type="text" value="{{ $product->is_active }}">
                </div>

                <div class="form-group col-md-3">
                    <label>تاریخ ایجاد</label>
                    <input class="form-control" disabled type="text"
                           value="{{ verta($product->created_at)->format('Y-m-d H:i') }}">
                </div>

                <div class="form-group col-md-12">
                    <label>توضیحات</label>
                    <textarea class="form-control" disabled rows="3">{{ $product->description }}</textarea>
                </div>

                <div class="form-group col-md-3">
                    <label for="tags">تگ ها:</label>
                    <div id="tags">
                        @foreach($productTags as $tag)
                            <a href="{{ route('admin.tags.show', $tag) }}" class="badge badge-info mt-2 tag-link">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Delivery cost section --}}
                <div class="col-md-12">
                    <hr>
                    <p>هزینه ارسال:</p>
                </div>

                <div class="form-group col-md-3">
                    <label>هزینه ارسال</label>
                    <input class="form-control" disabled type="text" value="{{ $product->delivery_amount }}">
                </div>

                <div class="form-group col-md-3">
                    <label>هزینه ارسال به ازای هر محصول اضافی</label>
                    <input class="form-control" disabled type="text"
                           value="{{ $product->delivery_amount_per_product }}">
                </div>

                {{-- Attributes & Variations section --}}
                <div class="col-md-12">
                    <hr>
                    <p>ویژگی ها:</p>
                </div>

                @foreach($productAttributes as $productAttribute)
                    <div class="form-group col-md-3">
                        <label>{{ $productAttribute->attribute->name }}</label>
                        <input class="form-control" disabled type="text" value="{{ $productAttribute->value }}">
                    </div>
                @endforeach

                {{-- Variations --}}
                @foreach ($productVariations as $variation)
                    <div class="col-md-12">
                        <hr>
                        <div class="d-flex">
                            <p class="mb-0"> قیمت و موجودی برای متغیر <b>{{ $variation->attribute->name }}</b>
                                ( {{ $variation->value }} ): </p>
                            <p class="mb-0 mr-3">
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{ $variation->id }}" onclick="toggleButtonText(this)">
                                    نمایش
                                </button>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="collapse mt-2" id="collapse-{{ $variation->id }}">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label> قیمت </label>
                                        <input type="text" disabled class="form-control"
                                               value="{{ $variation->price }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تعداد </label>
                                        <input type="text" disabled class="form-control"
                                               value="{{ $variation->quantity }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> sku </label>
                                        <input type="text" disabled class="form-control" value="{{ $variation->sku }}">
                                    </div>

                                    {{-- Sale Section --}}
                                    <div class="col-md-12">
                                        <p> حراج: </p>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> قیمت حراجی </label>
                                        <input type="text" value="{{ $variation->sale_price }}" disabled
                                               class="form-control">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تاریخ شروع حراجی </label>
                                        <input type="text"
                                               value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                               disabled class="form-control">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label> تاریخ پایان حراجی </label>
                                        <input type="text"
                                               value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}"
                                               disabled class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Images section --}}
                <div class="col-md-12">
                    <hr>
                    <p>تصویر اصلی:</p>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <hr>
                    <p>سایر تصاویر:</p>
                </div>

                @foreach($productImages as $productImage)
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($productImage->image) }}"
                                 alt="{{ $product->name }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleButtonText(button) {
            const isCollapsed = button.getAttribute('aria-expanded') === 'true';
            button.textContent = isCollapsed ? 'نمایش' : 'بستن';
        }
    </script>
@endpush
