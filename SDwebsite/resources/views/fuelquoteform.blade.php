

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Fuel Quote') }}</div>
                <div class="card-body">
                    <form action="fuelquoteform" oninput="if(Gallons.value >= 1000){gf = 0.02;}else{gf = 0.03;}
                                                           
                                                            O_Price.value = Math.round(((( {{$QuoteFormData[0]}} + gf )*1.50)+1.50 ) *1000)/1000; 
                                                           
                                                            result.value = Math.round((O_Price.value * Gallons.value)*100)/100;" method="POST">
                        @csrf
                        <!-- "if(Gallons.value >= 1000){gf = 0.2;}else{gf = 0.3;} 
                                                            O_Price.value = (({{$QuoteFormData[0]}} + gf * 1.5) * 100)/100; 
                                                            result.value = (O_Price.value * Gallons.value * 100)/100; 
                                                            Price.value = O_Price.value"-->

                        <div class="form-group row">
                            <label for="Gallons" class="col-md-4 col-form-label text-md-right">{{ __('Gallons Requested') }}</label>

                            <div class="col-md-6">
                                <input name ="Gallons" id = "Gallons" type="number" pattern = "[0-9]" min = "0" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Address" class="col-md-4 col-form-label text-md-right">{{ __('Full Delivery Address') }}</label>

                            <div class="col-md-6">
                                @auth

                                    
                                    {{$QuoteFormData[1]}}
                                        
                                        
                                    
                                @else
                                    <p>You are a guest!
                                    <br>
                                    No discount for you!</p>
                                @endauth

                                
                            </div>
                        </div>
                        <!-- INSERT DATE PICKER HERE -->
                        <div class="form-group row">
                            <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Delivery date') }}</label>
                        
                            <div class="col-md-6">
                                <input type="date" name ="start" name="trip-start" value="2021-01-2" min="2021-01-01" max="2021-12-31" required>
                                
                                @error('Date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        
                        <div class="form-group row">
                            <label for="Price" class="col-md-4 col-form-label text-md-right">{{ __('Suggested Price/Gallon') }}</label>

                            <div class="col-md-6">
                                $<output name ="O_Price" id = "O_Price"></output>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Due" class="col-md-4 col-form-label text-md-right">{{ __('Total Amount Due') }}</label>

                            <div class="col-md-6">
                                $<output name = result></output>
                            </div>
                        </div>

                        
                        @auth
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('SUBMIT') }}
                                    </button>
                                </div>
                            </div>
                        @endauth

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
