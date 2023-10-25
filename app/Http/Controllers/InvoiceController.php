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
