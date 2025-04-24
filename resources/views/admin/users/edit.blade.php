@extends('admin.layouts.admin-layout')

@section('title', 'ویرایش کاربر')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">

            <div class="mb-4">
                <h5 class="font-weight-bold">ویرایش کاربر: {{ $user->name }}</h5>
            </div>

            <hr>

            @include('admin.sections.errors')
            <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">نام</label>
                        <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="mobile">شماره تلفن همراه</label>
                        <input class="form-control" id="mobile" name="mobile" type="text" value="{{ old('mobile', $user->mobile) }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="role">نقش کاربری</label>
                        <select class="form-control" id="role" name="role">
                            <option value="">-- انتخاب --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    @selected(in_array($role->id, $user->roles->pluck('id')->toArray()))>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
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
                                      مجوز‌های دسترسی اضافی
                                    </button>
                                  </h2>
                                </div>

                                <div id="collapsePermission"
                                     class="collapse"
                                     aria-labelledby="headingPermission"
                                     data-parent="#accordionPermissions">
                                  <div class="card-body row">
                                    @foreach($permissions as $permission)
                                          <div class="form-group form-check col-md-3">
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   id="permission_{{ $permission->id }}"
                                                   name="permissions[]"
                                                   value="{{ $permission->id }}"
                                                    @checked(
                                                        in_array($permission->id, old('permissions', $user->permissions->pluck('id')->toArray()))
                                                    )>
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

                <button class="btn btn-outline-primary mt-5" type="submit">ویرایش</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark mt-5 mr-2">بازگشت</a>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const rolePermissionsMap = @json($roles->mapWithKeys(function($role) {
            return [$role->id => $role->permissions->pluck('id')];
        }));

        document.addEventListener("DOMContentLoaded", function () {
            const roleSelect = document.getElementById('role');
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

            function updatePermissions() {
                const selectedRoleId = roleSelect.value;
                const rolePermissions = rolePermissionsMap[selectedRoleId] || [];

                permissionCheckboxes.forEach(checkbox => {
                    const permissionId = parseInt(checkbox.value);

                    if (rolePermissions.includes(permissionId)) {
                        checkbox.checked = false;
                        checkbox.disabled = true;
                        checkbox.closest('.form-check').classList.add('text-muted');
                    } else {
                        checkbox.disabled = false;
                        checkbox.closest('.form-check').classList.remove('text-muted');
                    }
                });
            }

            // Run on page load and on change
            updatePermissions();
            roleSelect.addEventListener('change', updatePermissions);
        });
    </script>
@endpush

@push('styles')
    <style>
        .text-muted {
            opacity: 0.6;
        }
    </style>
@endpush
