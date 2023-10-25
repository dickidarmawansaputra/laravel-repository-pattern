<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function JSON($code, $message = "", $data = []){
        switch ($code) {
            case Response::HTTP_OK:
                $status = Response::$statusTexts[Response::HTTP_OK];
                break;
            case Response::HTTP_BAD_REQUEST:
                $status = Response::$statusTexts[Response::HTTP_BAD_REQUEST];
                break;
            case Response::HTTP_UNAUTHORIZED:
                $status = Response::$statusTexts[Response::HTTP_UNAUTHORIZED];
                break;
            case Response::HTTP_NOT_FOUND:
                $status = Response::$statusTexts[Response::HTTP_NOT_FOUND];
                break;
            default:
                $status = Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]; 
                break;
        }
        
        $json = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        return $json;
    }
}
