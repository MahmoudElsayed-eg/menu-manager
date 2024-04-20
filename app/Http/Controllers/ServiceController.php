<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Service/Index', ['services' => Service::withTrashed()->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Service/Create');
    }

    public function restore(Service $service)
    {
        $service->restore();
        return redirect()->back()->with('success', 'تم استعادة الخدمة بنجاح');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'percent' => 'required|gte:0|lte:100',
            'mainBarcode' => [
                'required',
                "regex:'^\d\d\d\d\d\d\d00000\d$'",
            ],
            'mainBarcodeSellprice' => 'required|numeric',
            'item' => 'required',
        ]);
        Service::create($data);
        return redirect()->route('admin.service.index')->with('success', 'تم اضافة الخدمة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $item = Item::where('barcode', $service->mainBarcode)->first();
        return Inertia::render('Admin/Service/Edit', ['service' => $service, 'item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'percent' => 'required|gte:0|lte:100',
            'mainBarcode' => [
                'required',
                "regex:'^\d\d\d\d\d\d\d00000\d$'",
            ],
            'mainBarcodeSellprice' => 'required|numeric',
            'item' => 'required',
        ]);
        $service->update($data);
        return redirect()->route('admin.service.index')->with('success', 'تم تعديل الخدمة بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->back()->with('success', 'تم مسح الخدمة بنجاح');
    }
}
