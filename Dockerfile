FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Copy all files
COPY . .

# Expose port 8080 (for Cloud Run)
EXPOSE 8080

# Use PHP's built-in server to serve the app
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
