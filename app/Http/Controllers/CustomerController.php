<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function generatePDF (Request $request) {
        ini_set('max_execution_time', 300);
        $customers = Customer::select('id', 'pam_code', 'name', 'address', 'phone')
                             ->whereIn('id', $request->input('ids'))->get();
        $data = collect();

        Customer::whereIn('id', $request->input('ids'))->chunk(100, function ($customers) use ($data) {
            foreach ($customers as $customer) {
                $data->push([
                    'id' => $customer->id,
                    'pam_code' => $customer->pam_code,
                    'name' => $customer->name,
                    'address' => $customer->address,
                    'phone' => $customer->phone,
                ]);
            }
        });
        $pdf = Pdf::loadView('qr-pdf', compact('data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('qr-codes.pdf');
    }
}
