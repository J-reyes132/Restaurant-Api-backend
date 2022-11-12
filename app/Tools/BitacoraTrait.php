<?php

namespace App\Tools;

use App\Models\Modulo;
use App\Models\Bitacora;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Exceptions\NotEnable;
use Carbon\Carbon;

trait BitacoraTrait
{

    /**
     * Create Bitacora in storage.
     *
     * @param  $nombre_modulo Nombre del modulo
     * @param  $descripcion Descripcion de lo ejecutado
     * @param  \App\Models\Model  $entidad Entidad que se esta procesando
     */
    public function bitacora($nombre_modulo, $descripcion, $entidad)
    {
        try {
            $modulo = Modulo::where('nombre', $nombre_modulo)->first();

            $bitacora = new Bitacora;
            $bitacora->user_id = auth()->user()->id;
            $bitacora->modulo_id = $modulo->id;
            $bitacora->descripcion = $descripcion;
            $bitacora->entidad = json_encode($entidad);
            $bitacora->save();
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }

    }

}