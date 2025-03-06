<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoX Studio - Service Request Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/autox.css') }}" rel="stylesheet">
</head>
<body>
    <div class="header text-center">
        <h1><span class="brand-yellow">AutoX</span> Studio</h1>
        <p class="mt-2">Premium Car Detailing Services</p>
    </div>

    <div class="container mb-5">
        <h2 class="text-center mb-4">Service Request Form</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('service.store') }}" method="POST" id="serviceRequestForm">
            @csrf
            
            <!-- Customer Information Section -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">1</span>Customer Information
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="customer_name" value="{{ old('customer_name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phoneNumber" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="emailAddress" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="emailAddress" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                    </div>
                </div>
            </div>
            
            <!-- Vehicle Information Section -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">2</span>Vehicle Information
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="carBrand" class="form-label">Car Brand</label>
                        <select class="form-select" id="carBrand" name="car_brand" required>
                            <option value="" selected disabled>Select Brand</option>
                            <option value="Audi" {{ old('car_brand') == 'Audi' ? 'selected' : '' }}>Audi</option>
                            <option value="BMW" {{ old('car_brand') == 'BMW' ? 'selected' : '' }}>BMW</option>
                            <option value="Ford" {{ old('car_brand') == 'Ford' ? 'selected' : '' }}>Ford</option>
                            <option value="Honda" {{ old('car_brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                            <option value="Hyundai" {{ old('car_brand') == 'Hyundai' ? 'selected' : '' }}>Hyundai</option>
                            <option value="Kia" {{ old('car_brand') == 'Kia' ? 'selected' : '' }}>Kia</option>
                            <option value="Mazda" {{ old('car_brand') == 'Mazda' ? 'selected' : '' }}>Mazda</option>
                            <option value="Mercedes" {{ old('car_brand') == 'Mercedes' ? 'selected' : '' }}>Mercedes-Benz</option>
                            <option value="Mitsubishi" {{ old('car_brand') == 'Mitsubishi' ? 'selected' : '' }}>Mitsubishi</option>
                            <option value="Nissan" {{ old('car_brand') == 'Nissan' ? 'selected' : '' }}>Nissan</option>
                            <option value="Toyota" {{ old('car_brand') == 'Toyota' ? 'selected' : '' }}>Toyota</option>
                            <option value="Volkswagen" {{ old('car_brand') == 'Volkswagen' ? 'selected' : '' }}>Volkswagen</option>
                            <option value="Other" {{ old('car_brand') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="carModel" class="form-label">Car Model & Year</label>
                        <input type="text" class="form-control" id="carModel" name="car_model" value="{{ old('car_model') }}" placeholder="e.g., Camry 2022" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="licensePlate" class="form-label">License Plate</label>
                        <input type="text" class="form-control" id="licensePlate" name="license_plate" value="{{ old('license_plate') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="color" class="form-label">Vehicle Color</label>
                        <input type="text" class="form-control" id="color" name="color" value="{{ old('color') }}">
                    </div>
                </div>
            </div>
            
            <!-- Services Required Section -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">3</span>Services Required
                </div>
                <p class="mb-3">Please select the services you're interested in:</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="service-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Full Detail" name="services[]" id="fullDetail" {{ in_array('Full Detail', old('services', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="fullDetail">
                                    <h5>Full Detail</h5>
                                    <p>Complete interior and exterior detailing service</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="service-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Paint Protection" name="services[]" id="paintProtection" {{ in_array('Paint Protection', old('services', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="paintProtection">
                                    <h5>Paint Protection</h5>
                                    <p>Long-lasting protection for your vehicle's paint</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="service-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Ceramic Coating" name="services[]" id="ceramicCoating" {{ in_array('Ceramic Coating', old('services', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ceramicCoating">
                                    <h5>Ceramic Coating</h5>
                                    <p>Premium coating that provides superior protection</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="service-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Interior Detail" name="services[]" id="interiorDetail" {{ in_array('Interior Detail', old('services', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="interiorDetail">
                                    <h5>Interior Detail</h5>
                                    <p>Deep cleaning of your vehicle's interior</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="service-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Exterior Detail" name="services[]" id="exteriorDetail" {{ in_array('Exterior Detail', old('services', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="exteriorDetail">
                                    <h5>Exterior Detail</h5>
                                    <p>Thorough cleaning and polishing of your vehicle's exterior</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="service-option">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Headlight Restoration" name="services[]" id="headlightRestoration" {{ in_array('Headlight Restoration', old('services', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="headlightRestoration">
                                    <h5>Headlight Restoration</h5>
                                    <p>Restore foggy or yellowed headlights</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Notes Section -->
            <div class="form-section">
                <div class="section-title">
                    <span class="section-number">4</span>Additional Notes
                </div>
                <div class="mb-3">
                    <label for="additionalNotes" class="form-label">Any specific requirements or concerns?</label>
                    <textarea class="form-control" id="additionalNotes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" class="submit-btn">Submit Service Request</button>
            </div>
        </form>
    </div>
    
    <div class="footer text-center">
        <p>© 2025 AutoX Studio. All rights reserved.</p>
        <p>Premium car detailing services in Australia</p>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script to highlight selected service options
        document.querySelectorAll('.service-option').forEach(option => {
            option.addEventListener('click', function() {
                const checkbox = this.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                this.classList.toggle('selected', checkbox.checked);
            });
        });

        // When the page loads, add the 'selected' class to options with checked checkboxes
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
                checkbox.closest('.service-option').classList.add('selected');
            });
        });

        // Prevent double click issues on checkboxes
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.addEventListener('click', function(e) {
                e.stopPropagation();
                this.closest('.service-option').classList.toggle('selected', this.checked);
            });
        });
    </script>
</body>
</html>