<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - Theater Admin Panel</title>
    <meta name="description" content="Secure admin portal login for theater management">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background: linear-gradient(135deg, #5b21b6 0%, #7c3aed 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    
    <!-- Admin Login Card -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
                    <div class="card-body p-5">
                        <!-- Logo Icon -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%); border-radius: 16px; box-shadow: 0 8px 24px rgba(168, 85, 247, 0.3);">
                                <i class="fas fa-user-shield text-white" style="font-size: 36px;"></i>
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="text-center fw-bold mb-1" style="color: #1f2937;">Admin Portal</h2>
                        <!-- <p class="text-center text-muted mb-4">TechCorp Solutions</p> -->

                        <!-- Login Form -->
                       <form method="POST" action="{{ route('login') }}">
                                            @csrf

                                            @if (sizeof($errors) > 0)
                                                @foreach ($errors->all() as $error)
                                                    <p class="text-danger">{{ $error }}</p>
                                                @endforeach
                                            @endif
                            <div class="mb-3">
                                <label for="emailAddress" class="form-label fw-semibold" style="color: #1f2937;">Email Address</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-envelope"></i>
                                    <input type="email" class="form-control" id="emailAddress" placeholder="Enter your email" name="email" required data-testid="input-admin-email" value="test@test.com">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold" style="color: #1f2937;">Password</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required data-testid="input-admin-password" value="password">
                                </div>
                            </div>

                            <!-- <button type="submit" class="btn btn-gradient w-100 mb-4" data-testid="button-admin-signin">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Sign In to Admin Panel
                            </button> -->
                             <button class="btn btn-soft-primary w-100" type="submit"><i class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Log In</span> </button>
                            
                        </form>

                        <!-- Demo Credentials -->
                       
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-3">
                    <a href="index.html" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Back to Website
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <div id="toast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage"></div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
    <!-- <script>
        document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('emailAddress').value;
            const password = document.getElementById('password').value;
            
            // Demo credential validation
            const validCredentials = [
                { email: 'admin@business.com', password: 'admin123', role: 'System Administrator' },
                { email: 'manager@business.com', password: 'manager123', role: 'Project Manager' },
                { email: 'supervisor@business.com', password: 'supervisor123', role: 'Team Supervisor' }
            ];
            
            const user = validCredentials.find(cred => cred.email === email && cred.password === password);
            
            if (user) {
                showToast(`Welcome ${user.role}! Redirecting...`, 'success');
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 1500);
            } else {
                showToast('Invalid credentials. Please try demo credentials.', 'error');
            }
        });
    </script> -->
</body>
</html>
