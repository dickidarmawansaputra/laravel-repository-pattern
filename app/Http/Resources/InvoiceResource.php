<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'invoice_amount' => $this->amount,
            'invoice_note' => $this->note,
            'invoice_date' => $this->created_at->format('d F Y H:i'),
            'invoice_user' => $this->userInvoice->only('id', 'name', 'email')
        ];
    }
}
