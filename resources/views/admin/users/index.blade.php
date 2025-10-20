@extends('admin.layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>👥 Quản lý người dùng</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm người dùng
        </a>
    </div>

    @if($users->isEmpty())
        <div class="alert alert-info">Hiện chưa có người dùng nào.</div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Ngày tạo</th>
                                <th>Số đơn hàng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                @if($user->email_verified_at)
                                                    <small class="text-success">
                                                        <i class="bi bi-check-circle"></i> Đã xác thực
                                                    </small>
                                                @else
                                                    <small class="text-warning">
                                                        <i class="bi bi-exclamation-circle"></i> Chưa xác thực
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->is_admin)
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-check"></i> Admin
                                            </span>
                                        @else
                                            <span class="badge bg-primary">
                                                <i class="bi bi-person"></i> Khách hàng
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $user->orders_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="Xem chi tiết">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Chỉnh sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Xóa">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
