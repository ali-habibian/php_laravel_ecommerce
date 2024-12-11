@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش محصول')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش محصول</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text"
                               value="{{ old('name', $product->name) }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="brandSelect">برند</label>
                        <select class="form-control selectpicker" id="brandSelect" name="brand_id"
                                data-live-search="true" title="انتخاب برند">
                            @foreach($brands as $brand)
                                <option
                                    value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="is_active">وضعیت</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1" @selected(old('is_active', $product->getRawOriginal('is_active')))>فعال
                            </option>
                            <option value="0" @selected(!old('is_active', $product->getRawOriginal('is_active')))>غیر
                                فعال
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="tagSelect">تگ ها</label>
                        <select class="form-control selectpicker" id="tagSelect" name="tag_ids[]"
                                multiple data-live-search="true" title="انتخاب تگ ها">
                            @foreach($tags as $tag)
                                <option
                                    value="{{ $tag->id }}" @selected(in_array($tag->id, old('tag_ids', $productTagIds)))>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" rows="3"
                                  name="description">{{ old('description', $product->description) }}</textarea>
                    </div>

                    {{-- Attributes & Variations section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>ویژگی ها:</p>
                    </div>

                    @foreach($productAttributes as $productAttribute)
                        <div class="form-group col-md-3">
                            <label>{{ $productAttribute->attribute->name }}</label>
                            <input class="form-control" name="attribute_values[{{ $productAttribute->id }}]" type="text"
                                   value="{{ $productAttribute->value }}">
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
                                            data-target="#collapse-{{ $variation->id }}"
                                            onclick="toggleButtonText(this)">
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
                                            <input type="text" class="form-control"
                                                   value="{{ $variation->price }}"
                                                   name="variation_values[{{ $variation->id }}][price]">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تعداد </label>
                                            <input type="text" class="form-control"
                                                   value="{{ $variation->quantity }}"
                                                   name="variation_values[{{ $variation->id }}][quantity]">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> sku </label>
                                            <input type="text" class="form-control" value="{{ $variation->sku }}"
                                                   name="variation_values[{{ $variation->id }}][sku]">
                                        </div>

                                        {{-- Sale Section --}}
                                        <div class="col-md-12">
                                            <p> حراج: </p>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> قیمت حراجی </label>
                                            <input type="text" value="{{ $variation->sale_price }}"
                                                   name="variation_values[{{ $variation->id }}][sale_price]"
                                                   class="form-control">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تاریخ شروع حراجی </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend order-2">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input data-jdp type="text"
                                                       value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}"
                                                       name="variation_values[{{ $variation->id }}][date_on_sale_from]"
                                                       class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label> تاریخ پایان حراجی </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend order-2">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                </div>
                                                <input data-jdp type="text"
                                                       value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}"
                                                       name="variation_values[{{ $variation->id }}][date_on_sale_to]"
                                                       class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Delivery Cost section --}}
                    <div class="col-md-12">
                        <hr>
                        <p>هزینه ارسال:</p>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount">هزینه ارسال</label>
                        <input class="form-control" id="delivery_amount" name="delivery_amount" type="text"
                               value="{{ old('delivery_amount', $product->delivery_amount) }}"
                               autofocus>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="delivery_amount_per_product">هزینه ارسال به ازای هر محصول اضافی</label>
                        <input class="form-control" id="delivery_amount_per_product" name="delivery_amount_per_product"
                               type="text"
                               value="{{ old('delivery_amount_per_product', $product->delivery_amount_per_product) }}"
                               autofocus>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">ثبت</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        $('#selectpicker').selectpicker();

        $(document).on('click', '.add-row', function () {
            const $clone = $('.repeater:first').clone();
            $clone.find('input').val('');
            $('.form-container').append($clone);
        });

        $(document).on('click', '.remove-row', function () {
            if ($('.repeater').length > 1) {
                $(this).closest('.repeater').remove();
            }
        });

        jalaliDatepicker.startWatch({
            'persianDigits': true
        });
    </script>
@endpush
