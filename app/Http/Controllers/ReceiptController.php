<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Invoice',
            'date' => date('m/d/Y'),
            'due_date' => date('m/d/Y', strtotime('+30 days')),
            'invoice_number' => '123456',
            'items' => [
                [
                    'name' => 'Product 1',
                    'price' => 100,
                    'quantity' => 2
                ],
                [
                    'name' => 'Product 2',
                    'price' => 150,
                    'quantity' => 1
                ],
                [
                    'name' => 'Product 3',
                    'price' => 50,
                    'quantity' => 5
                ]
            ],
            'total' => 800
        ];
        $pdf = Pdf::loadView('receipt.index', $data);
        return $pdf->stream('invoice.pdf');
    }
}
