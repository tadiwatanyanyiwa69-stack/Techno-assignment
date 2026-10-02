# HIT Connect

A PHP + MySQL campus community platform designed to run locally with XAMPP and VS Code.

## Requirements
- XAMPP (Apache + MySQL)
- PHP 8+
- MySQL/MariaDB
- VS Code

## Installation
1. Copy this folder to `C:\xampp\htdocs\hit-connect`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin: `http://localhost/phpmyadmin/`.
4. Import `database/hit_connect.sql`.
5. Check `config/database.php`. Default XAMPP MySQL settings are root with an empty password.
6. Open `http://localhost/hit-connect/`.

## Main modules
- Registration/login
- Social feed
- Posts and images
- Marketplace
- Skills directory
- Campus Connect
- Private messaging
- User profiles
- Reviews
- Admin dashboard
- Image upload validation

## Email
`config/mail.php` contains placeholders for SMTP. Confirm the official HIT SMTP hostname, port, encryption and account credentials before enabling email sending. The `.hit.ac.zw` domain alone does not prove the SMTP hostname.

## Production notes
Before public deployment, add CSRF tokens to every state-changing form, stronger authorization checks, rate limiting, email verification, password reset, moderation workflows, transaction verification for reviews, and HTTPS.
