@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit My Profile') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update-profile') }}">
                        @csrf

                        @method('PUT')

                        <div class="form-group row">
                            <label for="Full Name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                            <div class="col-md-6">
                                <input name= "name" id="name" type="text" value = "{{ $user->name }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="Address" class="col-md-4 col-form-label text-md-right">{{ __('Address 1') }}</label>

                            <div class="col-md-6">
                                <input name = "address1" id="address1" type="text" pattern="\d+[ ](?:[A-Za-z0-9.-]+[ ]?)+(?:Avenue|Lane|Road|Boulevard|Drive|Street|Ave|Dr|Court|Rd|Blvd|Ln|St)\.?" title="Address" value = "{{ $user->address1 }}" >

                                @error('Address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Address2" class="col-md-4 col-form-label text-md-right">{{ __('Address 2') }}</label>

                            <div class="col-md-6">
                                <input name = "address2" id="address2" type="text" value = "{{ $user->address2 }}" >

                                @error('Address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                   
                        <div class="form-group row">
                            <label for="City" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <input name = "city" id="city" type="text" pattern="[a-zA-Z ]*" title="name of city" value = "{{ $user->city }}" >

                                @error('Address')
                                    <span class="invalid-feedback" role="alert" value = "">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="State" class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>

                            <div class="col-md-6">
                                <!--<input name = "state" id="state" type="text" value = "{{ $user->state }}" >

                                @error('State')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror--> 
                                <select id = "state" name = "state" >
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District Of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <Label class="col-md-4 col-form-label text-md-right">ZIP Code</Label>
                           

                            <div class="col-md-6">
                                 <input name = "zipcode" id = "zipcode" type="text" pattern="[0-9]{5}" title="Five digit zip code" value = "{{ $user->zipcode }}">

                                @error('Zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('SUBMIT') }}
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
