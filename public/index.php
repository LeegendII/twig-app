<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/../vendor/autoload.php';

// Create container
$container = new Container();

// Set up Twig
$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, [
    'cache' => false, // Set to a path for production
    'debug' => true,
]);

// Add Twig to container
$container->set(Environment::class, $twig);

// Create Slim app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add middleware for session management
$app->add(function (Request $request, $handler) {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $handler->handle($request);
});

// Define routes
$app->get('/', function (Request $request, Response $response) {
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    $html = $twig->render('landing.html.twig');
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->get('/auth/login', function (Request $request, Response $response) {
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    $html = $twig->render('auth/login.html.twig', [
        'error' => $_SESSION['login_error'] ?? null,
        'formData' => $_SESSION['login_form_data'] ?? []
    ]);
    
    // Clear session data
    unset($_SESSION['login_error']);
    unset($_SESSION['login_form_data']);
    
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->post('/auth/login', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    // Simple validation
    $errors = [];
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required';
    }
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required';
    }
    
    if (!empty($errors)) {
        $_SESSION['login_error'] = $errors;
        $_SESSION['login_form_data'] = $data;
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    // Mock authentication - in a real app, you'd check against a database
    if ($data['email'] === 'user@example.com' && $data['password'] === 'password') {
        $_SESSION['ticketapp_session'] = [
            'user_id' => 1,
            'email' => $data['email'],
            'name' => 'Test User'
        ];
        return $response->withHeader('Location', '/dashboard')->withStatus(302);
    }
    
    $_SESSION['login_error'] = ['form' => 'Invalid email or password'];
    $_SESSION['login_form_data'] = $data;
    return $response->withHeader('Location', '/auth/login')->withStatus(302);
});

$app->get('/auth/signup', function (Request $request, Response $response) {
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    $html = $twig->render('auth/signup.html.twig', [
        'error' => $_SESSION['signup_error'] ?? null,
        'formData' => $_SESSION['signup_form_data'] ?? []
    ]);
    
    // Clear session data
    unset($_SESSION['signup_error']);
    unset($_SESSION['signup_form_data']);
    
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->post('/auth/signup', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    // Simple validation
    $errors = [];
    if (empty($data['name'])) {
        $errors['name'] = 'Name is required';
    }
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required';
    }
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required';
    }
    if ($data['password'] !== $data['confirm_password']) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    if (!empty($errors)) {
        $_SESSION['signup_error'] = $errors;
        $_SESSION['signup_form_data'] = $data;
        return $response->withHeader('Location', '/auth/signup')->withStatus(302);
    }
    
    // Mock user creation - in a real app, you'd save to a database
    $_SESSION['ticketapp_session'] = [
        'user_id' => rand(2, 1000),
        'email' => $data['email'],
        'name' => $data['name']
    ];
    
    return $response->withHeader('Location', '/dashboard')->withStatus(302);
});

$app->get('/dashboard', function (Request $request, Response $response) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    // Mock ticket data
    $tickets = [
        ['id' => 1, 'title' => 'Login issue', 'status' => 'open'],
        ['id' => 2, 'title' => 'Payment processing error', 'status' => 'in_progress'],
        ['id' => 3, 'title' => 'UI glitch on mobile', 'status' => 'closed'],
        ['id' => 4, 'title' => 'Database connection timeout', 'status' => 'open'],
        ['id' => 5, 'title' => 'Email notification not working', 'status' => 'in_progress']
    ];
    
    // Calculate statistics
    $totalTickets = count($tickets);
    $openTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'open'));
    $inProgressTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'in_progress'));
    $closedTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'closed'));
    
    $html = $twig->render('dashboard.html.twig', [
        'user' => $_SESSION['ticketapp_session'],
        'stats' => [
            'total' => $totalTickets,
            'open' => $openTickets,
            'in_progress' => $inProgressTickets,
            'closed' => $closedTickets
        ]
    ]);
    
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->get('/tickets', function (Request $request, Response $response) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    // Mock ticket data
    $tickets = [
        ['id' => 1, 'title' => 'Login issue', 'description' => 'Users unable to login with valid credentials', 'status' => 'open', 'priority' => 'high'],
        ['id' => 2, 'title' => 'Payment processing error', 'description' => 'Payment gateway returning error codes', 'status' => 'in_progress', 'priority' => 'high'],
        ['id' => 3, 'title' => 'UI glitch on mobile', 'description' => 'Mobile layout breaks on smaller screens', 'status' => 'closed', 'priority' => 'medium'],
        ['id' => 4, 'title' => 'Database connection timeout', 'description' => 'Database connections timing out after 30 seconds', 'status' => 'open', 'priority' => 'high'],
        ['id' => 5, 'title' => 'Email notification not working', 'description' => 'System not sending email notifications to users', 'status' => 'in_progress', 'priority' => 'medium']
    ];
    
    $html = $twig->render('tickets/index.html.twig', [
        'user' => $_SESSION['ticketapp_session'],
        'tickets' => $tickets,
        'success' => $_SESSION['success_message'] ?? null,
        'error' => $_SESSION['error_message'] ?? null
    ]);
    
    // Clear session messages
    unset($_SESSION['success_message']);
    unset($_SESSION['error_message']);
    
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->get('/tickets/create', function (Request $request, Response $response) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    $html = $twig->render('tickets/create.html.twig', [
        'user' => $_SESSION['ticketapp_session'],
        'error' => $_SESSION['ticket_error'] ?? null,
        'formData' => $_SESSION['ticket_form_data'] ?? []
    ]);
    
    // Clear session data
    unset($_SESSION['ticket_error']);
    unset($_SESSION['ticket_form_data']);
    
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->post('/tickets', function (Request $request, Response $response) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    $data = $request->getParsedBody();
    
    // Validation
    $errors = [];
    if (empty($data['title'])) {
        $errors['title'] = 'Title is required';
    }
    if (empty($data['status']) || !in_array($data['status'], ['open', 'in_progress', 'closed'])) {
        $errors['status'] = 'Status is required and must be one of: open, in_progress, closed';
    }
    
    if (!empty($errors)) {
        $_SESSION['ticket_error'] = $errors;
        $_SESSION['ticket_form_data'] = $data;
        return $response->withHeader('Location', '/tickets/create')->withStatus(302);
    }
    
    // Mock ticket creation - in a real app, you'd save to a database
    $_SESSION['success_message'] = 'Ticket created successfully';
    return $response->withHeader('Location', '/tickets')->withStatus(302);
});

$app->get('/tickets/{id}/edit', function (Request $request, Response $response, array $args) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    /** @var Environment $twig */
    $twig = $this->get(Environment::class);
    
    // Mock ticket data - in a real app, you'd fetch from database
    $ticketId = (int)$args['id'];
    $ticket = [
        'id' => $ticketId,
        'title' => 'Sample Ticket ' . $ticketId,
        'description' => 'This is a sample ticket description',
        'status' => 'open',
        'priority' => 'medium'
    ];
    
    $html = $twig->render('tickets/edit.html.twig', [
        'user' => $_SESSION['ticketapp_session'],
        'ticket' => $ticket,
        'error' => $_SESSION['ticket_error'] ?? null,
        'formData' => $_SESSION['ticket_form_data'] ?? $ticket
    ]);
    
    // Clear session data
    unset($_SESSION['ticket_error']);
    unset($_SESSION['ticket_form_data']);
    
    $response->getBody()->write($html);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->post('/tickets/{id}', function (Request $request, Response $response, array $args) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    $data = $request->getParsedBody();
    
    // Validation
    $errors = [];
    if (empty($data['title'])) {
        $errors['title'] = 'Title is required';
    }
    if (empty($data['status']) || !in_array($data['status'], ['open', 'in_progress', 'closed'])) {
        $errors['status'] = 'Status is required and must be one of: open, in_progress, closed';
    }
    
    if (!empty($errors)) {
        $_SESSION['ticket_error'] = $errors;
        $_SESSION['ticket_form_data'] = $data;
        return $response->withHeader('Location', '/tickets/' . $args['id'] . '/edit')->withStatus(302);
    }
    
    // Mock ticket update - in a real app, you'd update in database
    $_SESSION['success_message'] = 'Ticket updated successfully';
    return $response->withHeader('Location', '/tickets')->withStatus(302);
});

$app->post('/tickets/{id}/delete', function (Request $request, Response $response, array $args) {
    // Check if user is logged in
    if (!isset($_SESSION['ticketapp_session'])) {
        return $response->withHeader('Location', '/auth/login')->withStatus(302);
    }
    
    // Mock ticket deletion - in a real app, you'd delete from database
    $_SESSION['success_message'] = 'Ticket deleted successfully';
    return $response->withHeader('Location', '/tickets')->withStatus(302);
});

$app->post('/logout', function (Request $request, Response $response) {
    // Clear session
    unset($_SESSION['ticketapp_session']);
    return $response->withHeader('Location', '/')->withStatus(302);
});

$app->run();