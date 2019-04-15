@extends('emails.layout')

@section('title', 'Technician Sales Added')
@section('content')
    <div class="row">
        <h4>Hello, </h4>
        <p>Below are the technician sales for <span style="font-weight: bold; font-size: large;">{{ Carbon\Carbon::createFromFormat('Y-m-d', $squareReceipt->date)->format('D m/d/Y') }}</span></p>
        <div id="technician-sales">
            <table style="border-collapse: collapse;">
                <thead style="background-color: #D32F2F; color: #FFFFFF;">
                <tr>
                    <th style="padding: 10px; text-align: left; font-size: large;">Technician</th>
                    <th style="padding: 10px; text-align: left; font-size: large;">Sale</th>
                    <th style="padding: 10px; text-align: left; font-size: large;">Tip</th>
                </tr>
                </thead>
                <tbody style="border-bottom: 1px solid black;">
                @foreach($technicianSales['sales'] as $technician)
                    <tr style="font-size: large;">
                        <td style="padding: 10px;">{{ $technician->first_name }}&nbsp;{{ $technician->last_name }}</td>
                        <td style="padding: 10px;">${{ $technician->sale->sale_amount }}</td>
                        <td style="padding: 10px;">${{ $technician->sale->tip_amount }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td style="padding: 10px;">
                        Total
                    </td>
                    <td style="padding: 10px;">
                        ${{ $technicianSales['totalSale']['amount'] }}
                    </td>
                    <td style="padding: 10px;">
                        ${{ $technicianSales['totalTip']['amount'] }}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div id="square-receipt" style="margin-top: 10px;">
            <table style="font-size: large;">
                <thead style="background-color: #D32F2F; color: #ffffff">
                    <tr>
                        <th colspan="4" style="padding: 10px;">Square</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($squareReceipt['receiptItems'] as $receiptItem)
                    <tr>
                        <th style="text-align: left; padding: 10px;">{{ $receiptItem->name }}</th>
                        <td style="text-align: right; padding: 10px;">${{ $receiptItem->amount }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
        <div id="summary" style="font-size:large;">
            <p>Technician Total Collected:&nbsp;${{ $summary['technicianSaleTotalCollected'] }}</p>
            <p>Square Total Collected:&nbsp;${{ $summary['squareReceiptTotalCollected'] }}</p>
            <div>
                @if($summary['technicianSaleTotalCollected'] - $summary['squareReceiptTotalCollected'] == 0)
                    <h3>Matched</h3>
                @elseif($summary['technicianSaleTotalCollected'] - $summary['squareReceiptTotalCollected'] > 0)
                    <h3>No Matched. Technician sales is greater than Square receipt by &nbsp${{ $summary['technicianSaleTotalCollected'] - $summary['squareReceiptTotalCollected'] }}</h3>
                @else
                    <h3>No Matched. Technician sales is less than Square receipt by &nbsp${{ abs($summary['technicianSaleTotalCollected'] - $summary['squareReceiptTotalCollected']) }}</h3>
                @endif
            </div>
        </div>
    </div>

@endsection

