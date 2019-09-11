<?php


use App\erp\facades\ViewFormModuleFacade;



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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(array('before' => 'auth'), function()
{
    foreach(ViewFormModuleFacade::getModules() as $module)
    {
        $route = '/'.$module;

        Route::get($route, function () {
            $uri = Request::path();
            $view = 'viewForm.module';
            $forms = ViewFormModuleFacade::getFormsFromModule($uri);

            $moduleName = ViewFormModuleFacade::getModuleName($uri);

            return view($view,  compact('forms'))
             ->with('moduleName', $moduleName);
        });
    }
});

foreach(ViewFormModuleFacade::getAllControllers() as $controller)
{
    $controller->route();
}
