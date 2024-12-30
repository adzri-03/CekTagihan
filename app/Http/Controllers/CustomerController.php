<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function generatePDF (Request $request) {
        $customers = Customer::whereIn('id', $request->input('ids'))->get();

        $data = $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'pam_code' => $customer->pam_code,
                'name' => $customer->name,
                'address' => $customer->address,
                'phone' => $customer->phone,
                ];
            });
        $pdf = Pdf::loadView('qr-pdf', compact('data'))
                ->setPaper('a4','landscape');

        return $pdf->stream('qr-codes.pdf');
        // return view('qr-pdf', compact('data'));
    }
}
