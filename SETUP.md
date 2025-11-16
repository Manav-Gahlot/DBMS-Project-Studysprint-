# StudySprint - Quick Setup Guide

## Installation Steps

### 1. Install XAMPP
- Download from https://www.apachefriends.org/
- Install to `C:\xampp\` (default location)

### 2. Place Project Files
- Copy the entire `studysprint` folder to:
  ```
  C:\xampp\htdocs\studysprint\
  ```

### 3. Start XAMPP Services
- Open XAMPP Control Panel
- Start **Apache** and **MySQL**

### 4. Create Database
- Open phpMyAdmin: http://localhost/phpmyadmin
- Click **Import** tab
- Choose file: `studysprint.sql`
- Click **Go**
- Database `studysprint` will be created with tables and demo data

### 5. Configure Database (if needed)
- Open `config.php` in the project root
- Verify database settings (default XAMPP settings):
  ```php
  DB_HOST: 'localhost'
  DB_NAME: 'studysprint'
  DB_USER: 'root'
  DB_PASS: '' (empty)
  ```

### 6. Access Application
- Open browser: http://localhost/studysprint/public/
- Login with demo account:
  - Username: `john_doe`
  - Password: `demo123`

## Folder Structure
```
C:\xampp\htdocs\studysprint\
├── public/           # Public web files
├── includes/         # Core includes
├── models/           # Data models
├── controllers/      # Business logic
├── assets/           # CSS, JS, images
├── config.php        # Configuration
├── studysprint.sql   # Database schema
└── README.md         # Full documentation
```

## Common Issues

### Database Connection Error
- **Solution**: Ensure MySQL is running in XAMPP Control Panel
- Check `config.php` database credentials
- Verify database `studysprint` exists in phpMyAdmin

### 404 Page Not Found
- **Solution**: Ensure project is in `htdocs/studysprint/` folder
- Check Apache is running
- Try: http://localhost/studysprint/public/index.php

### Charts Not Loading
- **Solution**: Check browser console for errors
- Ensure internet connection (Chart.js loads from CDN)
- Verify JavaScript files are loading

### Session Issues
- **Solution**: Clear browser cookies
- Check `php.ini` session settings
- Ensure `session_start()` is called

## Demo Accounts

| Username    | Password | Email            |
|------------|----------|------------------|
| john_doe   | demo123  | john@example.com |
| jane_smith | demo123  | jane@example.com |
| alex_chen  | demo123  | alex@example.com |

## Next Steps

1. Register a new account
2. Set up study goals
3. Start a Pomodoro session
4. View your statistics
5. Check the leaderboard

## Support

For detailed documentation, see `README.md`

---

**Happy Studying! 📚**


