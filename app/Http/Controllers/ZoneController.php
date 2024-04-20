<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::withTrashed()->paginate(20);
        return Inertia::render('Admin/Zone/Index', ['zones' => $zones]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function saveTables(Request $request, Zone $zone)
    {

        $zone->load('tables');
        $i = 0;
        foreach ($zone->tables as $table) {
            $table->update([
                'x' => $request->positions[$i]['left'],
                'y' => $request->positions[$i]['top'],
                'width' => $request->width[$i]['width'],
                'height' => $request->height[$i]['height'],
                'round' => $request->round[$i]['round'],
                'textcolor' => $request->textcolor[$i]['textcolor'],
                'tablecolor' => $request->tablecolor[$i]['tablecolor'],
            ]);
            $i++;
        }
        return redirect()->route('admin.zone.index')->with('success', 'تم حفظ التشكيلة بنجاح');
    }

    public function create()
    {
        return Inertia::render('Admin/Zone/Create');
    }

    public function restore(Zone $zone)
    {
        $zone->restore();
        return redirect()->route('admin.zone.index')->with('success', 'تم إعادة المنطقة بنجاح');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'nullable|gte:0'
        ]);
        Zone::create([
            'name' => $request->name,
            'position' => $request->position ?? 0
        ]);
        return redirect()->route('admin.zone.index')->with('success', 'تم اضافة المنطقة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        $zone->load('tables');
        return Inertia::render('Admin/Zone/Show', ['zone' => $zone]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        return Inertia::render('Admin/Zone/Edit', ['zone' => $zone]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'nullable|gte:0'
        ]);
        $zone->update([
            'name' => $request->name,
            'position' => $request->position ?? 0
        ]);
        return redirect()->route('admin.zone.index')->with('success', 'تم تعديل المنطقة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('admin.zone.index')->with('success', 'تم مسح المنطقة بنجاح');
    }
}
