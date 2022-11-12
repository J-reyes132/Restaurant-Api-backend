<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Tools\BitacoraTrait;
use App\Tools\GoogleBucketTrait;
use App\Tools\ToolsTrait;

/**
 * @OA\Info(
 *    title="Documentación API ",
 *    version="1.0",
 *    description="Documentación API ",
 *   @OA\Contact(
 *       name="API Support",
 *       url= "http://www.fmt.com.do/support",
 *       email = "info@fmt.com.do",
 *   ),
 * ),
 * @OA\SecurityScheme(
 *   securityScheme="token",
 *   type="http",
 *   name="Authorization",
 *   in="header",
 *   scheme="Bearer"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, GoogleBucketTrait, ToolsTrait, BitacoraTrait;
}