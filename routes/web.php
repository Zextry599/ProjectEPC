<?php

use App\Http\Controllers\AccessManageController;
use App\Http\Controllers\AuthManageController;
use App\Http\Controllers\MemberManageController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\ProfileManageController;
use App\Http\Controllers\ReportManageController;
use App\Http\Controllers\SearchManageController;
use App\Http\Controllers\SupplyManageController;
use App\Http\Controllers\TransactionManageController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\ViewManageController;
use App\Http\Controllers\MitraManageController;
use App\Http\Controllers\FinanceManageController;
use App\Http\Controllers\GudangManageController;
use App\Http\Controllers\StoreManageController;
use App\Http\Controllers\ERP\SupplierManageController;
use App\Http\Controllers\ERP\ErpProductManageController;
use App\Http\Controllers\ERP\PurchaseOrderController;
use App\Http\Controllers\ERP\ProductionManageController;
use App\Http\Controllers\ERP\MasterProductManageController;


use Illuminate\Support\Facades\Route;


Route::get('/', function () {
	return view('welcome');
});
Route::get('/login', [AuthManageController::class, 'viewLogin'])->name('login');
Route::post('/verify_login', [AuthManageController::class, 'verifyLogin']);
Route::post('/first_account', [UserManageController::class, 'firstAccount']);

Route::group(['middleware' => ['auth', 'checkrole:superadmin,admin,kasir']], function () {
	Route::get('/logout', [AuthManageController::class, 'logoutProcess']);
	Route::get('/dashboard', [ViewManageController::class, 'viewDashboard']);
	Route::get('/dashboard/chart/{filter}', [ViewManageController::class, 'filterChartDashboard']);
	Route::post('/market/update', [ViewManageController::class, 'updateMarket']);
	// ------------------------- Fitur Cari -------------------------
	Route::get('/search/{word}', [SearchManageController::class, 'searchPage']);
	// ------------------------- Profil -------------------------
	Route::get('/profile', [ProfileManageController::class, 'viewProfile']);
	Route::post('/profile/update/data', [ProfileManageController::class, 'changeData']);
	Route::post('/profile/update/password', [ProfileManageController::class, 'changePassword']);
	Route::post('/profile/update/picture', [ProfileManageController::class, 'changePicture']);
	// ------------------------- Kelola Akun -------------------------
	// > Akun
	Route::get('/account', [UserManageController::class, 'viewAccount']);
	Route::get('/account/new', [UserManageController::class, 'viewNewAccount']);
	Route::post('/account/create', [UserManageController::class, 'createAccount']);
	Route::get('/account/edit/{id}', [UserManageController::class, 'editAccount']);
	Route::post('/account/update', [UserManageController::class, 'updateAccount']);
	Route::get('/account/delete/{id}', [UserManageController::class, 'deleteAccount']);
	Route::get('/account/filter/{id}', [UserManageController::class, 'filterTable']);
	// > Akses
	Route::get('/access', [AccessManageController::class, 'viewAccess']);
	Route::get('/access/change/{user}/{access}', [AccessManageController::class, 'changeAccess']);
	Route::get('/access/check/{user}', [AccessManageController::class, 'checkAccess']);
	Route::get('/access/sidebar', [AccessManageController::class, 'sidebarRefresh']);
	Route::get('/manage/access', [AccessManageController::class, 'viewAccess'])->name('view.access');
	Route::put('/user/status/{id}', [AccessManageController::class, 'toggleStatus'])->name('user.status.toggle');
	// ------------------------- Kelola Barang -------------------------
	// > Barang
	Route::get('/product', [ProductManageController::class, 'viewProduct']);
	Route::get('/product/new', [ProductManageController::class, 'viewNewProduct']);
	Route::post('/product/create', [ProductManageController::class, 'createProduct']);
	Route::post('/product/import', [ProductManageController::class, 'importProduct']);
	Route::get('/product/edit/{id}', [ProductManageController::class, 'editProduct']);
	Route::post('/product/update', [ProductManageController::class, 'updateProduct']);
	Route::get('/product/delete/{id}', [ProductManageController::class, 'deleteProduct']);
	Route::get('/product/filter/{id}', [ProductManageController::class, 'filterTable']);
	// > Pasok
	Route::get('/supply/system/{id}', [SupplyManageController::class, 'supplySystem']);
	Route::get('/supply', [SupplyManageController::class, 'viewSupply']);
	Route::get('/supply/new', [SupplyManageController::class, 'viewNewSupply']);
	Route::get('/supply/check/{id}', [SupplyManageController::class, 'checkSupplyCheck']);
	Route::get('/supply/data/{id}', [SupplyManageController::class, 'checkSupplyData']);
	Route::post('/supply/create', [SupplyManageController::class, 'createSupply']);
	Route::post('/supply/import', [SupplyManageController::class, 'importSupply']);
	Route::get('/supply/statistics', [SupplyManageController::class, 'statisticsSupply']);
	Route::get('/supply/statistics/product/{id}', [SupplyManageController::class, 'statisticsProduct']);
	Route::get('/supply/statistics/users/{id}', [SupplyManageController::class, 'statisticsUsers']);
	Route::get('/supply/statistics/table/{id}', [SupplyManageController::class, 'statisticsTable']);
	Route::post('/supply/statistics/export', [SupplyManageController::class, 'exportSupply']);
	// ------------------------- Transaksi -------------------------
	Route::get('/transaction', [TransactionManageController::class, 'viewTransaction']);
	Route::get('/transaction/product/{id}', [TransactionManageController::class, 'transactionProduct']);
	Route::get('/transaction/product/check/{id}', [TransactionManageController::class, 'transactionProductCheck']);
	Route::post('/transaction/process', [TransactionManageController::class, 'transactionProcess']);
	Route::get('/transaction/receipt/{id}', [TransactionManageController::class, 'receiptTransaction']);
	// ------------------------- Kelola Laporan -------------------------
	Route::get('/report/transaction', [ReportManageController::class, 'reportTransaction']);
	Route::post('/report/transaction/filter', [ReportManageController::class, 'filterTransaction']);
	Route::get('/report/transaction/chart/{id}', [ReportManageController::class, 'chartTransaction']);
	Route::post('/report/transaction/export', [ReportManageController::class, 'exportTransaction']);
	Route::get('/report/workers', [ReportManageController::class, 'reportWorker']);
	Route::get('/report/workers/filter/{id}', [ReportManageController::class, 'filterWorker']);
	Route::get('/report/workers/detail/{id}', [ReportManageController::class, 'detailWorker']);
	Route::post('/report/workers/export/{id}', [ReportManageController::class, 'exportWorker']);
	//-------------------------- Mitra ------------------------
	Route::resource('mitra', MitraManageController::class);
	//-------------------------- Member------------------------
	Route::resource('member', MemberManageController::class)->except(['show']);
	Route::get('/member/cetak/{id}', [MemberManageController::class, 'cetak'])->name('member.cetak');
	Route::get('/member/setting', [MemberManageController::class, 'setting'])->name('member.setting');
	Route::post('/member/setting', [MemberManageController::class, 'updateSetting'])->name('member.setting.update');
	Route::get('/member/search', [MemberManageController::class, 'search']);

	//-------------------------- Finance ----------------------
	Route::get('/finance', [FinanceManageController::class, 'index'])->middleware('auth');

	//-------------------------= Store ------------------------
	Route::resource('store', StoreManageController::class);
	Route::get('/store', [StoreManageController::class, 'index'])->name('store.index');
	Route::post('/store', [StoreManageController::class, 'store'])->name('store.store');
	Route::get('/store/create', [StoreManageController::class, 'create'])->name('store.create');
	Route::put('/store/{id}', [StoreManageController::class, 'update'])->name('store.update');
	Route::delete('/store/{id}', [StoreManageController::class, 'destroy'])->name('store.destroy');
	Route::get('/store/edit/{id}', [StoreManageController::class, 'edit'])->name('store.edit');

	//------------------------- Gudang ------------------
	Route::prefix('gudang')->group(function () {
		Route::get('/', [GudangManageController::class, 'index'])->name('gudang.index');
		Route::get('/create', function () { return view('gudang.create'); })->name('gudang.create');
		Route::post('/tambah', [GudangManageController::class, 'store'])->name('gudang.tambah');

		// ✅ Perbaikan di bawah ini:
		Route::get('/{id}/edit', [GudangManageController::class, 'edit']);
		Route::put('/{id}', [GudangManageController::class, 'update']);
		Route::delete('/{id}', [GudangManageController::class, 'destroy']);

		Route::get('/distribusi/{id}', [GudangManageController::class, 'distribusiForm'])->name('gudang.distribusi.form');
		Route::post('/distribusi/{id}', [GudangManageController::class, 'distribusi'])->name('gudang.distribusi');
	});

	// ------------------------- Kelola Supplier -------------------------
	Route::prefix('erp')->group(function () {
		Route::resource('supplier', SupplierManageController::class);
	});

	// ------------------------- Kelola Produk ERP -------------------------
	Route::resource('erp/erproduct', ErpProductManageController::class);


	// ------------------------- Kelola Purchase Order -------------------------
	Route::prefix('erp')->middleware(['auth', 'checkrole:superadmin'])->group(function () {
		Route::resource('purchase', PurchaseOrderController::class)->names('purchase');
	});

	// ------------------------- Kelola Produksi -------------------------
	Route::prefix('erp/production')->group(function () {
		Route::get('/', [ProductionManageController::class, 'index'])->name('production.index');
		Route::get('/create', [ProductionManageController::class, 'create'])->name('production.create');
		Route::post('/store', [ProductionManageController::class, 'store'])->name('production.store');
		Route::get('/{id}', [ProductionManageController::class, 'show'])->name('production.show');
	});

	//-------------------------- Kelola Master Produk -------------------------
	Route::prefix('erp/masterproduct')->group(function () {
		Route::get('/', [MasterProductManageController::class, 'index'])->name('masterproduct.index');
		Route::get('/create', [MasterProductManageController::class, 'create'])->name('masterproduct.create');
		Route::post('/', [MasterProductManageController::class, 'store'])->name('masterproduct.store');
		Route::get('/edit/{id}', [MasterProductManageController::class, 'edit'])->name('masterproduct.edit');
		Route::put('/update/{id}', [MasterProductManageController::class, 'update'])->name('masterproduct.update');
		Route::delete('/delete/{id}', [MasterProductManageController::class, 'destroy'])->name('masterproduct.destroy');
	});
});