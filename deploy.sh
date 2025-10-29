#!/bin/bash

# Deployment script for the Twig Ticket Management System

echo "Starting deployment process..."

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer first."
    exit 1
fi

# Install dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Create necessary directories
echo "Creating necessary directories..."
mkdir -p var/cache/twig
mkdir -p var/logs

# Set permissions
echo "Setting permissions..."
chmod -R 755 var/
chmod -R 755 public/

# Set environment to production
export APP_ENV=production

echo "Deployment completed successfully!"
echo "Make sure your web server is configured to serve the 'public' directory as the document root."