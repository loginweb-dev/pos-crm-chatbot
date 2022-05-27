<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Voyager::addAction(\App\Actions\CatalogoManual::class);

        Voyager::addAction(\App\Actions\CompraInsumo::class);

        $empresa=setting('empresa.type_negocio');
        if($empresa=="Farmacia"||$empresa=="Ferreteria"){
            Voyager::addAction(\App\Actions\CompraProducto::class);
            Voyager::addAction(\App\Actions\CompraProductoDetalle::class);

        }

        Voyager::addAction(\App\Actions\CierreCaja::class);
        //
        Voyager::addAction(\App\Actions\VentaDetalle::class);
        Voyager::addAction(\App\Actions\VentaRecibo::class);

        Voyager::addAction(\App\Actions\ProductionDetalle::class);
        // Voyager::addAction(\App\Actions\ProductionRecibo::class);

        // Voyager::addAction(\App\Actions\ProductionSemiDetalle::class);
        // Voyager::addAction(\App\Actions\ProductionSemiRecibo::class);

        // Voyager::addAction(\App\Actions\ProductoDetalle::class);

        Voyager::addAction(\App\Actions\CajaDetalle::class);

        Voyager::addAction(\App\Actions\CompraDetalle::class);




        // Voyager::addAction(\App\Actions\DetalleCaja::class);

        Voyager::addAction(\App\Actions\Monitor::class);

        // Voyager::addAction(\App\Actions\Kardex::class);

        Voyager::addAction(\App\Actions\Block::class);

        Voyager::addAction(\App\Actions\Location::class);

    }
}
