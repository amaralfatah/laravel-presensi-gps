@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-between align-items-center">
                    <h1 class="card-title">Daftar User</h1>
                    <button type="button" class="btn btn-primary btn-sm rounded" data-bs-toggle="modal"
                        data-bs-target="#createUserModal">
                        + Tambah
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                @if ($user->id !== 1)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm rounded"
                                                data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $user->id }}">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm rounded"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_hapus_{{ $user->id }}">Hapus</button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Create User Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="createUserForm" action="{{ route('admin.storeUser') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">Please enter a valid name.</div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">Password is required.</div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                                <div class="invalid-feedback">Passwords do not match.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($users as $user)
            <!-- Edit User Modal -->
            <div class="modal fade" id="modal_edit_{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editUserForm" action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name"
                                        value="{{ $user->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email"
                                        value="{{ $user->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="edit_password" class="form-label">Password (Leave empty to keep
                                        current)</label>
                                    <input type="password" class="form-control" id="edit_password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="edit_password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="edit_password_confirmation"
                                        name="password_confirmation">
                                    <div class="invalid-feedback">Passwords do not match.</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="modal_hapus_{{ $user->id }}" tabindex="-1"
                aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteUserModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @section('scripts')
        <script>
            function validatePasswordConfirmation(passwordFieldId, confirmationFieldId) {
                var password = document.getElementById(passwordFieldId).value;
                var passwordConfirmation = document.getElementById(confirmationFieldId).value;

                if (password && password !== passwordConfirmation) {
                    document.getElementById(confirmationFieldId).classList.add('is-invalid');
                    return false;
                } else {
                    document.getElementById(confirmationFieldId).classList.remove('is-invalid');
                    return true;
                }
            }

            document.getElementById('createUserForm').addEventListener('submit', function(event) {
                if (!validatePasswordConfirmation('password', 'password_confirmation')) {
                    event.preventDefault();
                }
            });

            document.querySelectorAll('[id^=editUserForm]').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    var formId = form.getAttribute('id');
                    var passwordFieldId = formId.replace('editUserForm', 'edit_password');
                    var confirmationFieldId = formId.replace('editUserForm', 'edit_password_confirmation');
                    if (!validatePasswordConfirmation(passwordFieldId, confirmationFieldId)) {
                        event.preventDefault();
                    }
                });
            });
        </script>
    @endsection
@endsection
