<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryDataController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemPicController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaceholderImgController;
use App\Http\Controllers\PrintGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TableDataController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ZoneController;
use App\Models\Item;
use App\Models\Report;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test',function(){
  $report = Report::first();
  return Inertia::render('Test',['date'=>date('Y-m-d h:i a'),'report'=>$report]);
});

Route::get('/', function (Request $request) {
  if ($request->user()) {
    return redirect()->route('home');
  }
  return Inertia::render('Login');
})->name('login');

// Route::get('/test2', function () {
//   $data = array(
//     (object) [
//       'amount' => 3,
//       'name' => mb_substr('سوبر شاورما فراخ كبير', 0, 20, 'utf-8'),
//       'price' => 15,
//       'total' => 3 * 15,
//     ],

//   );
//   $total = 45;
//   $sum = 20;
//   $height = 10 + 11 + 200 + (count($data) * 5.5);
//   $pdf = PDF::loadView(
//     'receipt',
//     [
//       'branch' => 'rose',
//       'tableName' => 'A-1',
//       'cashier' => mb_substr('ahmeddsadsadsdsdsdsddsgsgeds', 0, 20, 'utf-8'),
//       'receiptId' => 0,
//       'date' => date('d/m/Y'),
//       'time' => date('H:m:s'),
//       'data' => $data,
//       'totalPrice' => $total,
//       'taxRate' => 14,
//       'serviceRate' => 12,
//       'delivery' => 20,
//       'sumPay' => $sum,
//     ],
//     [],
//     // [
//     //   'group'=>'مطبخ',
//     //   'tableName' => '1',
//     //   'data' => $data,
//     //   'date' => date('d/m/Y h:m:s a'),
//     // ],
//     // [],
//     [
//       'mode' => 'utf-8',
//       'format' => [72, $height],
//       'orientation' => 'P',
//       'margin_left' => 0,
//       'margin_right' => 0,
//       'margin_top' => 0,
//       'margin_bottom' => 0,
//       'margin_header' => 0,
//       'margin_footer' => 0,
//     ]
//   );
//   return $pdf->download('receipt.pdf');
//   // return Inertia::render('Test');
// });
Route::middleware('auth')->group(function () {
  Route::get('/home', [HomeController::class, 'index'])->name('home');

  Route::resource('table', TableController::class)->only('show');
  // table routes
  Route::put('/table/{table}/numPersons', [TableController::class, 'updatePersons'])->name('table.persons');
  Route::put('/table/{table}/change_status', [TableController::class, 'changeStatus'])->name('table.status');
  Route::get('/table/{table}/SelectItem', [TableController::class, 'selectItem'])->name('table.select_item');
  Route::get('/table/{table}/SelectItem/{category}', [TableController::class, 'selectCategory'])->name('table.select_item.category');
  Route::post('/table/{table}/finish', [TableController::class, 'finish'])->name('table.finish')->middleware('cashier');
  Route::put('/table/{table}/move', [TableController::class, 'move'])->name('table.move');
  Route::post('/table/{table}/print', [TableController::class, 'print'])->name('table.print');

  //
  Route::post('/item/{barcode}/images', [ItemPicController::class, 'search'])->name('item.images');

  Route::resource('tableData', TableDataController::class)->only(['store', 'update', 'destroy']);

  // Route::get('/admin', function (Request $request) {
  //     if ($request->user()) {
  //         return redirect()->route('admin.logo.create');
  //     }
  //     return Inertia::render('Admin/Index');
  // })->name('admin.index');
  // ->middleware('auth')
  Route::resource('orders', OrderController::class)->only(['index']);
});
// Route::get('/', function () {
//     return Inertia::render('Home');
// })->name('home');
Route::resource('auth', AuthController::class)->only(['store', 'index']);





Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

  Route::resource('/zone', ZoneController::class)->withTrashed();
  Route::put('/zone/{zone}/restore', [ZoneController::class, 'restore'])->withTrashed()->name('zone.restore');
  Route::post('/zone/{zone}/saveTables', [ZoneController::class, 'saveTables'])->withTrashed()->name('zone.save');
  Route::resource('/table', TableController::class)->withTrashed()->except(['show']);
  Route::put('/table/{table}/restore', [TableController::class, 'restore'])->withTrashed()->name('table.restore');
  Route::resource('/users', UsersController::class)->withTrashed()->except(['show']);
  Route::put('/users/{user}/restore', [UsersController::class, 'restore'])->withTrashed()->name('users.restore');
  Route::resource('/category', CategoryController::class)->withTrashed();
  Route::put('/category/{category}/restore', [CategoryController::class, 'restore'])->withTrashed()->name('category.restore');
  Route::post('/admin/search/{barcode}', [CategoryController::class, 'searchBarcode'])->name('item.search');
  Route::resource('/categoryData', CategoryDataController::class)->only(['store', 'update', 'destroy'])->withTrashed();
  Route::put('/categoryData/{categoryData}/restore', [CategoryDataController::class, 'restore'])->withTrashed()->name('categoryData.restore');
  Route::resource('/item_images', ItemPicController::class)->only(['store', 'destroy']);
  Route::resource('/placeholder_img', PlaceholderImgController::class)->only(['index', 'store']);
  Route::resource('/print_group', PrintGroupController::class)->withTrashed();
  Route::put('/print_group/{print_group}/restore', [PrintGroupController::class, 'restore'])->withTrashed()->name('print_group.restore');
  Route::resource('/service', ServiceController::class)->withTrashed();
  Route::put('/service/{service}/restore', [ServiceController::class, 'restore'])->withTrashed()->name('service.restore');
  Route::resource('/report', ReportController::class)->only('index');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
