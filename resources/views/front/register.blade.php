@extends('Front/layouts.vertical', ['title' => 'Dashboard', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('content')



    <div class="registration-container">
        <div class="registration-card">
            <div class="registration-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            
            <h2 class="registration-title">Create Account</h2>
            <p class="registration-subtitle">Join our theater community and start booking amazing venues</p>

            <!-- <form id="registrationForm"> -->
                <form id="registrationForm" enctype="multipart/form-data">
                <!-- Account Type -->
                <div class="mb-4">
                    <label class="form-label">Account Type</label>
                    <div class="account-type-selector">
                        <div class="account-type-option selected" data-type="personal" data-testid="option-personal">
                            <i class="fas fa-user"></i>
                            <h6>Personal</h6>
                            <p>Individual booking</p>
                        </div>
                        <div class="account-type-option" data-type="organization" data-testid="option-organization">
                            <i class="fas fa-building"></i>
                            <h6>Organization</h6>
                            <p>Company/Group booking</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="mb-4">
                    <h6 class="mb-3 fw-bold">Personal Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Full Name *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required data-testid="input-full-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" required data-testid="input-email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required data-testid="input-phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <div class="input-with-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" class="form-control" id="password" placeholder="Create a password" required data-testid="input-password">
                            </div>
                        </div>
                        <div class="col-12" id="organizationField" style="display: none;">
                            <label for="organization" class="form-label">Organization Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-building"></i>
                                <input type="text" class="form-control" id="organization" placeholder="Enter organization name" data-testid="input-organization">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Identity Verification -->
                <div class="mb-4">
                    <h6 class="mb-3 fw-bold">Identity Verification</h6>
                    <label for="idProof" class="form-label">ID Proof Upload *</label>
                    <div class="upload-area" onclick="document.getElementById('idProof').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p class="mb-1">Upload a file or drag and drop</p>
                        <p class="small mb-0">PDF, JPG, PNG up to 10MB</p>
                        <input type="file" id="idProof" class="d-none" accept=".pdf,.jpg,.jpeg,.png" data-testid="input-id-proof">
                    </div>
                    <p class="small text-muted mt-2 mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Please upload a valid government ID (Aadhaar, PAN, Passport, etc.)
                    </p>
                </div>

                <!-- Terms and Conditions -->
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="terms" required data-testid="checkbox-terms">
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="#" class="text-decoration-none">Terms and Conditions</a> and <a href="#" class="text-decoration-none">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-gradient w-100" data-testid="button-create-account">
                    <i class="fas fa-user-plus me-2"></i>
                    Create Account
                </button>

                <p class="text-center mt-3 mb-0">
                    Already have an account? <a href="login.html" class="text-decoration-none fw-bold">Login</a>
                </p>
            </form>
        </div>
    </div>

        <script>
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append('accountType', document.querySelector('.account-type-option.selected').dataset.type);
    formData.append('fullName', document.getElementById('fullName').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('phone', document.getElementById('phone').value);
    formData.append('password', document.getElementById('password').value);
    formData.append('organization', document.getElementById('organization').value);
    formData.append('idProof', document.getElementById('idProof').files[0]);

    fetch("{{ route('register.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');

        // if (data.redirect) {
        //     setTimeout(() => {
        //         window.location.href = data.redirect;
        //     }, 1500);
        // }
    })
    .catch(error => {
        showToast("Something went wrong", "error");
        console.log(error);
    });
});

        // Account type selection
        document.querySelectorAll('.account-type-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.account-type-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
                
                const organizationField = document.getElementById('organizationField');
                if (this.dataset.type === 'organization') {
                    organizationField.style.display = 'block';
                    document.getElementById('organization').required = true;
                } else {
                    organizationField.style.display = 'none';
                    document.getElementById('organization').required = false;
                }
            });
        });

        // File upload display
        document.getElementById('idProof').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                showToast(`File selected: ${fileName}`, 'success');
            }
        });

        // Form submission
        // document.getElementById('registrationForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
            
        //     const formData = {
        //         accountType: document.querySelector('.account-type-option.selected').dataset.type,
        //         fullName: document.getElementById('fullName').value,
        //         email: document.getElementById('email').value,
        //         phone: document.getElementById('phone').value,
        //         password: document.getElementById('password').value,
        //         organization: document.getElementById('organization').value || null,
        //         idProof: document.getElementById('idProof').files[0]?.name || null
        //     };
            
        //     console.log('Registration data:', formData);
        //     showToast('Account created successfully! Redirecting...', 'success');
            
        //     setTimeout(() => {
        //         window.location.href = 'index.html';
        //     }, 2000);
        // });
    </script>
@endsection

@section('script')
    @vite(['resources/js/pages/dashboard.js'])
@endsection
