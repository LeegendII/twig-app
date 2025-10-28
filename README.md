# Ticket Management System - Twig Implementation

This is the Twig implementation of the Ticket Management System, a web application for creating, tracking, and managing tickets.

## Features

- **Landing Page**: Welcoming page with wavy background, decorative elements, and call-to-action buttons
- **Authentication**: Secure login and signup with form validation and session management
- **Dashboard**: Overview of ticket statistics with navigation to ticket management
- **Ticket Management**: Full CRUD operations (Create, Read, Update, Delete) with validation
- **Responsive Design**: Mobile, tablet, and desktop adaptations
- **Toast Notifications**: User-friendly feedback for actions
- **Form Validation**: Client-side validation with error messages

## Project Structure

```
twig-app/
├── assets/
│   ├── css/
│   │   └── style.css         # Twig-specific styles
│   └── js/
│       └── script.js         # JavaScript utilities
├── templates/
│   ├── header.php            # Header template
│   ├── footer.php            # Footer template
│   ├── home.php              # Landing page template
│   ├── login.php             # Login page template
│   ├── signup.php            # Signup page template
│   ├── dashboard.php         # Dashboard page template
│   ├── tickets.php           # Tickets listing template
│   ├── ticket-detail.php     # Ticket detail template
│   ├── create-ticket.php     # Create ticket template
│   └── edit-ticket.php       # Edit ticket template
├── index.php                 # Main entry point and router
└── README.md                 # This file
```

## Getting Started

### Prerequisites

- PHP (v7.0 or higher)
- A web server (Apache, Nginx, etc.)
- A web browser

### Installation

1. Clone the repository
```bash
git clone <repository-url>
cd ticket-management-system/twig-app
```

2. Set up a web server to serve the `twig-app` directory

3. Access the application in your browser at the configured URL

### Usage

### Authentication

1. **Login**: Navigate to `/twig-app/index.php?route=login` and enter your credentials
   - Demo credentials: `admin@example.com` / `password123`

2. **Signup**: Navigate to `/twig-app/index.php?route=signup` to create a new account

### Dashboard

After logging in, you'll be redirected to the dashboard at `/twig-app/index.php?route=dashboard` which shows:
- Ticket statistics (total, open, in progress, closed)
- Recent tickets table
- Navigation to ticket management

### Ticket Management

Navigate to `/twig-app/index.php?route=tickets` to:
- View all tickets in a table format
- Filter tickets by status (all, open, in progress, closed)
- Create new tickets
- View ticket details
- Edit existing tickets
- Delete tickets

### Routes

- `/twig-app/index.php` or `/twig-app/index.php?route=home` - Landing page
- `/twig-app/index.php?route=login` - Login page
- `/twig-app/index.php?route=signup` - Signup page
- `/twig-app/index.php?route=dashboard` - Dashboard (protected)
- `/twig-app/index.php?route=tickets` - Ticket management (protected)
- `/twig-app/index.php?route=ticket-detail&id={id}` - Ticket details (protected)
- `/twig-app/index.php?route=create-ticket` - Create ticket (protected)
- `/twig-app/index.php?route=edit-ticket&id={id}` - Edit ticket (protected)

## Technology Stack

- **PHP** - Server-side scripting language
- **Twig-like Templates** - Template engine implementation using PHP includes
- **Session Management** - For authentication and data persistence
- **CSS Variables** - For theming and consistent design
- **JavaScript** - For client-side interactions and utilities

## State Management

This implementation uses PHP sessions for:
- User authentication
- Data persistence (tickets)

## Data Persistence

For demonstration purposes, this implementation uses PHP sessions to persist:
- User session information
- Ticket data

In a production environment, this would be replaced with a database.

## Styling

The application uses:
- Shared CSS from `../shared-assets/css/common.css`
- Twig-specific styles in `assets/css/style.css`
- CSS custom properties for consistent theming
- Responsive design with media queries

## Testing

To test the application:
1. Start your web server
2. Access the application in your browser
3. Test all features including authentication, ticket management, and responsive design

## Deployment

The `twig-app` folder can be deployed to any PHP-enabled web server:
- Apache with mod_php
- Nginx with PHP-FPM
- Shared hosting with PHP support

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](../../LICENSE) file for details.