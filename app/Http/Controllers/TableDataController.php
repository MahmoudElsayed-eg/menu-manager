<?php

namespace App\Http\Controllers;

use App\Events\tableDataChanged;
use App\Events\TableStatusChanged;
use App\Models\Item;
use App\Models\Report;
use App\Models\Table;
use App\Models\TableData;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class TableDataController extends Controller
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
        $data = $request->validate([
            'amount' => 'required|gte:0',
            'barcode' => 'required|string',
            'table_id' => 'required|gt:0'
        ]);
        $tableData = TableData::where('barcode', $request->barcode)->where('table_id', $request->table_id)->first();

        if ($tableData && $tableData->printed != '1') {
            $tableData->update([
                'amount' => $tableData->amount + $request->amount,
            ]);
        } else {

            $tableData = TableData::create($data);
        }
        $table = Table::find($request->table_id);
        $table->update([
            'status' => 'مشغول',
        ]);
        event(new tableDataChanged($table));
        event(new TableStatusChanged());
        if ($request->expectsJson()) {
            # code...
            return response()->json(['tableData' => $tableData]);
        }
        return redirect()->route('table.show', $request->table_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(TableData $tableData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TableData $tableData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'amount' => 'required|gte:0'
        ]);
        $tableData = TableData::find($id);
        $user = $request->user();
        if ($tableData->printed == '1' && $user->is_manager != '1' && $user->is_admin != '1') {
            return response('', 204);
        }
        $table = Table::find($tableData->table_id);
        if ($tableData->printed == '1') {
            $item = Item::where('barcode', $tableData->barcode)->first();
            Report::create([
                'username' => $user->name,
                'report' => 'تم تعديل الصنف ' . $item->a_name . ' بعد الطباعة من الطاولة ' . $table->name,
            ]);
        }
        $tableData->update([
            'amount' => $request->amount,
        ]);
        event(new tableDataChanged($table));
        return response()->json(['tableData' => $tableData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $user = $request->user();
        $tableData = TableData::find($id);
        if ($tableData->printed == '1' && $user->is_manager != '1' && $user->is_admin != '1') {
            return response('', 204);
        }
        $table = Table::find($tableData->table_id);
        if ($tableData->printed == '1') {
            $item = Item::where('barcode', $tableData->barcode)->first();
            Report::create([
                'username' => $user->name,
                'report' => 'تم مسح الصنف ' . $item->a_name . ' بعد الطباعة من الطاولة ' . $table->name,
            ]);
        }
        $tableData->delete();
        $table->load('data');
        if (count($table->data) == 0) {
            $table->update([
                'status' => 'فارغ'
            ]);
            event(new TableStatusChanged());
        }
        event(new tableDataChanged($table));
        return response()->json([]);
    }
}
