@extends('admin.layouts.admin-layout')

@section('title', 'لیست برندها')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-md-5 bg-white">

            <!-- Topbar -->
            <div class="d-flex justify-content-between mb-4">
                <h5 class="font-weight-bold">لیست برندها ({{ $brands->total() }})</h5>
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.brands.create') }}">
                    <i class="fa fa-plus"></i>
                    ایجاد برند
                </a>
            </div>

            <table class="table table-bordered table-striped text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>

                <tbody>
                @foreach($brands as $key => $brand)
                    <tr>
                        <td>{{ $brands->firstItem() + $key }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <span class="{{ $brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $brand->is_active }}
                            </span>
                        </td>
                        <td>#</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>
@endsection