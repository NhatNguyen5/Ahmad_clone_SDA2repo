
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Fuel Quote History') }}</div>
                    <div class="card-body">
                       <!-- <h1> History (Note for future : $orders from controller and $order to dynamically show order drom Database)</h1> -->

                        <table class = "card body-table">
                            <tr>
                                <td style="width: 180px">        Gallons       </td>
                                <td style="width: 300px">        Address       </td>
                                <td style="width: 160px">     Delivery Date    </td>
                                <td style="width: 170px">    Suggested Price   </td>
                                <td style="width: 180px">   Total Amount Due   </td>
                            </tr>
                            @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->Gallons }} gallon(s)</td>
                                <td>{{$item->Address }}</td>
                                <td>{{$item->start }}</td>
                                <td>${{$item->Suggested_Price }}</td>
                                <td>${{$item->Due }}</td>
                            </tr>  
                            @endforeach
                        </table>
                        

                        
                                                  
                    </div>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
