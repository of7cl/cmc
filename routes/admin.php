<?php

use App\Http\Controllers\Admin\DocumentoController;
use App\Http\Controllers\Admin\FeriadoController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PersonaController;
/* use App\Http\Controllers\Admin\NaveController; */
use App\Http\Controllers\Admin\RangoController;
use App\Http\Controllers\Admin\ShipController;
use App\Http\Controllers\Admin\ShipTipoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CarbonController;
use App\Http\Controllers\Admin\ParameterDocController;
use App\Http\Controllers\Admin\ProgramacionEmbarcosController;
use App\Http\Controllers\Admin\TrayectoriaController;
use App\Http\Controllers\NotificationController;
use App\Http\Livewire\Admin\ControlTrayectoriaShow;
use App\Models\Documento;
use App\Models\Persona;
use App\Models\Rango;
use App\Models\Ship;
use App\Models\ParameterDoc;
//use DragonCode\Contracts\Cashier\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

//Auth::routes();

Route::get('storage-link', function(){
    Artisan::call('storage:link');
});

Route::get('', [HomeController::class, 'index']);
Route::resource('users', UserController::class)->names('admin.users');
Route::get('change_password/{user}', [UserController::class, 'change_pass'])->name('admin.users.change_password');
Route::resource('rangos', RangoController::class)->names('admin.rangos');
Route::resource('ships', ShipController::class)->names('admin.ships');
Route::resource('ship_tipos', ShipTipoController::class)->names('admin.ship_tipos');
Route::resource('personas', PersonaController::class)->names('admin.personas');
Route::resource('documentos', DocumentoController::class)->names('admin.documentos');
Route::resource('parameterdocs', ParameterDocController::class)->names('admin.parameterdocs');
Route::resource('trayectorias', TrayectoriaController::class)->names('admin.trayectorias');
Route::resource('programacion_embarcos', ProgramacionEmbarcosController::class)->names('admin.programacion_embarcos');
Route::resource('feriados', FeriadoController::class)->names('admin.feriados');

Route::get('rangos/{rango}/asignar-documento', function (Rango $rango){
    $documentos = Documento::select(
                                    DB::raw("(case when (codigo_omi is null and nombre is null) then ''
                                                    when (codigo_omi is null and nombre is not null) then nombre
                                                    when (codigo_omi is not null and nombre is null) then codigo_omi
                                                    when (codigo_omi is not null and nombre is not null) then concat(codigo_omi,' - ',nombre)
                                            end) as name, codigo_omi, nombre, id")
                                )
                                ->pluck('name', 'id');    
    return view('admin.rangos.asignar-documento', compact('rango', 'documentos'));
})->name('admin.rangos.asignar-documento');
Route::get('rangos/{rango}/eliminar-documento', function (Rango $rango){    
    return $rango;
})->name('admin.rangos.eliminar-documento');
Route::get('control/index', function (Request $request){
    $personas = Persona::where('estado', 1)->orderBy('id', 'desc')->get();
    $documentos = Documento::where('estado', 1)->orderBy('id', 'asc')->get();
    $rangos = Rango::where('estado', 1)->orderBy('id', 'asc')->pluck('nombre', 'id');
    $ships = Ship::where('estado', 1)->orderBy('id', 'asc')->pluck('nombre', 'id');
    return view('admin.control.index', compact('personas', 'documentos', 'rangos', 'ships'));
})->name('admin.control.index');

Route::get('notifications/',[NotificationController::class,'index'])->name('notification.index');
Route::get('notifications/new',[NotificationController::class,'getAllFormatedByAdminLte'])->name('notification.new');
Route::get('notifications/update-unreaded',[NotificationController::class,'updateUnreaded'])->name('notification.update_unreaded');

// Route::get('trayectoria/index', function (Request $request){
//     $personas = Persona::where('estado', 1)->orderBy('id', 'desc')->get();
//     $documentos = Documento::where('estado', 1)->orderBy('id', 'asc')->get();
//     $rangos = Rango::where('estado', 1)->orderBy('id', 'asc')->pluck('nombre', 'id');
//     $ships = Ship::where('estado', 1)->orderBy('id', 'asc')->pluck('nombre', 'id');
//     return view('admin.trayectoria.index', compact('personas', 'documentos', 'rangos', 'ships'));
// })->name('admin.trayectoria.index');

// Route::get('trayectoria/{persona_id}', function ($persona_id){     
//            return view('admin.trayectoria.show', compact('persona_id'));
// })->name('admin.trayectoria.show');

