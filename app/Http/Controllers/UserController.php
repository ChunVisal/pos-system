<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        $summaryCards = [
            ['title' => 'Total Users', 'value' => User::count(), 'icon' => 'fa-solid fa-users', 'iconBg' => '#0F6E8C', 'iconColor' => '#0F6E8C', 'trend' => 'up', 'percentage' => '', 'period' => ''],
            ['title' => 'Admins', 'value' => User::where('role', 'admin')->count(), 'icon' => 'fa-solid fa-user-shield', 'iconBg' => '#8B5CF6', 'iconColor' => '#8B5CF6', 'trend' => 'up', 'percentage' => '', 'period' => ''],
            ['title' => 'Cashiers', 'value' => User::where('role', 'cashier')->count(), 'icon' => 'fa-solid fa-cash-register', 'iconBg' => '#10B981', 'iconColor' => '#10B981', 'trend' => 'up', 'percentage' => '', 'period' => ''],
            ['title' => 'Active', 'value' => User::where('status', 'active')->count(), 'icon' => 'fa-solid fa-circle-check', 'iconBg' => '#F59E0B', 'iconColor' => '#D97706', 'trend' => 'up', 'percentage' => '', 'period' => ''],
        ];

        return view('admin.users', compact('users', 'summaryCards'));
    }

    public function store(Request $request)
    {

        Log::info('Store called', $request->all());

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,cashier',
                'status' => 'required|in:active,inactive',
                'employee_id' => 'nullable|unique:users',
                'phone' => 'nullable|string',
                'address' => 'nullable|string',
                'shift' => 'nullable|string',
                'pin' => 'nullable|digits:4',
                'hire_date' => 'nullable|date',
                'salary' => 'nullable|numeric',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed', $e->errors());

            return response()->json(['errors' => $e->errors()], 422);
        }

        $employeeId = null;
        if ($request->role === 'cashier') {
            $lastEmp = User::where('employee_id', 'like', 'EMP-%')
                ->orderBy('employee_id', 'desc')
                ->first();

            $nextNum = $lastEmp
                ? (intval(substr($lastEmp->employee_id, 4)) + 1)
                : 1;

            $employeeId = 'EMP-'.str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
            'employee_id' => $employeeId,
            'phone' => $request->phone,
            'address' => $request->address,
            'shift' => $request->shift,
            'pin' => $request->pin,
            'hire_date' => $request->hire_date,
            'salary' => $request->salary,
        ]);

        return response()->json(['success' => true, 'message' => 'User created']);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:admin,cashier',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'shift' => 'nullable|string',
            'pin' => 'nullable|digits:4',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'name', 'email', 'role', 'status', 'phone',
            'address', 'shift', 'pin', 'hire_date', 'salary',
        ]);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['success' => true, 'message' => 'User updated']); // ← JSON not redirect
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json(['status' => $user->status]); // ← JSON not redirect
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
