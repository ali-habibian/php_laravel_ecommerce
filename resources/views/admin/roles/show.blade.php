@extends('admin.layouts.admin-layout')

@section('title', 'نمایش نقش')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <!-- Topbar -->
            <div class="mb-4">
                <h5 class="font-weight-bold">نقش: {{ $role->display_name }}</h5>
            </div>
            <!-- End Topbar -->

            <hr>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="name">نام</label>
                    <input class="form-control" disabled type="text" value="{{ $role->name }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="name">نام نمایشی</label>
                    <input class="form-control" disabled type="text" value="{{ $role->display_name }}">
                </div>

                <div class="form-group col-12">
                    <div class="form-row">
                        <div class="accordion col-md-12 mt-3" id="accordionPermissions">
                          <div class="card">
                            <div class="card-header p-1" id="headingPermission">
                              <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-right"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#collapsePermission"
                                        aria-expanded="true"
                                        aria-controls="collapsePermission">
                                  مجوز‌های دسترسی
                                </button>
                              </h2>
                            </div>

                            <div id="collapsePermission"
                                 class="collapse show"
                                 aria-labelledby="headingPermission"
                                 data-parent="#accordionPermissions">
                              <div class="card-body row">
                                @foreach($role->permissions as $permission)
                                      <div class="form-group form-check col-md-3">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="permission_{{ $permission->id }}"
                                               disabled
                                               checked>
                                        <label class="form-check-label mr-3"
                                               for="permission_{{ $permission->id }}">{{ $permission->display_name }}</label>
                                      </div>
                                  @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

            </div>

            <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5">بازگشت</a>
        </div>
    </div>
@endsection
