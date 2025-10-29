const express = require('express');
const session = require('express-session');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Session configuration for Vercel
app.use(session({
  secret: 'ticket-management-secret-key',
  resave: false,
  saveUninitialized: false,
  cookie: {
    secure: process.env.NODE_ENV === 'production',
    maxAge: 24 * 60 * 60 * 1000 // 24 hours
  }
}));

// Helper functions for date formatting
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

function relativeTime(dateString) {
  const date = new Date(dateString);
  const now = new Date();
  const diffInSeconds = Math.floor((now - date) / 1000);
  
  if (diffInSeconds < 60) {
    return 'Just now';
  } else if (diffInSeconds < 3600) {
    const minutes = Math.floor(diffInSeconds / 60);
    return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
  } else if (diffInSeconds < 86400) {
    const hours = Math.floor(diffInSeconds / 3600);
    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
  } else if (diffInSeconds < 604800) {
    const days = Math.floor(diffInSeconds / 86400);
    return `${days} day${days > 1 ? 's' : ''} ago`;
  } else if (diffInSeconds < 2592000) {
    const weeks = Math.floor(diffInSeconds / 604800);
    return `${weeks} week${weeks > 1 ? 's' : ''} ago`;
  } else if (diffInSeconds < 31536000) {
    const months = Math.floor(diffInSeconds / 2592000);
    return `${months} month${months > 1 ? 's' : ''} ago`;
  } else {
    const years = Math.floor(diffInSeconds / 31536000);
    return `${years} year${years > 1 ? 's' : ''} ago`;
  }
}

// Initialize mock data
function initializeTickets(req) {
  if (!req.session.tickets) {
    req.session.tickets = [
      {
        id: 1,
        title: 'Login page not responsive',
        description: 'The login page is not displaying correctly on mobile devices',
        status: 'open',
        priority: 'high',
        createdAt: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString(),
        updatedAt: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString()
      },
      {
        id: 2,
        title: 'Dashboard statistics loading slowly',
        description: 'The dashboard is taking more than 5 seconds to load statistics',
        status: 'in_progress',
        priority: 'medium',
        createdAt: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000).toISOString(),
        updatedAt: new Date(Date.now() - 12 * 60 * 60 * 1000).toISOString()
      },
      {
        id: 3,
        title: 'User profile update issue',
        description: 'Users are unable to update their profile information',
        status: 'closed',
        priority: 'low',
        createdAt: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toISOString(),
        updatedAt: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString()
      }
    ];
  }
}

// Authentication middleware
function requireAuth(req, res, next) {
  if (!req.session.user) {
    return res.status(401).json({ error: 'Authentication required' });
  }
  next();
}

// Routes

// Auth routes
app.post('/api/auth/login', (req, res) => {
  const { email, password } = req.body;
  
  // Check for admin login
  if (email === 'admin@example.com' && password === 'password123') {
    req.session.user = {
      id: 1,
      name: 'Admin User',
      email: email
    };
    return res.json({ success: true, user: req.session.user });
  }
  
  // Check for registered users
  if (req.session.users) {
    const user = req.session.users.find(u => u.email === email && u.password === password);
    if (user) {
      req.session.user = {
        id: user.id,
        name: user.name,
        email: user.email
      };
      return res.json({ success: true, user: req.session.user });
    }
  }
  
  res.status(401).json({ error: 'Invalid email or password' });
});

app.post('/api/auth/signup', (req, res) => {
  const { name, email, password, confirmPassword } = req.body;
  
  if (!name || !email || !password || !confirmPassword) {
    return res.status(400).json({ error: 'All fields are required' });
  }
  
  if (password !== confirmPassword) {
    return res.status(400).json({ error: 'Passwords do not match' });
  }
  
  // Initialize users array if it doesn't exist
  if (!req.session.users) {
    req.session.users = [];
  }
  
  // Check if user already exists
  const existingUser = req.session.users.find(user => user.email === email);
  if (existingUser) {
    return res.status(400).json({ error: 'User with this email already exists' });
  }
  
  // Create new user
  const newUser = {
    id: Date.now(),
    name: name,
    email: email,
    password: password // In a real app, this should be hashed
  };
  
  // Add user to session
  req.session.users.push(newUser);
  req.session.user = {
    id: newUser.id,
    name: newUser.name,
    email: newUser.email
  };
  
  res.json({ success: true, user: req.session.user });
});

app.post('/api/auth/logout', (req, res) => {
  req.session.destroy();
  res.json({ success: true });
});

app.get('/api/auth/check', (req, res) => {
  if (req.session.user) {
    res.json({ authenticated: true, user: req.session.user });
  } else {
    res.json({ authenticated: false });
  }
});

// Ticket routes
app.get('/api/tickets', requireAuth, (req, res) => {
  initializeTickets(req);
  
  const filter = req.query.filter || 'all';
  let tickets = req.session.tickets;
  
  if (filter !== 'all') {
    tickets = tickets.filter(ticket => ticket.status === filter);
  }
  
  // Add formatted dates
  tickets = tickets.map(ticket => ({
    ...ticket,
    formattedCreatedAt: formatDate(ticket.createdAt),
    formattedUpdatedAt: formatDate(ticket.updatedAt),
    relativeCreatedAt: relativeTime(ticket.createdAt)
  }));
  
  res.json({ tickets });
});

app.get('/api/tickets/:id', requireAuth, (req, res) => {
  initializeTickets(req);
  
  const ticketId = parseInt(req.params.id);
  const ticket = req.session.tickets.find(t => t.id === ticketId);
  
  if (!ticket) {
    return res.status(404).json({ error: 'Ticket not found' });
  }
  
  // Add formatted dates
  const ticketWithDates = {
    ...ticket,
    formattedCreatedAt: formatDate(ticket.createdAt),
    formattedUpdatedAt: formatDate(ticket.updatedAt),
    relativeCreatedAt: relativeTime(ticket.createdAt)
  };
  
  res.json({ ticket: ticketWithDates });
});

app.post('/api/tickets', requireAuth, (req, res) => {
  initializeTickets(req);
  
  const { title, description, status = 'open', priority = 'medium' } = req.body;
  
  if (!title) {
    return res.status(400).json({ error: 'Title is required' });
  }
  
  const newTicket = {
    id: Date.now(),
    title,
    description,
    status,
    priority,
    createdAt: new Date().toISOString(),
    updatedAt: new Date().toISOString()
  };
  
  req.session.tickets.push(newTicket);
  res.json({ success: true, ticket: newTicket });
});

app.put('/api/tickets/:id', requireAuth, (req, res) => {
  initializeTickets(req);
  
  const ticketId = parseInt(req.params.id);
  const { title, description, status, priority } = req.body;
  
  if (!title) {
    return res.status(400).json({ error: 'Title is required' });
  }
  
  const ticketIndex = req.session.tickets.findIndex(t => t.id === ticketId);
  
  if (ticketIndex === -1) {
    return res.status(404).json({ error: 'Ticket not found' });
  }
  
  req.session.tickets[ticketIndex] = {
    ...req.session.tickets[ticketIndex],
    title,
    description,
    status,
    priority,
    updatedAt: new Date().toISOString()
  };
  
  res.json({ success: true, ticket: req.session.tickets[ticketIndex] });
});

app.delete('/api/tickets/:id', requireAuth, (req, res) => {
  initializeTickets(req);
  
  const ticketId = parseInt(req.params.id);
  const ticketIndex = req.session.tickets.findIndex(t => t.id === ticketId);
  
  if (ticketIndex === -1) {
    return res.status(404).json({ error: 'Ticket not found' });
  }
  
  req.session.tickets.splice(ticketIndex, 1);
  res.json({ success: true });
});

// Dashboard stats
app.get('/api/dashboard/stats', requireAuth, (req, res) => {
  initializeTickets(req);
  
  const tickets = req.session.tickets;
  const stats = {
    total: tickets.length,
    open: tickets.filter(t => t.status === 'open').length,
    inProgress: tickets.filter(t => t.status === 'in_progress').length,
    closed: tickets.filter(t => t.status === 'closed').length
  };
  
  res.json({ stats });
});

// Export for Vercel
module.exports = (req, res) => {
  // Enable CORS
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
  
  // Handle preflight requests
  if (req.method === 'OPTIONS') {
    res.status(200).end();
    return;
  }
  
  // Parse the URL to extract the path
  const url = new URL(req.url, `http://${req.headers.host}`);
  const path = url.pathname;
  
  // Route the request to the appropriate handler
  req.url = path;
  app(req, res);
};