<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryData;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryDataController extends Controller
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
    public function restore(CategoryData $categoryData)
    {
        $category = Category::find($categoryData->category_id);
        $item = Item::getItemsByBarcode([$categoryData->barcode])->first();
        $categoryData->restore();
        $maxKeyId = DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->max('key_id');
        $newKeyId = intval($maxKeyId) + 1;
        DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->insert([
            'pos_id' => 0,
            'group_id' => $category->group_id,
            'key_id' => $newKeyId,
            'barcode' => ltrim(rtrim($categoryData->barcode)),
            'a_name' => $item->a_name,
            'l_name' => $category->name,
            'last_modified_time' => now()
        ]);
        return redirect()->back()->with('success', 'تم استعادة المنتج بنجاح');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id' => 'required',
            'barcode' => 'required',
            'position' => 'required|gte:0'
        ]);

        try {
            $category = Category::find($request->id);
            $item = Item::getItemsByBarcode([$request->barcode])->first();
            $maxKeyId = DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->max('key_id');
            $newKeyId = intval($maxKeyId) + 1;
            CategoryData::create([
                'position' => $request->position,
                'barcode' => ltrim(rtrim($request->barcode)),
                'category_id' => $request->id,
                'key_id' => $newKeyId,
            ]);

            DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->insert([
                'pos_id' => 0,
                'group_id' => $category->group_id,
                'key_id' => $newKeyId,
                'barcode' => ltrim(rtrim($request->barcode)),
                'a_name' => $item->a_name,
                'l_name' => $category->name,
                'last_modified_time' => now()
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('admin.category.show', $request->id)->with('error', 'الباركود مكرر');
        }


        return redirect()->route('admin.category.show', $request->id)->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryData $categoryData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryData $categoryData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $request->validate([
            'position' => 'required|gte:0',
        ]);
        $categoryData = CategoryData::findOrFail($id);
        $categoryData->update([
            'position' => $request->position
        ]);
        return redirect()->back()->with('success', 'تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $categoryData = CategoryData::findOrFail($id);
        DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->where('key_id',$categoryData->key_id)->delete();
        $categoryData->delete();
        return redirect()->back()->with('success', 'تم مسح المنتج بنجاح');
    }
}
