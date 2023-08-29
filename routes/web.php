<?php


use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Blade\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\RatingController;

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blade\UserController;
use App\Http\Controllers\Blade\CategoryController;
use App\Http\Controllers\Blade\ProductController;
use App\Http\Controllers\Blade\RoleController;
use App\Http\Controllers\Blade\PermissionController;
use App\Http\Controllers\Blade\HomeController;
use App\Http\Controllers\Blade\ApiUserController;
use App\Http\Controllers\Blade\StuffController;

/*
|--------------------------------------------------------------------------
| Blade (front-end) Routes
|--------------------------------------------------------------------------
|
| Here is we write all routes which are related to web pages
| like UserManagement interfaces, Diagrams and others
|
*/

// Default laravel auth routes
Auth::routes();


// Welcome page
Route::get('/', function (){
    return redirect()->route('home');
})->name('welcome');

Route::get('/register', function (){
    return redirect()->route('login');
})->name('regist');

// Web pages
Route::group(['middleware' => 'auth'],function (){

    // there should be graphics, diagrams about total conditions
    Route::get('/home', [HomeController::class,'index'])->name('home');

    // Users
    Route::get('/users',[UserController::class,'index'])->name('userIndex');
    Route::get('/user/add',[UserController::class,'add'])->name('userAdd');
    Route::post('/user/create',[UserController::class,'create'])->name('userCreate');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('userEdit');
    Route::post('/user/update/{id}',[UserController::class,'update'])->name('userUpdate');
    Route::delete('/user/delete/{id}',[UserController::class,'destroy'])->name('userDestroy');
    Route::get('/user/theme-set/{id}',[UserController::class,'setTheme'])->name('userSetTheme');
    // Route::post('/user/status/{status}', [UserController::class,'toggleStatus'])->name('toggleStatus');
    Route::put('/toggle-status', [UserController::class,'toggleStatus'])->name('toggle.status');
    // Route::put('/toggle-status', 'UserController@toggleStatus')->name('toggle.status');


    // Permissions
    Route::get('/permissions',[PermissionController::class,'index'])->name('permissionIndex');
    Route::get('/permission/add',[PermissionController::class,'add'])->name('permissionAdd');
    Route::post('/permission/create',[PermissionController::class,'create'])->name('permissionCreate');
    Route::get('/permission/{id}/edit',[PermissionController::class,'edit'])->name('permissionEdit');
    Route::post('/permission/update/{id}',[PermissionController::class,'update'])->name('permissionUpdate');
    Route::delete('/permission/delete/{id}',[PermissionController::class,'destroy'])->name('permissionDestroy');

    // Roles
    Route::get('/roles',[RoleController::class,'index'])->name('roleIndex');
    Route::get('/role/add',[RoleController::class,'add'])->name('roleAdd');
    Route::post('/role/create',[RoleController::class,'create'])->name('roleCreate');
    Route::get('/role/{role_id}/edit',[RoleController::class,'edit'])->name('roleEdit');
    Route::post('/role/update/{role_id}',[RoleController::class,'update'])->name('roleUpdate');
    Route::delete('/role/delete/{id}',[RoleController::class,'destroy'])->name('roleDestroy');

    // ApiUsers
    Route::get('/api-users',[ApiUserController::class,'index'])->name('api-userIndex');
    Route::get('/api-user/add',[ApiUserController::class,'add'])->name('api-userAdd');
    Route::post('/api-user/create',[ApiUserController::class,'create'])->name('api-userCreate');
    Route::get('/api-user/show/{id}',[ApiUserController::class,'show'])->name('api-userShow');
    Route::get('/api-user/{id}/edit',[ApiUserController::class,'edit'])->name('api-userEdit');
    Route::post('/api-user/update/{id}',[ApiUserController::class,'update'])->name('api-userUpdate');
    Route::delete('/api-user/delete/{id}',[ApiUserController::class,'destroy'])->name('api-userDestroy');
    Route::delete('/api-user-token/delete/{id}',[ApiUserController::class,'destroyToken'])->name('api-tokenDestroy');

    //Category
    Route::get('/category',[CategoryController::class,'index'])->name('categoryIndex');
    Route::get('/category/add',[CategoryController::class,'add'])->name('categoryAdd');
    Route::post('/category/create',[CategoryController::class,'create'])->name('categoryCreate');
    Route::get('/category/{category_id}/edit',[CategoryController::class,'edit'])->name('categoryEdit');
    Route::post('/category/update/{category_id}',[CategoryController::class,'update'])->name('categoryUpdate');
    Route::delete('/category/delete/{id}',[CategoryController::class,'destroy'])->name('categoryDestroy');

    //Company
    Route::get('/company',[CompanyController::class,'index'])->name('companyIndex');
    Route::get('/company/add',[CompanyController::class,'add'])->name('companyAdd');
    Route::post('/company/create',[CompanyController::class,'create'])->name('companyCreate');
    Route::get('/company/{company_id}/edit',[CompanyController::class,'edit'])->name('companyEdit');
    Route::post('/company/update/{company_id}',[CompanyController::class,'update'])->name('companyUpdate');
    Route::delete('/company/delete/{id}',[CompanyController::class,'destroy'])->name('companyDestroy');
  
    //Driver
    Route::get('/driver',[DriverController::class,'index'])->name('driverIndex');
    Route::get('/driver/add',[DriverController::class,'add'])->name('driverAdd');
    Route::post('/driver/create',[DriverController::class,'create'])->name('driverCreate');
    Route::get('/driver/{driver_id}/edit',[DriverController::class,'edit'])->name('driverEdit');
    Route::post('/driver/update/{driver_id}',[DriverController::class,'update'])->name('driverUpdate');
    Route::delete('/driver/delete/{id}',[DriverController::class,'destroy'])->name('driverDestroy');
  
    //Product
    Route::get('/task',[ProductController::class, 'index'])->name('taskIndex');
    Route::get('/task/add',[ProductController::class, 'add'])->name('taskAdd');
    Route::get('/tasks/extra',[ProductController::class, 'showExtraTaskView'])->name('extraTaskView');
    Route::post('/task/create',[ProductController::class, 'create'])->name('taskCreate');
    Route::get('/task/{product_id}/edit',[ProductController::class, 'edit'])->name('taskEdit');
    Route::post('/task/update/{product_id}',[ProductController::class, 'update'])->name('taskUpdate');
    Route::delete('/task/delete/{id}',[ProductController::class, 'destroy'])->name('taskDestroy');
    Route::post('/task/toggle-status/{id}',[ProductController::class,'toggleProductActivation'])->name('taskActivation');
    Route::post('/products/{product}/order', [ProductController::class, 'order'])->name('products.order');  
    Route::get('/drivers/get-drivers-by-company', [ProductController::class, 'getDriversByCompany'])->name('drivers.getDriversByCompany');
  
    // Orders
    Route::get('/order',[OrderController::class,'index'])->name('orderIndex');
    Route::post('/submit-order/{id}', [OrderController::class,'submitOrder'])->name('submit.order');
    Route::post('/orders/{order}/finish', [OrderController::class, 'finish'])->name('orders.finish');
    Route::get('/update-timer/{orderId}', [OrderController::class, 'updateTimer'])->name('updateTimer');

    // Ratings and Daily
    Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
    Route::get('/rating/daily', [RatingController::class, 'daily'])->name('ratings.daily');
    Route::post('/submit-rating/{id}', [RatingController::class,'submitRating'])->name('submit.rating');
    Route::get('/reports', [ReportController::class, 'index'])->name('reportIndex');
        Route::get('reports/{user}', [ReportController::class, 'showUserReports'])->name('user.reports');
        Route::get('reports/{userId}/generate-pdf', [ReportController::class, 'generatePDF'])->name('generate.pdf');
    // Route::get('reports/{user}/generate-pdf', [ReportController::class, 'showUserReports'])->name('user.reports');
    // Route::get('reports/{userId}', [ReportController::class, 'generatePDF'])->name('generate.pdf');


    // Route::get('reports/{user}/generate-pdf/', [ReportController::class, 'generatePDF'])->name('generate.pdf');

    // Stuffs
    Route::get('/stuffs',[StuffController::class,'index'])->name('stuffIndex');

    // Monitoring
    Route::get('/monitoring',[MonitoringController::class,'index'])->name('monitoringIndex');
    Route::get('monitoring/edit/{order}',[OrderController::class, 'edit'])->name('orderEdit');
    Route::match(['post', 'put'], 'monitoring/edit/{order_id}', [OrderController::class, 'update'])->name('orderUpdate');
    Route::post('/create-message/{orderId}',[MonitoringController::class,'createMessage'])->name('create.message');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::any('/send-default-message/{order}', [MonitoringController::class, 'sendDefaultMessage'])->name('send.default.message');
    Route::post('/delete-all-messages', [MonitoringController::class, 'deleteAllMessages'])->name('messages.deleteAll');

    // Application task
    Route::get('/main', [MainController::class, 'main'])->middleware('auth');
    Route::get('/dashboard', [MainController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('dashboard/applications', [AppController::class, 'index'])->name('applications');
    Route::get('dashboard/applications/{application}/answer', [AnswerController::class, 'create'])->name('answers.create');
    Route::post('dashboard/applications', [AppController::class, 'store'])->name('applications.store');
    Route::post('dashboard/applications/{application}/answer', [AnswerController::class, 'store'])->name('answers.store');


    
});



  Route::get('/folders', function () {
    return view('pages.folders.index');
})->name('folderIndex');

// Change language session condition
Route::get('/language/{lang}',function ($lang){
    $lang = strtolower($lang);
    if ($lang == 'ru' || $lang == 'uz')
    {
        session([
            'locale' => $lang
        ]);
    }
    return redirect()->back();
});

/*
|--------------------------------------------------------------------------
| This is the end of Blade (front-end) Routes
|-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\
*/
