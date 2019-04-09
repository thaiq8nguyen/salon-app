@extends('emails.layout')

@section('title', 'Technician Sales Added')

@section('content')
    <h4>Hello, </h4>
    <p>Below are the technician sales for <span style="font-weight: bold; font-size: medium;">{{ Carbon\Carbon::createFromFormat('Y-m-d', $technicianSales[0]->sale->date)->format('D m/d/Y') }}</span></p>
    <div>
        @foreach($technicianSales as $technician)
            <h4>{{ $technician->first_name }}&nbsp;{{ $technician->last_name }}</h4>
            <p style="font-size: large;">Sale:&nbsp;${{ $technician->sale->sale_amount }}&nbsp;/&nbsp; Tip: ${{ $technician->sale->tip_amount }}</p>
        @endforeach
    </div>
@endsection

