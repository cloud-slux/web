<?php


namespace App\Http\Controllers\erp;

use App\ViewForm\Form;
use Illuminate\Routing\Controller as BaseController;
use App\ViewForm\FormBuilder;
use Illuminate\Support\Facades\Route;

class ViewFormController extends BaseController
{

    public $form;
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->middleware('auth');

        $this->form = $form;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(FormBuilder $formBuilder)
    {
        //return view('financial.Classification.index');
        $form = $formBuilder->create(get_class($this->form));

        return view('viewForm.index', compact('form'))
        ->with('apiUrl', env('API_URL', 'http://api.slux.net.br'));
    }

    public function show(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(get_class($this->form));

        return view('viewForm.show', compact('form'))
          ->with('apiUrl', env('API_URL', 'http://api.slux.net.br'));
    }

    public function routeNameId(){
        $routeNameId = $this->form->routeName.'viewform';
        return $routeNameId;
    }

    public function route()
    {
        $routeId = $this->form->route .'/{'.$this->form->slug.'}';
        $routeNameId = $this->routeNameId();

        $namespace = str_replace('App\Http\Controllers\\', '', get_class($this));

        Route::get($this->form->route, $namespace.'@index')->name($this->form->routeName);
        Route::get($routeId, $namespace.'@show')->name($routeNameId);
    }
}
