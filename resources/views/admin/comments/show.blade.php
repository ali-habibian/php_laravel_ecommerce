@extends('admin.layouts.admin-layout')

@section('title', 'نمایش دیدگاه')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">دیدگاه</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">نام کاربر</label>
                    <input class="form-control" disabled type="text" value="{{ $comment->user->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">نام محصول</label>
                    <input class="form-control" disabled type="text" value="{{ $comment->product->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label>وضعیت</label>
                    <input class="form-control" disabled type="text" value="{{ $comment->approved }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">تاریخ ایجاد</label>
                    <input class="form-control" disabled type="text" value="{{ verta($comment->created_at)->format('Y-m-d H:i') }}">
                </div>

                <div class="form-group col-12">
                    <label for="name">متن دیدگاه</label>
                    <textarea class="form-control" disabled type="text" rows="3">{{ $comment->text }}</textarea>
                </div>
            </div>

            <a class="btn mt-5 ml-3 {{ $comment->getRawOriginal('approved') ? 'btn-danger' : 'btn-success' }}"
               href="{{ route('admin.comments.change-approval-status', $comment) }}">{{ $comment->getRawOriginal('approved') ? 'عدم تایید' : 'تایید' }}</a>

            <a href="{{ route('admin.comments.index') }}" class="btn btn-dark mt-5">بازگشت</a>

        </div>
    </div>
@endsection
