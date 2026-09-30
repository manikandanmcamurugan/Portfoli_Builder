FROM php:8.2-apache

# Install PDO and MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite (often needed for routing in PHP apps)
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the application source code to the container
COPY . /var/www/html/

# Update permissions for the uploads directory if it exists
# (Important so PHP can upload resume/images)
RUN chmod -R 777 /var/www/html/assets/images/uploads || true

# Expose port 80 for the web server
EXPOSE 80
