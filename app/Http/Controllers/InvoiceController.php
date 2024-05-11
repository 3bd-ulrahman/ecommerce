<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        $invoice = $order;

        $pdf = LaravelMpdf::loadView('pdf.invoice', compact('invoice'));

        $pdf->stream("invoice_$invoice->reference_code.pdf");
    }
}
