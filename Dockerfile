# Use official PHP 8.2 image with built-in web server
FROM php:8.2-cli

# Set working directory inside the container
WORKDIR /app

# Copy ALL files from your project into the container
COPY . .

# Expose Render port (Render uses dynamic ports internally, default 10000 for yours)
EXPOSE 10000

# Run PHP's built-in web server serving all PHP files
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/app"]
