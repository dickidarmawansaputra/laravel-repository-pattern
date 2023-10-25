<?php

namespace App\Contracts;

use App\Models\Invoice;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface InvoiceRepositoryInterface
{
    public function getInvoice(): AnonymousResourceCollection;
    public function findInvoiceByNumber(Invoice $invoiceNumber): JsonResource;
    public function createInvoice(InvoiceStoreRequest $request): JsonResource;
    public function updateInvoice(InvoiceUpdateRequest $request):JsonResource;
    public function deleteInvoice(Invoice $invoiceNumber): bool;
}