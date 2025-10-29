# Ticket Management System

A robust ticket management web application built with Twig, PHP, and Slim framework. This application provides a seamless user experience for managing support tickets with authentication, dashboard, and full CRUD functionality.

## Features

- **Landing Page**: Welcoming interface with hero section, wavy background, and decorative elements
- **Authentication**: Secure login and signup system with form validation
- **Dashboard**: High-level overview with ticket statistics and navigation
- **Ticket Management**: Full CRUD operations (Create, Read, Update, Delete) for tickets
- **Responsive Design**: Fully responsive across mobile, tablet, and desktop devices
- **Form Validation**: Real-time validation with user-friendly error messages
- **Session Management**: Secure session handling with localStorage

## Technologies Used

- **Backend**: PHP 7.4+
- **Framework**: Slim 4
- **Template Engine**: Twig 3
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Custom CSS with responsive design
- **Session Management**: PHP Sessions with localStorage integration

## Setup and Installation

### Prerequisites

- PHP 7.4 or higher
- Composer (PHP package manager)
- Web server (Apache, Nginx, or PHP built-in server)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ticket-management-app
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Start the development server**
   ```bash
   composer start
   ```
   This will start a PHP development server at `http://localhost:8000`

4. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

## Project Structure

```
ticket-management-app/
├── public/                 # Web root directory
│   ├── index.php          # Main application entry point
│   └── assets/            # Static assets
│       ├── css/
│       │   └── style.css  # Main stylesheet
│       └── js/
│           └── app.js     # JavaScript files
├── templates/             # Twig templates
│   ├── base.html.twig    # Base layout template
│   ├── landing.html.twig # Landing page template
│   ├── auth/             # Authentication templates
│   │   ├── login.html.twig
│   │   └── signup.html.twig
│   ├── dashboard.html.twig
│   └── tickets/          # Ticket management templates
│       ├── index.html.twig
│       ├── create.html.twig
│       └── edit.html.twig
├── src/                  # PHP source code (if needed)
├── composer.json         # PHP dependencies
└── README.md             # This file
```

## Usage

### Authentication

1. **Demo Credentials**:
   - Email: `user@example.com`
   - Password: `password`

2. **Creating a New Account**:
   - Navigate to `/auth/signup`
   - Fill in the registration form
   - After successful registration, you'll be redirected to the dashboard

3. **Login**:
   - Navigate to `/auth/login`
   - Enter your credentials
   - After successful login, you'll be redirected to the dashboard

### Dashboard

- View ticket statistics (total, open, in progress, closed)
- Quick actions for creating new tickets
- Recent activity feed
- Ticket status overview with visual progress bar

### Ticket Management

1. **Creating a Ticket**:
   - Click "Create New Ticket" from the dashboard or tickets page
   - Fill in the required fields (title and status)
   - Add optional details like description, priority, due date, etc.
   - Submit the form

2. **Viewing Tickets**:
   - Navigate to `/tickets` to see all tickets
   - Use filters to sort by status, priority, or search terms
   - Each ticket displays its ID, title, description, status, and priority

3. **Editing a Ticket**:
   - Click the "Edit" button on any ticket
   - Update the ticket details
   - Submit the form to save changes

4. **Deleting a Ticket**:
   - Click the "Delete" button on any ticket
   - Confirm the deletion in the popup dialog
   - The ticket will be permanently removed

### Form Validation

The application includes comprehensive form validation:

- **Required Fields**: Title and status are mandatory for all tickets
- **Status Validation**: Only accepts "open", "in_progress", or "closed"
- **Email Validation**: Ensures proper email format for authentication
- **Password Confirmation**: Verifies that passwords match during signup
- **Real-time Feedback**: Validation errors are displayed inline or as toast notifications

### Error Handling

The application provides consistent error handling for:

- Invalid form inputs
- Authentication failures
- Unauthorized access attempts
- Network/API call failures

Error messages are user-friendly and provide clear guidance on how to resolve issues.

## Security Features

- **Session Management**: Uses PHP sessions with localStorage for client-side checks
- **Protected Routes**: Dashboard and ticket management pages require authentication
- **CSRF Protection**: Forms include CSRF tokens (can be enhanced in production)
- **Input Validation**: All user inputs are validated and sanitized

## Responsive Design

The application is fully responsive with:

- **Mobile**: Stacked layout with collapsible navigation
- **Tablet**: Multi-column grid with consistent spacing
- **Desktop**: Full layout with max-width of 1440px, centered on larger screens

## Accessibility

- Semantic HTML5 elements
- Proper alt text for images
- Visible focus states
- Sufficient color contrast
- ARIA labels where necessary

## Browser Compatibility

The application is compatible with all modern browsers:
- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)

## Future Enhancements

Potential improvements for future versions:

- Real database integration (MySQL/PostgreSQL)
- Email notifications for ticket updates
- File attachments for tickets
- User roles and permissions
- Advanced reporting and analytics
- API endpoints for mobile app integration
- Two-factor authentication
- Ticket comments and collaboration features

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Create an issue in the GitHub repository
- Contact the development team

---

Thank you for using the Ticket Management System!