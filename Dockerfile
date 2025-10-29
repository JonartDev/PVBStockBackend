# Use official PHP 8.2 image with built-in web server
FROM php:8.2-cli

# Set working directory inside the container
WORKDIR /app

# Copy all project files into the container
COPY . /app

# Expose port 10000 for Render
EXPOSE 10000

# Start PHP's built-in server serving proxy.php
CMD ["php", "-S", "0.0.0.0:10000", "proxy.php"]
