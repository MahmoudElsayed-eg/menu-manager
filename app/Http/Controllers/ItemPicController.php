<?php

namespace App\Http\Controllers;

use App\Models\ItemPic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemPicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'images.*' => 'image|max:5120',
            'images' => 'required',
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store("images/items/$request->id", 'public');
                ItemPic::create([
                    'pic' => $path,
                    'barcode' => $request->barcode,
                    'category_data_id' => $request->id,
                ]);
            }
        }
        return redirect()->back()->with('success', 'تم حفظ الصور بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemPic $itemPic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemPic $itemPic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPic $itemPic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $itemPic = ItemPic::findOrFail($id);
        Storage::disk('public')->delete($itemPic->pic);
        $itemPic->delete();
        return redirect()->back()->with('success', 'تم مسح الصورة بنجاح');
    }


    public function search(String $barcode) {
        $images = ItemPic::where('barcode', $barcode)->get();
        return response()->json(['images' => $images]);
    }
}
