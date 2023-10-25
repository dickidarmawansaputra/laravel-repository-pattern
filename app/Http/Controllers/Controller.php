<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      title="Laravel Repository Pattern",
 *      description="Implementation Repository Pattern in Laravel",
 *      @OA\Contact(
 *          email="dickidarmawansaputra@gmail.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
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
