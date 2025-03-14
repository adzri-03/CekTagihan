<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembacaanMeter;
use Barryvdh\DomPDF\Facade\Pdf;

class Invoice extends Controller
{
    public function download($id)
    {
        $invoice = PembacaanMeter::findOrFail($id);
        
        $pdf = Pdf::loadView('invoice-pdf', compact('invoice'))
        ->setPaper('A4', 'potrait');
        
        return $pdf->stream('invoice_'.$invoice->id.'.pdf');
    }
}
