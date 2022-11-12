<?php


namespace App\Tools;
use Carbon\Carbon;

trait ToolsTrait
{

    public function deleted()
    {
        return response()->json(['status' => 'successful', 'message' => 'Recurso borrado'], ResponseCodes::ACCEPTED);
    }

    public function getCodigo()
    {
        try {
            $current = Expediente::all()->last() ? Expediente::all()->last()->id : 0;
            $date = Carbon::now()->year.Carbon::now()->month.Carbon::now()->day;
            $code = env('CASOS_PREFIX').$date."-".str_pad($current+1, 9, "0", STR_PAD_LEFT);
            return $code;
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

}