<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo mới
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu người dùng mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'boolean'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'is_admin' => 'boolean'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $user->password,
            'is_admin' => $request->boolean('is_admin'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật.');
    }

    /**
     * Xóa người dùng
     */
    public function destroy(User $user)
{
    // Nếu user có đơn hàng thì không cho xóa
    if ($user->orders()->count() > 0) {
        return redirect()
            ->route('admin.users.index')
            ->with('error', 'Không thể xóa người dùng vì họ vẫn còn đơn hàng liên kết.');
    }

    // Nếu không có đơn hàng thì xóa bình thường
    $user->delete();

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Người dùng đã được xóa.');
}


    /**
     * Hiển thị chi tiết người dùng (tùy chọn)
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
