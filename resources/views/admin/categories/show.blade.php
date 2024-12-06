@extends('admin.layouts.admin-layout')

@section('title', 'نمایش دسته بندی')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">دسته بندی: {{ $category->name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" id="" disabled type="text" value="{{ $category->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">اسلاگ (slug)</label>
                    <input class="form-control" disabled type="text" value="{{ $category->slug }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">والد</label>
                    <input class="form-control" disabled type="text" value="{{ $category->parentName() }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">وضعیت</label>
                    <input
                        class="form-control {{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}"
                        disabled type="text" value="{{ $category->is_active }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">آیکون</label>
                    <input class="form-control" disabled type="text" value="{{ $category->icon }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">تاریخ ایجاد</label>
                    <input class="form-control" disabled type="text" value="{{ verta($category->created_at)->format('Y-m-d H:i') }}">
                </div>

                <div class="form-group col-md-12">
                    <label for="name">توضیحات</label>
                    <input class="form-control" disabled type="text" value="{{ $category->description }}">
                </div>

                <div class="col-md-12">
                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <label>ویژگی ها</label>
                            <div class="form-control div-disabled">
                                @foreach($category->attributeList as $attribute)
                                    {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>ویژگی های قابل فیلتر</label>
                            <div class="form-control div-disabled">
                                @foreach($category->attributeList()->wherePivot('is_filterable', true)->get() as $attribute)
                                    {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>ویژگی های متغیر</label>
                            <div class="form-control div-disabled">
                                @foreach($category->attributeList()->wherePivot('is_variation', true)->get() as $attribute)
                                    {{ $attribute->name }}{{ $loop->last ? '' : '،' }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.categories.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection
