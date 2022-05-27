<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\PosController;
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
Route::get('/', 'App\Http\Controllers\FrontEndController@default')->name('page_default');
Route::get('/page/{slug}', 'App\Http\Controllers\FrontEndController@pages')->name('pages');

Route::get('venta/{id}', 'App\Http\Controllers\PosController@venta_public')->name('venta.public');

Route::get('/encola/{id}', function ($id) {
    $monitor = App\Monitore::find($id);
    return view('encola')->with('monitor', $monitor);
})->name('monitor');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('ventas/imprimir/{id}', 'App\Http\Controllers\PosController@imprimir')->name('venta.imprimir');
    Route::get('detalle_cajas/imprimir/{id}', 'App\Http\Controllers\PosController@cierre_caja')->name('cajas.cierre_caja');
    Route::get('catalogos/enviar/{id}', function($id){
        $catalogo = App\Catalogo::find($id);
        $productos = App\RelCatalogoProducto::where('catalogo_id', $id)->get();
        $index=0;
        $tabla=[];
        $message="";
        foreach ($productos as $item) {
            $index+=1;
            $prod= App\Producto::find($item->producto_id);
            $message=$message.' '.$index.'.- '.$prod->name.' a '.$prod->precio.' Bs.'.'%0A';
        }
        $url=setting('ventas.pagina_menu');
        $message=$message.'%0A Para realizar sus pedidos online, dirígase al siguiente link:  '.$url;
        return redirect("https://api.whatsapp.com/send?&text= MENU DEL DIA: %0A".$catalogo->title.'%0A'.$message);
    })->name('catalogo.enviar');
    Route::get('compras/insumos/{id}', function($id){
        $insumo = App\Insumo::find($id);
        return redirect("admin/insumos/".$id);
    })->name('insumo.comprar');


    Route::get('compras/producto/{id}', function($id){
        $insumo = App\Producto::find($id);
        return redirect("admin/productos/".$id);
    })->name('producto.comprar');

    Route::get('import/users', 'App\Http\Controllers\PosController@import_users')->name('import.users');
    Route::get('import/clientes', 'App\Http\Controllers\PosController@import_clientes')->name('import.clientes');
    Route::get('import/products', 'App\Http\Controllers\PosController@import_products')->name('import.products');
    Route::get('import/ventas', 'App\Http\Controllers\PosController@import_ventas')->name('import.ventas');

    //Pages
    Route::get('{page_id}/edit', 'PageController@edit')->name('page_edit');
    Route::post('/page/{page_id}/update', 'PageController@update')->name('page_update');
    Route::get('/page/{page_id}/default', 'PageController@default')->name('page_default');
    Route::get('{page_id}/index', 'App\Http\Controllers\BlockController@index')->name('block_index');
    Route::post('/block/update/{block_id}', 'BlockController@update')->name('block_update');
    Route::get('/block/delete/{block_id}', 'BlockController@delete')->name('block_delete');
    Route::get('/block/order/{block_id}/{order}', 'BlockController@block_ordering');
    Route::get('/block/move_up/{block_id}', 'BlockController@move_up')->name('block_move_up');
    Route::get('/block/move_down/{block_id}', 'BlockController@move_down')->name('block_move_down');

});

\PWA::routes();
