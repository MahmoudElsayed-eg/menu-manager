<?php

namespace App\Http\Controllers;

use App\Events\tableDataChanged;
use App\Events\TableStatusChanged;
use App\Models\Category;
use App\Models\CategoryData;
use App\Models\Item;
use App\Models\ItemPic;
use App\Models\Order;
use App\Models\Service;
use App\Models\Table;
use App\Models\TableData;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::withTrashed()->with('zone')->paginate(20);
        return Inertia::render('Admin/Table/Index', ['tables' => $tables]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all(['id', 'name']);
        return Inertia::render('Admin/Table/Create', ['zones' => $zones]);
    }

    public function restore(Table $table)
    {
        $table->restore();
        return redirect()->route('admin.table.index')->with('success', 'تم استعادة الطاولة بنجاح');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'zone_id' => 'required|gt:0',
            'numChairs' => 'nullable|gte:0',
        ]);
        Table::create([
            'name' => $request->name,
            'zone_id' => $request->zone_id,
            'numChairs' => $request->numChairs ?? 0,
        ]);
        return redirect()->back()->with('success', 'تم اضافة الطاولة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        $tableData = TableData::where('table_id', $table->id)->get();
        $arr = [];
        foreach ($tableData as $data) {
            array_push($arr, $data->barcode);
        }
        $tableData->load('pics');
        $retail_data = [];
        if (count($arr) != 0) {
            $retail_data = Item::getItemsByBarcode($arr)->get();
        }
        $mostSelled = DB::connection('sqlsrv2')->select("select top 10 sum (qty), barcode , Reserved1
        from sal_invoices_items WHERE barcode not LIKE '%00000%'
        group by  barcode , Reserved1 
        order by sum (qty) desc");
        $arr = [];
        foreach ($mostSelled as $item) {
            array_push($arr, trim($item->barcode));
        }
        $zones = Zone::orderBy('position', 'asc')->get();
        $zones->load('tables');
        $mostOrdered = Item::getItemsByBarcode($arr)->get();
        $services = Service::all();
        return Inertia::render('Table/Show', ['table' => $table, 'zones' => $zones, 'tableData' => $tableData, 'retail_data' => $retail_data, 'mostOrdered' => $mostOrdered, 'services' => $services]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        $zones = Zone::all(['id', 'name']);
        return Inertia::render('Admin/Table/Edit', ['zones' => $zones, 'table' => $table]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {

        $request->validate([
            'name' => 'required|string',
            'zone_id' => 'required|gt:0',
            'numChairs' => 'nullable|gte:0',
        ]);
        $table->update([
            'name' => $request->name,
            'zone_id' => $request->zone_id,
            'numChairs' => $request->numChairs ?? 0,
        ]);
        return redirect()->back()->with('success', 'تم تعديل الطاولة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->back()->with('success', 'تم مسح الطاولة بنجاح');
    }

    public function selectItem(Table $table)
    {

        $categories = Category::all();

        return Inertia::render('Table/SelectItem', ['categories' => $categories, 'table' => $table]);
    }
    public function selectCategory(Table $table, Category $category)
    {
        // $category->load('categoryData.retail_data');
        $data = CategoryData::with('pics')->where('category_id', $category->id)->orderBy('position')->get();
        $arr = [];
        foreach ($data as $item) {
            array_push($arr, $item->barcode);
        }

        $retail_data = Item::getItemsByBarcode($arr)->get();


        // dd($table,$category);

        return Inertia::render('Table/SelectItemCategory', ['data' => $data, 'retail_data' => $retail_data, 'table' => $table]);
    }


    public function changeStatus(Request $request, Table $table) {
        $table->update([
            'status' => $request->status,
        ]);
        event(new TableStatusChanged());
        event(new tableDataChanged($table));
        return response()->json(['table' => $table]);
    }

    public function updatePersons(Request $request, Table $table) {
        $table->update([
            'numPersons' => $request->numPersons,
        ]);
        event(new tableDataChanged($table));
    
        return response()->json(['table' => $table]);
    }

    public function finish(Request $request, Table $table) {
        // dd($request->user());
        $totalPrice = 0;
        foreach ($request->data as $data) {
            $totalPrice += $data["price"] - $data['discount'];
        }
        Order::create([
            'table_id' => $table->id,
            'order' => json_encode($request->data, JSON_UNESCAPED_UNICODE),
            'total_price' => $totalPrice,
        ]);
        $table->data()->delete();
        $table->update([
            'numPersons' => 0,
        ]);
        event(new tableDataChanged($table));
        return response()->json(['table' => $table]);
    }

    public function move(Request $request, Table $table) {
        // $table->data()->update([
        //     'table_id' => $request->to
        // ]);
        $table->load('data');
        $toTable = Table::find($request->to);
        $toTable->load('data');
        foreach ($table->data as $moved) {
            foreach ($toTable->data as $data) {
    
                if ($data->barcode == $moved->barcode && $moved->printed == $data->printed) {
                    $data->update([
                        'amount' => $data->amount + $moved->amount,
                    ]);
                    $moved->delete();
                    break;
                }
            }
            $moved->update([
                'table_id' => $request->to,
            ]);
        }
    
        $toTable->update([
            'numPersons' => $toTable->numPersons + $table->numPersons
        ]);
        $table->update([
            'numPersons' => 0,
            'status' => 'فارغ'
        ]);
        event(new tableDataChanged($table));
        event(new tableDataChanged($toTable));
        return response()->json(['table' => $table]);
    }

    public function print(Request $request, Table $table) {
        $arr = [];
        $print_arr = [];
        // make pdfs and save them and print them
        // dd(array_values($request->data));
        $table->load('data');
        for ($i = 0; $i < count($table->data); $i++) {
            $item = $table->data[$i];
            if ($item->printed) {
                continue;
            }
            $print_group = $item->print_group();
            $tableData = $request->data[$i];
            if (!in_array($print_group, $print_arr)) {
                array_push($print_arr, $print_group);
                array_push($arr, [
                    'group' => mb_substr($print_group, 0, 20, 'UTF-8'),
                    'tableName' => mb_substr($table->name, 0, 10, 'UTF-8'),
                    'data' => [(object)[
                        'amount' => $item->amount,
                        'name' => mb_substr($tableData['name'], 0, 20, 'UTF-8'),
                    ]],
                    'date' => date('d/m/Y h:m:s a'),
                ]);
            } else {
    
                array_push($arr[array_search($print_group, $print_arr)]['data'], (object)[
                    'amount' => $item->amount,
                    'name' => mb_substr($tableData['name'], 0, 20, 'UTF-8'),
                ]);
            }
            $item->update([
                'printed'=>true,
            ]);
        }
        $j = 0;
        $x = '';
        foreach ($arr as $data) {
            $height = 10 + 11 + (count($data) * 5.5);
            $pdf = PDF::loadView(
                'pdf',
                $data,
                [],
                [
                    'mode' => 'utf-8',
                    'format' => [72, $height],
                    'orientation' => 'P',
                    'margin_left' => 0,
                    'margin_right' => 0,
                    'margin_top' => 0,
                    'margin_bottom' => 0,
                    'margin_header' => 0,
                    'margin_footer' => 0,
                ]
            );
            $pdf->save($j . '.pdf');
            // dd(realpath(dirname(__DIR__))."\public\\$j.pdf");
            $x = realpath(dirname(dirname(dirname(__DIR__)))) . "\public\PDFtoPrinter.exe " . realpath(dirname(dirname(dirname(__DIR__)))) . "\public\\$j.pdf";
            DB::statement("RunCmdLine '$x'");
            // exec(realpath(dirname(__DIR__))."\public\PDFtoPrinter.exe ".realpath(dirname(__DIR__))."\public\\$j.pdf");
            $j++;
        }
        
        for ($i = 0; $i < count($table->data); $i++) {
            $item = $table->data[$i];
            for ($j = $i+1; $j < count($table->data); $j++) {
                if ($item['barcode'] == $table->data[$j]['barcode'] && $item['printed'] == $table->data[$j]['printed']) {
                    $item->update([
                        'amount' => $item['amount'] + $table->data[$j]['amount']
                    ]);
                    $table->data[$j]->delete();
                    break;
                }
            }
        }
    
        event(new tableDataChanged($table));
        return response()->json(['arr' => $x]);
    }
}
