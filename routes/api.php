<?php

use App\Events\tableDataChanged;
use App\Events\TableStatusChanged;
use App\Models\Item;
use App\Models\ItemPic;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/admin/search/{barcode}', function (String $barcode) {
//     $item = null;
//     if ($barcode) {
//         $item = Item::where('barcode', $barcode)->first();
//     }
//     return response()->json(['item' => $item]);
// })->name('admin.item.search');

// Route::post('/item/{barcode}/images', function (String $barcode) {
//     $images = ItemPic::where('barcode', $barcode)->get();
//     return response()->json(['images' => $images]);
// })->name('item.images');

// table api

// Route::put('/table/{table}/change_status', function (Request $request, Table $table) {

//     $table->update([
//         'status' => $request->status,
//     ]);
//     event(new TableStatusChanged());
//     event(new tableDataChanged($table));
//     return response()->json(['table' => $table]);
// })->name('table.status');

// Route::put('/table/{table}/numPersons', function (Request $request, Table $table) {
//     $table->update([
//         'numPersons' => $request->numPersons,
//     ]);
//     event(new tableDataChanged($table));

//     return response()->json(['table' => $table]);
// })->name('table.persons');
// save order instead of deleting 
// Route::post('/table/{table}/finish', function (Request $request, Table $table) {
//     // dd($request->user());
//     $totalPrice = 0;
//     foreach ($request->data as $data) {
//         $totalPrice += $data["price"] - $data['discount'];
//     }
//     Order::create([
//         'table_id' => $table->id,
//         'order' => json_encode($request->data, JSON_UNESCAPED_UNICODE),
//         'total_price' => $totalPrice,
//     ]);
//     $table->data()->delete();
//     $table->update([
//         'numPersons' => 0,
//     ]);
//     event(new tableDataChanged($table));
//     return response()->json(['table' => $table]);
// })->name('table.finish');

// Route::put('/table/{table}/move', function (Request $request, Table $table) {
//     // $table->data()->update([
//     //     'table_id' => $request->to
//     // ]);
//     $table->load('data');
//     $toTable = Table::find($request->to);
//     $toTable->load('data');
//     foreach ($table->data as $moved) {
//         foreach ($toTable->data as $data) {

//             if ($data->barcode == $moved->barcode && $moved->printed == $data->printed) {
//                 $data->update([
//                     'amount' => $data->amount + $moved->amount,
//                 ]);
//                 $moved->delete();
//                 break;
//             }
//         }
//         $moved->update([
//             'table_id' => $request->to,
//         ]);
//     }

//     $toTable->update([
//         'numPersons' => $toTable->numPersons + $table->numPersons
//     ]);
//     $table->update([
//         'numPersons' => 0,
//         'status' => 'فارغ'
//     ]);
//     event(new tableDataChanged($table));
//     event(new tableDataChanged($toTable));
//     return response()->json(['table' => $table]);
// })->name('table.move');


// Route::post('/table/{table}/print', function (Request $request, Table $table) {
//     $arr = [];
//     $print_arr = [];
//     // make pdfs and save them and print them
//     // dd(array_values($request->data));
//     $table->load('data');
//     for ($i = 0; $i < count($table->data); $i++) {
//         $item = $table->data[$i];
//         if ($item->printed) {
//             continue;
//         }
//         $print_group = $item->print_group();
//         $tableData = $request->data[$i];
//         if (!in_array($print_group, $print_arr)) {
//             array_push($print_arr, $print_group);
//             array_push($arr, [
//                 'group' => mb_substr($print_group, 0, 20, 'UTF-8'),
//                 'tableName' => mb_substr($table->name, 0, 10, 'UTF-8'),
//                 'data' => [(object)[
//                     'amount' => $item->amount,
//                     'name' => mb_substr($tableData['name'], 0, 20, 'UTF-8'),
//                 ]],
//                 'date' => date('d/m/Y h:m:s a'),
//             ]);
//         } else {

//             array_push($arr[array_search($print_group, $print_arr)]['data'], (object)[
//                 'amount' => $item->amount,
//                 'name' => mb_substr($tableData['name'], 0, 20, 'UTF-8'),
//             ]);
//         }
//         $item->update([
//             'printed'=>true,
//         ]);
//     }
//     $j = 0;
//     $x = '';
//     foreach ($arr as $data) {
//         $height = 10 + 11 + (count($data) * 5.5);
//         $pdf = PDF::loadView(
//             'pdf',
//             $data,
//             [],
//             [
//                 'mode' => 'utf-8',
//                 'format' => [72, $height],
//                 'orientation' => 'P',
//                 'margin_left' => 0,
//                 'margin_right' => 0,
//                 'margin_top' => 0,
//                 'margin_bottom' => 0,
//                 'margin_header' => 0,
//                 'margin_footer' => 0,
//             ]
//         );
//         $pdf->save($j . '.pdf');
//         // dd(realpath(dirname(__DIR__))."\public\\$j.pdf");
//         $x = realpath(dirname(__DIR__)) . "\public\PDFtoPrinter.exe " . realpath(dirname(__DIR__)) . "\public\\$j.pdf";
//         DB::statement("RunCmdLine '$x'");
//         // exec(realpath(dirname(__DIR__))."\public\PDFtoPrinter.exe ".realpath(dirname(__DIR__))."\public\\$j.pdf");
//         $j++;
//     }
    
//     for ($i = 0; $i < count($table->data); $i++) {
//         $item = $table->data[$i];
//         for ($j = $i+1; $j < count($table->data); $j++) {
//             if ($item['barcode'] == $table->data[$j]['barcode'] && $item['printed'] == $table->data[$j]['printed']) {
//                 $item->update([
//                     'amount' => $item['amount'] + $table->data[$j]['amount']
//                 ]);
//                 $table->data[$j]->delete();
//                 break;
//             }
//         }
//     }

//     event(new tableDataChanged($table));
//     return response()->json(['arr' => $x]);
// })->name('table.print');
