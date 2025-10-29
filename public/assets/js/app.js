// Toast notification system
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    
    toastContainer.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toastContainer.removeChild(toast);
        }, 300);
    }, 5000);
}

// Form validation
function validateForm(formElement) {
    const inputs = formElement.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showFieldError(input, 'This field is required');
            isValid = false;
        } else {
            clearFieldError(input);
        }
    });
    
    return isValid;
}

// Show field error
function showFieldError(field, message) {
    field.classList.add('is-invalid');
    
    let errorElement = field.parentNode.querySelector('.invalid-feedback');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback';
        field.parentNode.appendChild(errorElement);
    }
    
    errorElement.textContent = message;
}

// Clear field error
function clearFieldError(field) {
    field.classList.remove('is-invalid');
    
    const errorElement = field.parentNode.querySelector('.invalid-feedback');
    if (errorElement) {
        errorElement.textContent = '';
    }
}

// Clear all field errors
function clearAllFieldErrors(formElement) {
    const inputs = formElement.querySelectorAll('.is-invalid');
    inputs.forEach(input => {
        clearFieldError(input);
    });
}

// Check for session in localStorage
function checkSession() {
    const session = localStorage.getItem('ticketapp_session');
    // Only redirect if not on login/signup pages or home page
    if (!session &&
        window.location.pathname !== '/' &&
        window.location.pathname !== '/auth/login' &&
        window.location.pathname !== '/auth/signup' &&
        !window.location.pathname.includes('/auth/')) {
        window.location.href = '/auth/login';
    }
    return session ? JSON.parse(session) : null;
}

// Clear session
function clearSession() {
    localStorage.removeItem('ticketapp_session');
    window.location.href = '/';
}

// Store session
function storeSession(sessionData) {
    localStorage.setItem('ticketapp_session', JSON.stringify(sessionData));
}

// Initialize the app
document.addEventListener('DOMContentLoaded', function() {
    // Check for flash messages from server
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');
    
    if (success) {
        showToast(decodeURIComponent(success), 'success');
    }
    
    if (error) {
        showToast(decodeURIComponent(error), 'error');
    }
    
    // Add form validation to all forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
            }
        });
        
        // Clear errors on input
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                clearFieldError(input);
            });
        });
    });
    
    // Add confirmation for delete actions
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });
    
    // Mobile menu toggle (if needed)
    const menuToggle = document.getElementById('menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            const nav = document.querySelector('.nav');
            nav.classList.toggle('active');
        });
    }
});

// Helper function to format dates
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Helper function to get status badge class
function getStatusBadgeClass(status) {
    switch (status) {
        case 'open':
            return 'status-open';
        case 'in_progress':
            return 'status-in-progress';
        case 'closed':
            return 'status-closed';
        default:
            return '';
    }
}

// Helper function to format status text
function formatStatusText(status) {
    switch (status) {
        case 'in_progress':
            return 'In Progress';
        default:
            return status.charAt(0).toUpperCase() + status.slice(1);
    }
}