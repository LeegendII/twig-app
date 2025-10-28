# Vercel Deployment Guide

This guide will walk you through deploying the Ticket Management System on Vercel.

## Prerequisites

1. A Vercel account (sign up at [vercel.com](https://vercel.com))
2. Node.js installed on your local machine
3. Git installed on your local machine
4. A GitHub account (recommended for automatic deployments)

## Deployment Steps

### Option 1: Using Vercel CLI (Recommended for development)

1. **Install the Vercel CLI**
   ```bash
   npm install -g vercel
   ```

2. **Login to your Vercel account**
   ```bash
   vercel login
   ```

3. **Build the project**
   ```bash
   npm install
   npm run build
   ```

4. **Deploy to Vercel**
   ```bash
   vercel
   ```
   - Follow the prompts to set up your project
   - Choose the `dist` directory as the output directory
   - When asked about build settings, select "Other" and use the default settings

5. **Deploy to production**
   ```bash
   vercel --prod
   ```

### Option 2: Using GitHub Integration (Recommended for production)

1. **Push your code to GitHub**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/your-username/ticket-management-system.git
   git push -u origin main
   ```

2. **Import your project on Vercel**
   - Go to your Vercel dashboard
   - Click "New Project"
   - Select the GitHub repository you just created
   - Click "Import"

3. **Configure the project**
   - **Framework Preset**: Select "Other"
   - **Build Command**: `npm run build`
   - **Output Directory**: `dist`
   - **Install Command**: `npm install`

4. **Environment Variables** (Optional)
   - If you need to add environment variables, go to the "Environment Variables" section
   - Add any necessary variables (e.g., API keys, database URLs)

5. **Deploy**
   - Click "Deploy"
   - Vercel will automatically build and deploy your application

## Project Structure After Deployment

```
ticket-management-system/
├── dist/                 # Build output directory
│   ├── api/              # Serverless functions
│   │   └── index.js      # Main API handler
│   ├── assets/           # Static assets
│   │   ├── css/          # CSS files
│   │   └── js/           # JavaScript files
│   ├── index.html        # Main application file
│   ├── package.json      # Node.js dependencies
│   └── vercel.json       # Vercel configuration
├── api/                  # Source API functions
├── assets/               # Source assets
├── build.js              # Build script
├── index.html            # Source HTML
├── package.json          # Node.js dependencies
├── vercel.json           # Vercel configuration
└── DEPLOYMENT.md         # This file
```

## How the Application Works on Vercel

1. **Frontend**: The application is a single-page application (SPA) built with HTML, CSS, and JavaScript. It handles routing client-side using the URL hash.

2. **Backend**: The PHP backend has been converted to Node.js serverless functions that run on Vercel. These functions handle:
   - Authentication (login, signup, logout)
   - Ticket management (CRUD operations)
   - Session management

3. **Data Storage**: The application uses server-side sessions to store data. In a production environment, you might want to replace this with a database.

## Testing the Deployment

1. **Test all pages**:
   - Home page
   - Login page
   - Signup page
   - Dashboard (after logging in)
   - Tickets list
   - Ticket detail
   - Create ticket
   - Edit ticket

2. **Test authentication**:
   - Login with the demo credentials: `admin@example.com` / `password123`
   - Create a new account
   - Logout functionality

3. **Test ticket management**:
   - Create a new ticket
   - Edit an existing ticket
   - Delete a ticket
   - Filter tickets by status

## Troubleshooting

### Common Issues

1. **Build fails**
   - Make sure you have Node.js installed
   - Run `npm install` to install dependencies
   - Check the build logs for specific error messages

2. **API routes not working**
   - Verify that the `api` directory was copied to the `dist` directory
   - Check the Vercel function logs for errors

3. **Styling issues**
   - Verify that the `assets` directory was copied to the `dist` directory
   - Check the browser console for 404 errors

### Getting Help

If you encounter any issues during deployment:

1. Check the [Vercel documentation](https://vercel.com/docs)
2. Review the Vercel deployment logs
3. Check the browser console for JavaScript errors
4. Verify that all files were correctly built in the `dist` directory

## Customization

### Adding New Features

1. **Frontend**: Edit the `index.html` file and add new JavaScript functions
2. **Backend**: Add new routes to `api/index.js`
3. **Styling**: Modify the CSS in `index.html` or add new CSS files to the `assets/css` directory

### Connecting to a Database

To replace the session-based storage with a database:

1. Choose a database service (e.g., MongoDB Atlas, Firebase, Supabase)
2. Install the appropriate Node.js driver
3. Modify the API functions in `api/index.js` to connect to your database
4. Update the environment variables in your Vercel project settings

## Conclusion

Your Ticket Management System is now ready for deployment on Vercel. The conversion from PHP to Node.js serverless functions allows you to take advantage of Vercel's scalable serverless platform while maintaining all the functionality of the original application.