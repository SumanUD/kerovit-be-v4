<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ isset($dealer) ? route('dealers.update', $dealer->id) : route('dealers.store') }}" 
              method="POST">
            @csrf
            @if(isset($dealer))
                @method('PUT')
            @endif

            <div class="row g-4">
                <div class="col-md-6">

                    <div class="mb-4">
                        <label for="dealercode" class="form-label fw-semibold">Dealer Code <span class="text-danger">*</span></label>
                        <input type="text" id="dealercode" name="dealercode" placeholder="Enter dealer code"
                               class="form-control form-control-lg @error('dealercode') is-invalid @enderror"
                               value="{{ old('dealercode', $dealer->dealercode ?? '') }}" required>
                        @error('dealercode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="dealername" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" id="dealername" name="dealername" placeholder="Enter dealer name"
                               class="form-control form-control-lg @error('dealername') is-invalid @enderror"
                               value="{{ old('dealername', $dealer->dealername ?? '') }}" required>
                        @error('dealername') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <textarea id="address" name="address" rows="4" placeholder="Enter address"
                                  class="form-control form-control-lg @error('address') is-invalid @enderror">{{ old('address', $dealer->address ?? '') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label for="city" class="form-label fw-semibold">City</label>
                            <input type="text" id="city" name="city" placeholder="City"
                                   class="form-control form-control-lg @error('city') is-invalid @enderror"
                                   value="{{ old('city', $dealer->city ?? '') }}">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-6">
                            <label for="state" class="form-label fw-semibold">State</label>
                            <input type="text" id="state" name="state" placeholder="State"
                                   class="form-control form-control-lg @error('state') is-invalid @enderror"
                                   value="{{ old('state', $dealer->state ?? '') }}">
                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label for="pincode" class="form-label fw-semibold">Pin Code</label>
                            <input type="text" id="pincode" name="pincode" placeholder="e.g. 123456"
                                   class="form-control form-control-lg @error('pincode') is-invalid @enderror"
                                   value="{{ old('pincode', $dealer->pincode ?? '') }}">
                            @error('pincode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-6">
                            <label for="phone" class="form-label fw-semibold">Phone</label>
                            <input type="text" id="phone" name="phone" placeholder="10-digit phone number"
                                   class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $dealer->phone ?? '') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label for="fax" class="form-label fw-semibold">Fax</label>
                            <input type="text" id="fax" name="fax" placeholder="Fax number"
                                   class="form-control form-control-lg @error('fax') is-invalid @enderror"
                                   value="{{ old('fax', $dealer->fax ?? '') }}">
                            @error('fax') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-6">
                            <label for="contactnumber" class="form-label fw-semibold">Contact Number</label>
                            <input type="text" id="contactnumber" name="contactnumber" placeholder="Contact number"
                                   class="form-control form-control-lg @error('contactnumber') is-invalid @enderror"
                                   value="{{ old('contactnumber', $dealer->contactnumber ?? '') }}">
                            @error('contactnumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="contactperson" class="form-label fw-semibold">Contact Person</label>
                        <input type="text" id="contactperson" name="contactperson" placeholder="Contact person full name"
                               class="form-control form-control-lg @error('contactperson') is-invalid @enderror"
                               value="{{ old('contactperson', $dealer->contactperson ?? '') }}">
                        @error('contactperson') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="dealertype" class="form-label fw-semibold">Dealer Type</label>
                        <input type="text" id="dealertype" name="dealertype" placeholder="Type of dealer"
                               class="form-control form-control-lg @error('dealertype') is-invalid @enderror"
                               value="{{ old('dealertype', $dealer->dealertype ?? '') }}">
                        @error('dealertype') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="google_link" class="form-label fw-semibold">Google Link</label>
                        <input type="url" id="google_link" name="google_link" placeholder="https://maps.google.com/..."
                               class="form-control form-control-lg @error('google_link') is-invalid @enderror"
                               value="{{ old('google_link', $dealer->google_link ?? '') }}">
                        @error('google_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date_of_updation" class="form-label fw-semibold">Date of Updation</label>
                        <input type="date" id="date_of_updation" name="date_of_updation"
                               class="form-control form-control-lg @error('date_of_updation') is-invalid @enderror"
                               value="{{ old('date_of_updation', $dealer->date_of_updation ?? '') }}">
                        @error('date_of_updation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success btn-lg px-4">
                    {{ isset($dealer) ? 'Update Dealer' : 'Add Dealer' }}
                </button>
            </div>
        </form>
    </div>
</div>
