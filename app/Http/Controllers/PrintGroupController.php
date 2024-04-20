<?php

namespace App\Http\Controllers;

use App\Models\PrintGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrintGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = PrintGroup::with('categories')->withTrashed()->paginate(20);
        return Inertia::render('Admin/Group/Index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Group/Create');
    }

    public function restore(String $id)
    {
        $group = PrintGroup::withTrashed()->findOrFail($id);
        $group->restore();
        return redirect()->route('admin.print_group.index')->with('success', 'تم استعادة المجموعة بنجاح');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
        ]);
        PrintGroup::create($data);
        return redirect()->route('admin.print_group.index')->with('success', 'تم انشاء المجموعة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrintGroup $printGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrintGroup $printGroup)
    {
        return Inertia::render('Admin/Group/Edit', ['group' => $printGroup]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrintGroup $printGroup)
    {
        $request->validate([
            'name' => 'string|required',
        ]);
        $printGroup->update([
            'name' => $request->name,
        ]);
        return redirect()->route('admin.print_group.index')->with('success', 'تم تعديل المجموعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrintGroup $printGroup)
    {
        $printGroup->load('categories');
        if (count($printGroup->categories) == 0) {
            # code...
            $printGroup->delete();
            return redirect()->route('admin.print_group.index')->with('success', 'تم مسح المجموعة بنجاح');
        }
        return redirect()->route('admin.print_group.index')->with('error', 'لا يمكن مسح المجموعة');
    }
}
