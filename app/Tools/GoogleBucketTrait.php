<?php

namespace App\Tools;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Exceptions\SomethingWentWrong;
use App\Exceptions\NotEnable;



trait GoogleBucketTrait
{
    public function uploadGoogle(Request $request, $fileName)
    {
        if(env('GOOGLE_CLOUD_ENABLE')){
            if (!$request->file($fileName)) {
                return $file = array(
                    "name" => null,
                    "url" => null,
                    "ext" => null,
                    "size" => null,
                );
            }

            try {
                // Initialize Google Storage
                $disk = \Storage::disk('gcs');

                $folder = env('GOOGLE_CLOUD_FOLDER', "APP_FOLDER");

                $name = strtoupper(env('APP_NAME').'-'.Carbon::now()->format('Y-m-d')."-".time().".".$request->file($fileName)->getClientOriginalExtension());
                $disk->write($folder."/".$name, file_get_contents($request->file($fileName)), ['visibility' => 'public']);

                $file = array(
                    "name" => $name,
                    "url" => $disk->url($folder."/".$name),
                    "ext" => $request->file($fileName)->getClientOriginalExtension(),
                    "size" => $request->file($fileName)->getSize(),
                );

                return $file;
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }

        } else {
            throw new NotEnable();
        }

    }

    public function destroyGoogle($fileName){
        $disk = \Storage::disk('gcs');
        $disk->delete($fileName);
    }

}