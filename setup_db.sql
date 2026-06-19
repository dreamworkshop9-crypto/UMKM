-- Create database if not exists
CREATE DATABASE IF NOT EXISTS shoesmarket;

-- Create user if not exists
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY 'laravel';

-- Grant all privileges
GRANT ALL PRIVILEGES ON shoesmarket.* TO 'laravel'@'localhost';

-- Flush privileges
FLUSH PRIVILEGES;

-- Verify
SELECT USER FROM mysql.user WHERE USER='laravel' OR USER='root';
SHOW DATABASES LIKE 'shoesmarket';
