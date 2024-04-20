<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Meal;
use App\Models\PrintGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Category/Index', ['categories' => Category::withTrashed()->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = PrintGroup::all();
        return Inertia::render('Admin/Category/Create', ['groups' => $groups]);
    }


    public function restore(Category $category)
    {
        $maxGroupId = DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->max('group_id');
        $newGroupId = intval($maxGroupId) + 1;
        DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->insert([
            'pos_id' => 0,
            'group_id' => $newGroupId,
            'a_name' => LTRIM(RTRIM($category->name)),
            'l_name' => null,
            'last_modified_time' => now(),
        ]);

        $category->restore();
        $category->update([
            'group_id' => $newGroupId,
        ]);
        DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->where('l_name', $category->name)->update([
            'group_id' => $newGroupId,
        ]);
        return redirect()->route('admin.category.index')->with('success', 'تم استعادة الصنف بنجاح');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'position' => 'nullable|gte:0',
            'pic' => 'nullable|image|max:5120',
            'print_group_id' => 'required|gt:0'
        ]);
        // ->select('SELECT count(*) FROM pos_quick_itemgroups WHERE a_name =  LTRIM(RTRIM(?))', [$request->name]);

        if (
            DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->where('a_name', LTRIM(RTRIM($request->name)))->exists()
        ) {
            throw ValidationException::withMessages([
                'name' => 'الاسم موجود من قبل',
            ]);
        }

        $maxGroupId = DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->max('group_id');
        $newGroupId = intval($maxGroupId) + 1;

        DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->insert([
            'pos_id' => 0,
            'group_id' => $newGroupId,
            'a_name' => LTRIM(RTRIM($request->name)),
            'l_name' => null,
            'last_modified_time' => now(),
        ]);


        # code...
        $category = Category::create([
            'name' => LTRIM(RTRIM($request->name)),
            'position' => $request->position ?? 0,
            'pic' => null,
            'group_id' => $newGroupId,
            'print_group_id' => $request->print_group_id,
        ]);
        if ($request->hasFile('pic')) {

            // $path = "images\category\\$category->id\\";
            // $name = time() . $request->file('pic')->getBasename() . '.webp';
            // $path = $path . $name;

            // Storage::put("public\images\category\\$category->id\\" . $name, $request->file('pic'));
            $path = $request->file('pic')->store("images/category/$category->id", 'public');
            $category->update([
                'pic' => $path,
            ]);
        }
        return redirect()->route('admin.category.index')->with('success', 'تم إضافة الصنف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if ($category->deleted_at) {
            abort(404);
        }
        // if ($category->deleted == true) {
        //     return redirect()->route('home');
        // }
        // $category->load('meals.sizes.promotion');
        // $meals = $category->meals()->paginate(10);
        // $meals->load(['sizes.promotion', 'promotion']);
        // $minus_black = asset("storage/images/minus_black.svg");
        // $minus_white = asset("storage/images/minus_white.svg");
        // $plus_black = asset('storage/images/plus_black.svg');
        // $plus_white = asset('storage/images/plus_white.svg');
        // $offer = asset('storage/images/offer.webp');
        // return Inertia::render('Category/Show', [
        //     'category' => $category,
        //     'meals' => $meals,
        //     'minus_black' => $minus_black,
        //     'minus_white' => $minus_white,
        //     'plus_black' => $plus_black,
        //     'plus_white' => $plus_white,
        //     'offer' => $offer
        // ]);
        // $category->load('categoryData');
        $data = $category->categoryData()->withTrashed()->get();
        // dd($data);
        $arr = [];
        foreach ($data as $a) {
            array_push($arr, $a['barcode']);
        }

        $data = $category->categoryData()->withTrashed()->with('pics')->paginate(20);
        $items = Item::getItemsByBarcode($arr)->get(['barcode', 'a_name', 'sell_price']);

        // dd($items);
        return Inertia::render('Admin/Category/Show', ['category' => $category, 'items' => $items, 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $groups = PrintGroup::all();
        return Inertia::render('Admin/Category/Edit', ['category' => $category, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if ($category->deleted_at) {
            abort(404);
        }
        $request->validate([
            'name' => 'required|string',
            'position' => 'nullable|gte:0',
            'pic' => 'nullable|image|max:5120',
        ]);
        if ($request->hasFile('pic')) {
            if ($category->pic) {
                Storage::disk('public')->delete($category->pic);
            }
            $path = $request->file('pic')->store("images/category/$category->id", 'public');
            try {
                //code...
                if (LTRIM(RTRIM($request->name)) != $category->name) {

                    DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->where('group_id', $category->group_id)->update([
                        'a_name' => LTRIM(RTRIM($request->name)),
                        'last_modified_time' => now(),
                    ]);
                    DB::connection('sqlsrv2')->table('pos_quick_itemkeys')->where('group_id', $category->group_id)->update([
                        'l_name' => LTRIM(RTRIM($request->name)),
                    ]);
                }
                $category->update([
                    'name' => LTRIM(RTRIM($request->name)),
                    'position' => $request->position ?? 0,
                    'pic' => $path,
                ]);
            } catch (\Throwable $th) {
                //throw $th;

                throw ValidationException::withMessages([
                    'name' =>  'الاسم موجود من قبل',
                ]);
            }
        } else {

            try {
                //code...
                if (LTRIM(RTRIM($request->name)) != $category->name) {

                    DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->where('group_id', $category->group_id)->update([
                        'a_name' => LTRIM(RTRIM($request->name)),
                        'last_modified_time' => now(),
                    ]);
                }
                $category->update([
                    'name' => LTRIM(RTRIM($request->name)),
                    'position' => $request->position ?? 0,
                ]);
            } catch (\Throwable $th) {
                //throw $th;

                throw ValidationException::withMessages([
                    'name' =>  'الاسم موجود من قبل',
                ]);
            }
        }
        return redirect()->route('admin.category.index')->with('success', 'تم تعديل الصنف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // if ($category->pic) {
        //     Storage::disk('public')->delete($category->pic);
        // }
        // $category->load('categoryData.pics');
        // foreach ($category->categoryData as $data) {
        //     foreach ($data->pics as $pic) {
        //         Storage::disk('public')->delete($pic->pic);
        //         $pic->delete();
        //     }
        //     $data->delete();
        // }
        DB::connection('sqlsrv2')->table('pos_quick_itemgroups')->where('group_id', $category->group_id)->delete();
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'تم مسح الصنف بنجاح');
    }

    public function searchBarcode(String $barcode) {
        $item = null;
        if ($barcode) {
            $item = Item::where('barcode', $barcode)->first();
        }
        return response()->json(['item' => $item]);
    }
}
