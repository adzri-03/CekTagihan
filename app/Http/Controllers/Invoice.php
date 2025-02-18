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
        
        $pdf = Pdf::loadView('invoice-pdf', compact('invoice'));
        
        return $pdf->download('invoice_'.$invoice->id.'.pdf');
    }
}
