<?php
session_start();

// Helper functions for date formatting
function formatDate($dateString) {
    $date = new DateTime($dateString);
    return $date->format('M j, Y, g:i A');
}

function relativeTime($dateString) {
    $date = new DateTime($dateString);
    $now = new DateTime();
    $interval = $now->diff($date);
    
    if ($interval->days == 0) {
        if ($interval->h == 0) {
            if ($interval->i == 0) {
                return 'Just now';
            }
            return $interval->i . ' minute' . ($interval->i == 1 ? '' : 's') . ' ago';
        }
        return $interval->h . ' hour' . ($interval->h == 1 ? '' : 's') . ' ago';
    } elseif ($interval->days < 7) {
        return $interval->days . ' day' . ($interval->days == 1 ? '' : 's') . ' ago';
    } elseif ($interval->days < 30) {
        $weeks = floor($interval->days / 7);
        return $weeks . ' week' . ($weeks == 1 ? '' : 's') . ' ago';
    } elseif ($interval->days < 365) {
        $months = floor($interval->days / 30);
        return $months . ' month' . ($months == 1 ? '' : 's') . ' ago';
    } else {
        $years = floor($interval->days / 365);
        return $years . ' year' . ($years == 1 ? '' : 's') . ' ago';
    }
}

// Simple router for the Twig application
$route = $_GET['route'] ?? 'home';

// Authentication check for protected routes
$protectedRoutes = ['dashboard', 'tickets', 'ticket-detail', 'create-ticket', 'edit-ticket'];
if (in_array($route, $protectedRoutes) && !isset($_SESSION['user'])) {
    // Redirect to login page if not authenticated
    header('Location: /twig-app/index.php?route=login');
    exit;
}

// Mock data for tickets
$tickets = [
    [
        'id' => 1,
        'title' => 'Login page not responsive',
        'description' => 'The login page is not displaying correctly on mobile devices',
        'status' => 'open',
        'priority' => 'high',
        'createdAt' => date('Y-m-d H:i:s', strtotime('-1 day')),
        'updatedAt' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ],
    [
        'id' => 2,
        'title' => 'Dashboard statistics loading slowly',
        'description' => 'The dashboard is taking more than 5 seconds to load statistics',
        'status' => 'in_progress',
        'priority' => 'medium',
        'createdAt' => date('Y-m-d H:i:s', strtotime('-2 days')),
        'updatedAt' => date('Y-m-d H:i:s', strtotime('-12 hours'))
    ],
    [
        'id' => 3,
        'title' => 'User profile update issue',
        'description' => 'Users are unable to update their profile information',
        'status' => 'closed',
        'priority' => 'low',
        'createdAt' => date('Y-m-d H:i:s', strtotime('-3 days')),
        'updatedAt' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ]
];

// Store tickets in session for persistence
if (!isset($_SESSION['tickets'])) {
    $_SESSION['tickets'] = $tickets;
}

// Get current ticket if viewing a specific ticket
$ticket = null;
if (($route === 'ticket-detail' || $route === 'edit-ticket') && isset($_GET['id'])) {
    $ticketId = (int)$_GET['id'];
    foreach ($_SESSION['tickets'] as $t) {
        if ($t['id'] === $ticketId) {
            $ticket = $t;
            break;
        }
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($route === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Mock authentication
        if ($email === 'admin@example.com' && $password === 'password123') {
            $_SESSION['user'] = [
                'id' => 1,
                'name' => 'Admin User',
                'email' => $email
            ];
            header('Location: /twig-app/index.php?route=dashboard');
            exit;
        } else {
            $loginError = 'Invalid email or password';
        }
    } elseif ($route === 'signup') {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        
        // Basic validation
        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            $signupError = 'All fields are required';
        } elseif ($password !== $confirmPassword) {
            $signupError = 'Passwords do not match';
        } else {
            // Mock signup
            $_SESSION['user'] = [
                'id' => time(),
                'name' => $name,
                'email' => $email
            ];
            header('Location: /twig-app/index.php?route=dashboard');
            exit;
        }
    } elseif ($route === 'logout') {
        unset($_SESSION['user']);
        header('Location: /twig-app/index.php');
        exit;
    } elseif ($route === 'create-ticket') {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'open';
        $priority = $_POST['priority'] ?? 'medium';
        
        // Basic validation
        if (empty($title)) {
            $ticketError = 'Title is required';
        } else {
            // Create new ticket
            $newTicket = [
                'id' => time(),
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'priority' => $priority,
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s')
            ];
            
            $_SESSION['tickets'][] = $newTicket;
            header('Location: /twig-app/index.php?route=tickets');
            exit;
        }
    } elseif ($route === 'update-ticket' && isset($_GET['id'])) {
        $ticketId = (int)$_GET['id'];
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $status = $_POST['status'] ?? 'open';
        $priority = $_POST['priority'] ?? 'medium';
        
        // Basic validation
        if (empty($title)) {
            $ticketError = 'Title is required';
        } else {
            // Update ticket
            foreach ($_SESSION['tickets'] as $key => $t) {
                if ($t['id'] === $ticketId) {
                    $_SESSION['tickets'][$key] = [
                        'id' => $ticketId,
                        'title' => $title,
                        'description' => $description,
                        'status' => $status,
                        'priority' => $priority,
                        'createdAt' => $t['createdAt'],
                        'updatedAt' => date('Y-m-d H:i:s')
                    ];
                    break;
                }
            }
            
            header('Location: /twig-app/index.php?route=ticket-detail&id=' . $ticketId);
            exit;
        }
    } elseif ($route === 'delete-ticket' && isset($_GET['id'])) {
        $ticketId = (int)$_GET['id'];
        
        // Delete ticket
        foreach ($_SESSION['tickets'] as $key => $t) {
            if ($t['id'] === $ticketId) {
                unset($_SESSION['tickets'][$key]);
                // Reindex array
                $_SESSION['tickets'] = array_values($_SESSION['tickets']);
                break;
            }
        }
        
        header('Location: /twig-app/index.php?route=tickets');
        exit;
    }
}

// Calculate ticket statistics
$ticketStats = [
    'total' => count($_SESSION['tickets']),
    'open' => 0,
    'inProgress' => 0,
    'closed' => 0
];

foreach ($_SESSION['tickets'] as $t) {
    if ($t['status'] === 'open') {
        $ticketStats['open']++;
    } elseif ($t['status'] === 'in_progress') {
        $ticketStats['inProgress']++;
    } elseif ($t['status'] === 'closed') {
        $ticketStats['closed']++;
    }
}

// Filter tickets
$filter = $_GET['filter'] ?? 'all';
$filteredTickets = $_SESSION['tickets'];

if ($filter !== 'all') {
    $filteredTickets = array_filter($_SESSION['tickets'], function($t) use ($filter) {
        return $t['status'] === $filter;
    });
    // Reindex array
    $filteredTickets = array_values($filteredTickets);
}

// Include the appropriate template
include 'templates/header.php';

switch ($route) {
    case 'login':
        include 'templates/login.php';
        break;
    case 'signup':
        include 'templates/signup.php';
        break;
    case 'dashboard':
        include 'templates/dashboard.php';
        break;
    case 'tickets':
        include 'templates/tickets.php';
        break;
    case 'ticket-detail':
        include 'templates/ticket-detail.php';
        break;
    case 'create-ticket':
        include 'templates/create-ticket.php';
        break;
    case 'edit-ticket':
        include 'templates/edit-ticket.php';
        break;
    default:
        include 'templates/home.php';
        break;
}

include 'templates/footer.php';