<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookkeeping\SquareReceipt\SquareReceiptInterface;

class SquareClientController extends Controller
{
    protected $square;

    public function __construct(SquareReceiptInterface $square)
    {
        $this->square = $square;
    }
    public function get(Request $request)
    {

        $receipts = $this->square->testUpdateSquareReceipt($request->input('date'));

        return response()->json($receipts);
    }
}
