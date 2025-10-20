@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Quản lý bình luận</h3>

    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Người bình luận</th>
                <th>Nội dung</th>
                <th>Đánh giá</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comments as $comment)
                <tr>
                    <td>#{{ $comment->id }}</td>
                    <td>{{ $comment->product->name ?? 'Không rõ' }}</td>
                    <td>{{ $comment->commentator_name }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->rating }}/5</td>
                    <td>
                        @if ($comment->is_approved)
                            <span class="badge bg-success">Đã duyệt</span>
                        @elseif ($comment->is_rejected)
                            <span class="badge bg-danger">Đã từ chối</span>
                        @else
                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                        @endif
                    </td>
                    <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        @if (!$comment->is_approved && !$comment->is_rejected)
                            <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <button class="btn btn-sm btn-success">
                                    <i class="bi bi-check-circle"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.comments.reject', $comment->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Không có bình luận nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
