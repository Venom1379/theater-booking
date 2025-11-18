// Toast notification function
function showToast(message, type = 'success') {
    const toastEl = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    
    if (toastEl && toastMessage) {
        toastMessage.textContent = message;
        
        // Add color based on type
        toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning', 'text-white');
        if (type === 'success') {
            toastEl.classList.add('bg-success', 'text-white');
        } else if (type === 'error') {
            toastEl.classList.add('bg-danger', 'text-white');
        } else if (type === 'warning') {
            toastEl.classList.add('bg-warning', 'text-white');
        }
        
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
}

// Sidebar toggle for mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 992) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }
});

// Handle logout
function handleLogout() {
    showToast('Logged out successfully', 'success');
    console.log('Logout clicked');
    setTimeout(() => {
        // Redirect to login page or show login modal
    }, 1000);
}

// Handle back to website
function handleBackToWebsite() {
    console.log('Back to website clicked');
    showToast('Redirecting to website...', 'success');
}

// Settings page - General Settings Form
const generalSettingsForm = document.getElementById('generalSettingsForm');
if (generalSettingsForm) {
    // Load saved settings
    const savedGeneral = localStorage.getItem('generalSettings');
    if (savedGeneral) {
        const settings = JSON.parse(savedGeneral);
        document.getElementById('theaterName').value = settings.theaterName || '';
        document.getElementById('contactEmail').value = settings.contactEmail || '';
        document.getElementById('phoneNumber').value = settings.phoneNumber || '';
    }
    
    generalSettingsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const settings = {
            theaterName: document.getElementById('theaterName').value,
            contactEmail: document.getElementById('contactEmail').value,
            phoneNumber: document.getElementById('phoneNumber').value
        };
        
        // Validate
        if (!settings.theaterName || !settings.contactEmail || !settings.phoneNumber) {
            showToast('Please fill in all fields', 'error');
            return;
        }
        
        // Save to localStorage
        localStorage.setItem('generalSettings', JSON.stringify(settings));
        showToast('General settings saved successfully!', 'success');
        console.log('General settings saved:', settings);
    });
}

// Settings page - Booking Settings Form
const bookingSettingsForm = document.getElementById('bookingSettingsForm');
if (bookingSettingsForm) {
    // Load saved settings
    const savedBooking = localStorage.getItem('bookingSettings');
    if (savedBooking) {
        const settings = JSON.parse(savedBooking);
        document.getElementById('slot1Time').value = settings.slot1Time || '';
        document.getElementById('slot2Time').value = settings.slot2Time || '';
        document.getElementById('slot3Time').value = settings.slot3Time || '';
        document.getElementById('enableOnlineBooking').checked = settings.enableOnlineBooking !== false;
    }
    
    bookingSettingsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const settings = {
            slot1Time: document.getElementById('slot1Time').value,
            slot2Time: document.getElementById('slot2Time').value,
            slot3Time: document.getElementById('slot3Time').value,
            enableOnlineBooking: document.getElementById('enableOnlineBooking').checked
        };
        
        // Validate
        if (!settings.slot1Time || !settings.slot2Time || !settings.slot3Time) {
            showToast('Please fill in all time slots', 'error');
            return;
        }
        
        // Save to localStorage
        localStorage.setItem('bookingSettings', JSON.stringify(settings));
        showToast('Booking settings updated successfully!', 'success');
        console.log('Booking settings updated:', settings);
    });
}

// Handle export on customers page
function handleExport() {
    showToast('Exporting customer data to CSV...', 'success');
    console.log('Export customer data');
}

// Search functionality
const searchInputs = ['searchBookings', 'searchShows', 'searchCustomers'];
searchInputs.forEach(inputId => {
    const searchInput = document.getElementById(inputId);
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            console.log('Searching for:', searchTerm);
            // Implement search filtering here
        });
    }
});
