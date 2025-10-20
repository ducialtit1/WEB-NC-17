@extends('admin.layouts.admin')

@section('content')
<h2>Danh sách người dùng</h2>

<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Thêm người dùng mới</a>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->is_admin)
                    <span class="badge bg-success">Admin</span>
                @else
                    <span class="badge bg-secondary">User</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xoá người dùng này không?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>
@endsection
