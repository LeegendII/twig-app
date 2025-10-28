    </div>
    
    <?php if (!isset($_SESSION['user'])): ?>
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h3>Ticket Management System</h3>
                        <p>A powerful solution for tracking and managing tickets efficiently.</p>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="/twig-app/index.php">Home</a></li>
                            <li><a href="/twig-app/index.php?route=login">Login</a></li>
                            <li><a href="/twig-app/index.php?route=signup">Sign Up</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h3>Implementations</h3>
                        <ul>
                            <li><a href="/react-app">React</a></li>
                            <li><a href="/vue-app">Vue.js</a></li>
                            <li><a href="/twig-app">Twig</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; <?php echo date('Y'); ?> Ticket Management System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    <?php endif; ?>
    
    <script>
        // Utility functions for Twig app

        // Format date to readable format
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Calculate relative time (e.g., "2 hours ago")
        function relativeTime(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            // Less than a minute
            if (diffInSeconds < 60) {
                return 'Just now';
            }
            
            // Less than an hour
            if (diffInSeconds < 3600) {
                const minutes = Math.floor(diffInSeconds / 60);
                return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
            }
            
            // Less than a day
            if (diffInSeconds < 86400) {
                const hours = Math.floor(diffInSeconds / 3600);
                return `${hours} hour${hours > 1 ? 's' : ''} ago`;
            }
            
            // Less than a week
            if (diffInSeconds < 604800) {
                const days = Math.floor(diffInSeconds / 86400);
                return `${days} day${days > 1 ? 's' : ''} ago`;
            }
            
            // Less than a month
            if (diffInSeconds < 2592000) {
                const weeks = Math.floor(diffInSeconds / 604800);
                return `${weeks} week${weeks > 1 ? 's' : ''} ago`;
            }
            
            // Less than a year
            if (diffInSeconds < 31536000) {
                const months = Math.floor(diffInSeconds / 2592000);
                return `${months} month${months > 1 ? 's' : ''} ago`;
            }
            
            // More than a year
            const years = Math.floor(diffInSeconds / 31536000);
            return `${years} year${years > 1 ? 's' : ''} ago`;
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            
            const toastBody = document.createElement('div');
            toastBody.className = 'toast-body';
            toastBody.textContent = message;
            
            const toastClose = document.createElement('button');
            toastClose.className = 'toast-close';
            toastClose.innerHTML = '&times;';
            toastClose.onclick = function() {
                toast.remove();
            };
            
            toast.appendChild(toastBody);
            toast.appendChild(toastClose);
            
            document.body.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.remove();
            }, 5000);
        }

        // Confirm delete action
        function confirmDelete(message) {
            return confirm(message);
        }

        // Form validation
        function validateForm(form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            return isValid;
        }

        // Add event listeners for form validation
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!validateForm(form)) {
                        e.preventDefault();
                    }
                });
                
                // Clear validation errors on input
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        this.classList.remove('is-invalid');
                    });
                });
            });
        });

        // Initialize tooltips if any
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
            
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseenter', function() {
                    const title = this.getAttribute('title');
                    this.setAttribute('data-original-title', title);
                    this.removeAttribute('title');
                    
                    const tooltipElement = document.createElement('div');
                    tooltipElement.className = 'tooltip';
                    tooltipElement.textContent = title;
                    tooltipElement.style.position = 'absolute';
                    tooltipElement.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                    tooltipElement.style.color = 'white';
                    tooltipElement.style.padding = '5px 10px';
                    tooltipElement.style.borderRadius = '4px';
                    tooltipElement.style.fontSize = '14px';
                    tooltipElement.style.zIndex = '1000';
                    
                    document.body.appendChild(tooltipElement);
                    
                    const rect = this.getBoundingClientRect();
                    tooltipElement.style.top = `${rect.top - tooltipElement.offsetHeight - 10}px`;
                    tooltipElement.style.left = `${rect.left + rect.width / 2 - tooltipElement.offsetWidth / 2}px`;
                    
                    this.tooltipElement = tooltipElement;
                });
                
                tooltip.addEventListener('mouseleave', function() {
                    if (this.tooltipElement) {
                        this.tooltipElement.remove();
                        this.tooltipElement = null;
                    }
                    
                    const originalTitle = this.getAttribute('data-original-title');
                    if (originalTitle) {
                        this.setAttribute('title', originalTitle);
                        this.removeAttribute('data-original-title');
                    }
                });
            });
        });
    </script>
</body>
</html>