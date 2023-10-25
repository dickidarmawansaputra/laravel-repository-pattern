<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Contracts\InvoiceRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    protected $repository;

    function __construct(InvoiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *      path="/api/invoice",
     *      operationId="index",
     *      tags={"Invoice"},
     *      summary="Get list of invoice",
     *      description="Returns list of invoice",
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       @OA\Response(response=404, description="Not found"),
     *     )
     *
     * @return JsonResponse
     */
    function index(): JsonResponse
    {
        try {
            $data = $this->repository->getInvoice();
            $resp = $this->JSON(code: Response::HTTP_OK, data: $data);
            return response()->json($resp,Response::HTTP_OK);
        } catch (Throwable $th) {
            $resp = $this->JSON(code: Response::HTTP_NOT_FOUND, message: $th->getMessage());
            return response()->json($resp, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/invoice/{invoiceNumber}",
     *      operationId="show",
     *      tags={"Invoice"},
     *      summary="Get invoice details",
     *      description="Returns invoice details",
     *      @OA\Parameter(
     *          name="invoiceNumber",
     *          description="Invoice Number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       @OA\Response(response=404, description="Not found"),
     *     )
     *
     * @return JsonResponse
     */
    function show($invoiceNumber): JsonResponse
    {
        try {
            $data = $this->repository->findInvoiceByNumber($invoiceNumber);
            $resp = $this->JSON(code: Response::HTTP_OK, data: $data);
            return response()->json($resp, Response::HTTP_OK);
        } catch (Throwable $th) {
            $resp = $this->JSON(code: Response::HTTP_NOT_FOUND, message: $th->getMessage());
            return response()->json($resp, Response::HTTP_NOT_FOUND);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/api/invoice",
     *      operationId="store",
     *      tags={"Invoice"},
     *      summary="Create new invoice",
     *      description="Returns invoice created",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"user_id", "amount"},
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="note",
     *                     type="string"
     *                 ),
     *                 example={"user_id": 1, "amount": 1, "note": "catatan"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       @OA\Response(response=500, description="Internal server error"),
     *     )
     *
     * @return JsonResponse
     */
    function store(InvoiceStoreRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $data = $this->repository->createInvoice($validated);
            $resp = $this->JSON(code: Response::HTTP_OK, data: $data);
            return response()->json($resp, Response::HTTP_OK);
        } catch (Throwable $th) {
            $resp = $this->JSON(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: $th->getMessage());
            return response()->json($resp, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * @OA\Put(
     *      path="/api/invoice",
     *      operationId="update",
     *      tags={"Invoice"},
     *      summary="Update invoice",
     *      description="Returns invoice updated",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"invoice_number", "user_id", "amount"},
     *                 @OA\Property(
     *                     property="invoice_number",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="note",
     *                     type="string"
     *                 ),
     *                 example={"invoice_number": "INV-2023", "user_id": 1, "amount": 1, "note": "catatan"}
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       @OA\Response(response=500, description="Internal server error"),
     *     )
     *
     * @return JsonResponse
     */
    function update(InvoiceUpdateRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $data = $this->repository->updateInvoice($validated);
            $resp = $this->JSON(code: Response::HTTP_OK, data: $data);
            return response()->json($resp, Response::HTTP_OK);
        } catch (Throwable $th) {
            $resp = $this->JSON(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: $th->getMessage());
            return response()->json($resp, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * @OA\Delete(
     *      path="/api/invoice/{invoiceNumber}",
     *      operationId="destroy",
     *      tags={"Invoice"},
     *      summary="Delete invoice",
     *      description="Delete invoice",
     *      @OA\Parameter(
     *          name="invoiceNumber",
     *          description="Invoice Number",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       @OA\Response(response=500, description="Internal server error"),
     *     )
     *
     * @return JsonResponse
     */
    function destroy($invoiceNumber): JsonResponse
    {
        try {
            $data = $this->repository->deleteInvoice($invoiceNumber);
            if (!$data) {
                $resp = $this->JSON(code: Response::HTTP_NOT_FOUND, data: $data);
                return response()->json($resp, Response::HTTP_NOT_FOUND);
            }
            $resp = $this->JSON(code: Response::HTTP_OK, data: $data);
            return response()->json($resp, Response::HTTP_OK);
        } catch (Throwable $th) {
            $resp = $this->JSON(code: Response::HTTP_INTERNAL_SERVER_ERROR, message: $th->getMessage());
            return response()->json($resp, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
