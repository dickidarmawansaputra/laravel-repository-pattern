<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Http\Resources\InvoiceResource;
use App\Contracts\InvoiceRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    function getInvoice(): AnonymousResourceCollection
    {
        $invoices = Invoice::invoiceData()->get();
        return InvoiceResource::collection($invoices); 
    }
    
    function findInvoiceByNumber($invoiceNumber): JsonResource
    {
        $invoice = Invoice::invoiceData()->where('invoice_number', $invoiceNumber)->firstOrFail();
        return new InvoiceResource($invoice);
    }

    function createInvoice($request): JsonResource
    {
        $request['invoice_number'] = 'INV-'.uniqid();
        $invoice = Invoice::create($request);
        return new InvoiceResource($invoice);
    }
    
    function updateInvoice($request): JsonResource
    {
        $invoice = tap(Invoice::where('invoice_number', $request['invoice_number']))->update($request)->first();
        return new InvoiceResource($invoice);
    }

    function deleteInvoice($invoiceNumber): bool
    {
        $invoice = Invoice::where('invoice_number', $invoiceNumber)->delete();
        return $invoice;
    }
}