@extends('adminlte::page')

@section('title', 'Edit Dealer')

@section('content_header')
    <h1>Edit Dealer</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Please correct the errors below.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dealers.update', $dealer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="dealercode">Dealer Code</label>
                        <input type="text" name="dealercode" class="form-control"
                            value="{{ old('dealercode', $dealer->dealercode) }}">
                        @if ($errors->has('dealercode'))
                            <div class="text-danger">{{ $errors->first('dealercode') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="dealername">Dealer Name</label>
                        <input type="text" name="dealername" class="form-control"
                            value="{{ old('dealername', $dealer->dealername) }}" required>
                        @if ($errors->has('dealername'))
                            <div class="text-danger">{{ $errors->first('dealername') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="address">Full Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $dealer->address) }}</textarea>
                        @if ($errors->has('address'))
                            <div class="text-danger">{{ $errors->first('address') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $dealer->city) }}">
                        @if ($errors->has('city'))
                            <div class="text-danger">{{ $errors->first('city') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ old('state', $dealer->state) }}">
                        @if ($errors->has('state'))
                            <div class="text-danger">{{ $errors->first('state') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pincode">Pincode</label>
                        <input type="number" name="pincode" class="form-control"
                            value="{{ old('pincode', $dealer->pincode) }}">
                        @if ($errors->has('pincode'))
                            <div class="text-danger">{{ $errors->first('pincode') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" class="form-control"
                            value="{{ old('phone', $dealer->phone) }}">
                        @if ($errors->has('phone'))
                            <div class="text-danger">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fax">Fax</label>
                        <input type="text" name="fax" class="form-control" value="{{ old('fax', $dealer->fax) }}">
                        @if ($errors->has('fax'))
                            <div class="text-danger">{{ $errors->first('fax') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="contactnumber">Contact Number</label>
                        <input type="number" name="contactnumber" class="form-control"
                            value="{{ old('contactnumber', $dealer->contactnumber) }}">
                        @if ($errors->has('contactnumber'))
                            <div class="text-danger">{{ $errors->first('contactnumber') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="contactperson">Contact Person</label>
                        <input type="text" name="contactperson" class="form-control"
                            value="{{ old('contactperson', $dealer->contactperson) }}">
                        @if ($errors->has('contactperson'))
                            <div class="text-danger">{{ $errors->first('contactperson') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="dealertype">Dealer Type</label>
                        <select name="dealertype" class="form-control">
                            <option value="">Select Dealer Type</option>
                            <option value="world"
                                {{ old('dealertype', $dealer->dealertype) == 'world' ? 'selected' : '' }}>World</option>
                            <option value="studio"
                                {{ old('dealertype', $dealer->dealertype) == 'studio' ? 'selected' : '' }}>Studio</option>
                            <option value="showroom"
                                {{ old('dealertype', $dealer->dealertype) == 'showroom' ? 'selected' : '' }}>Showroom
                            </option>
                        </select>
                        @if ($errors->has('dealertype'))
                            <div class="text-danger">{{ $errors->first('dealertype') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="date_of_updation">Date of Updation</label>
                        <input type="date" name="date_of_updation"
                            value="{{ old('date_of_updation', $dealer->{"date_of_updation"}) }}" class="form-control">
                        @if ($errors->has('date_of_updation'))
                            <div class="text-danger">{{ $errors->first('date_of_updation') }}</div>
                        @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="google_link">Google Map Link</label>
                        <input type="url" name="google_link" class="form-control" value="{{ old('google_link', $dealer->{"google_link"}) }}">
                        @if ($errors->has('google_link'))
                            <div class="text-danger">{{ $errors->first('google_link', $dealer->google_link) }}</div>
                        @endif
                    </div>

                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Dealer</button>
                    <a href="{{ route('dealers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
