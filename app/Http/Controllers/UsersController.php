<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::withTrashed()->notAdmin()->paginate(20);
        return Inertia::render('Admin/Users/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function restore(User $user)
    {
        if ($user->is_admin == '1') {
            abort('404');
        }
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'تم استعادة المستخدم بنجاح');
    }
    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);
        try {
            User::create([
                'name' => $request->name,
                'password' => $request->password,
                'is_cashier' => $request->is_cashier,
                'is_manager' => $request->is_manager,
            ]);
        } catch (\Throwable $th) {
            throw ValidationException::withMessages([
                'name' => 'الاسم موجود من قبل'
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'تم اضافة المستخدم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->is_admin == '1') {
            abort('404');
        }
        return Inertia::render('Admin/Users/Edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->is_admin == '1') {
            abort('404');
        }
        $request->validate([
            'name' => 'required|string',
            'password' => 'nullable',
        ]);
        if ($request->password) {
            $user->update([
                'name' => $request->name,
                'password' => $request->password,
                'is_cashier' => $request->is_cashier,
                'is_manager' => $request->is_manager,
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'is_cashier' => $request->is_cashier,
                'is_manager' => $request->is_manager,
            ]);
        }
        return redirect()->route('admin.users.index')->with('success', 'تم تعديل المستخدم بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->is_admin == '1') {
            abort('404');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم مسح المستخدم بنجاح');
    }
}
