# StudySprint – Personalized Pomodoro + Progress Tracker

A complete full-stack web application designed for college students to manage study time using the Pomodoro technique and track real progress over time.

## Features

- 🎯 **Pomodoro Timer**: 25-minute work sessions with 5-minute breaks
- 📊 **Progress Tracking**: Visualize study time with Chart.js (bar, pie, line charts)
- 🎯 **Goal Management**: Set and track daily/weekly study goals
- 🏆 **Leaderboard**: Compete with friends on total study time
- 👤 **User Authentication**: Secure registration and login system
- 🌙 **Dark Mode**: Toggle between light and dark themes
- 📥 **CSV Export**: Export your study data for analysis
- 📱 **Responsive Design**: Works on desktop, tablet, and mobile devices

## Tech Stack

- **Backend**: PHP 7.4+ with PDO (Prepared Statements)
- **Database**: MySQL (via XAMPP)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **UI Framework**: Bootstrap 5
- **Charts**: Chart.js 4.4.0
- **Icons**: Bootstrap Icons
- **Notifications**: SweetAlert2

## Project Structure

```
studysprint/
├── public/                 # Public-facing files
│   ├── includes/          # Header and footer components
│   ├── index.php          # Dashboard home page
│   ├── login.php          # Login page
│   ├── register.php       # Registration page
│   ├── goals.php          # Goals management page
│   ├── stats.php          # Statistics and charts page
│   ├── leaderboard.php    # Leaderboard page
│   └── settings.php       # Settings page
├── includes/              # Core includes
│   ├── auth.php           # Authentication helpers
│   └── db.php             # Database connection
├── models/                # Data models
│   ├── User.php           # User model
│   ├── StudySession.php   # Study session model
│   ├── Goal.php           # Goal model
│   └── Leaderboard.php    # Leaderboard model
├── controllers/           # Business logic controllers
│   ├── auth_controller.php
│   ├── session_controller.php
│   ├── goal_controller.php
│   ├── settings_controller.php
│   └── leaderboard_controller.php
├── assets/                # Static assets
│   ├── css/
│   │   └── style.css      # Custom styles
│   └── js/
│       ├── main.js        # Main JavaScript utilities
│       ├── timer.js       # Pomodoro timer logic
│       ├── goals.js       # Goals management
│       └── stats.js       # Chart visualizations
├── config.php             # Application configuration
├── studysprint.sql        # Database schema
└── README.md              # This file
```

## Installation & Setup

> **📘 For detailed step-by-step instructions, see [DETAILED_SETUP_GUIDE.md](DETAILED_SETUP_GUIDE.md)**  
> **✅ For quick checklist, see [QUICK_START_CHECKLIST.md](QUICK_START_CHECKLIST.md)**  
> **📊 For visual guide, see [SETUP_VISUAL_GUIDE.md](SETUP_VISUAL_GUIDE.md)**

### Prerequisites

- **XAMPP** (or any PHP/MySQL stack)
  - PHP 7.4 or higher
  - MySQL 5.7 or higher
  - Apache web server

### Quick Setup (5 Steps)

1. **Install XAMPP**
   - Download from https://www.apachefriends.org/
   - Install to `C:\xampp\` (default)
   - Select: Apache, MySQL, PHP, phpMyAdmin

2. **Place Project Files**
   - Copy to: `C:\xampp\htdocs\studysprint\`
   - Verify folder structure exists

3. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**
   - Both should show green "Running"

4. **Create Database**
   - Open: http://localhost/phpmyadmin
   - Click "Import" → Select `studysprint.sql` → Click "Go"
   - Verify database `studysprint` created

5. **Access Application**
   - Open: http://localhost/studysprint/public/
   - Login: `john_doe` / `demo123`

### Detailed Setup Guide

For complete instructions with explanations, troubleshooting, and verification steps:
- **[DETAILED_SETUP_GUIDE.md](DETAILED_SETUP_GUIDE.md)** - Comprehensive step-by-step guide
- **[QUICK_START_CHECKLIST.md](QUICK_START_CHECKLIST.md)** - Quick reference checklist
- **[SETUP_VISUAL_GUIDE.md](SETUP_VISUAL_GUIDE.md)** - Visual flowchart and diagrams

### Configure Database (If Needed)

- Open `config.php`
- Default settings work for XAMPP:
  ```php
  define('DB_HOST', 'localhost');
  define('DB_PORT', '3307'); // Change if your MySQL uses a different port
  define('DB_NAME', 'studysprint');
  define('DB_USER', 'root');
  define('DB_PASS', ''); // Empty by default
  ```
  
**Note**: If your MySQL runs on a different port (not 3306), update `DB_PORT` in `config.php`. Common ports: 3306 (default), 3307, 3308.

## Usage Guide

### 1. Registration & Login

- Click "Register" to create a new account
- Fill in username, email, and password (minimum 6 characters)
- Login with your credentials

### 2. Pomodoro Timer

- Enter a study topic (e.g., "Mathematics - Calculus")
- Click "Start" to begin a 25-minute work session
- Timer will automatically log the session when completed
- Take a 5-minute break or continue with another session

### 3. Setting Goals

- Navigate to "My Goals" page
- Click "New Goal" to create a daily or weekly goal
- Set target minutes and topic
- Track progress as you complete study sessions

### 4. Viewing Statistics

- Go to "My Stats" page to see:
  - Daily study time (bar chart)
  - Weekly goal completion (pie chart)
  - Cumulative time trend (line chart)
  - Study time by topic (doughnut chart)
- Export your data as CSV for external analysis

### 5. Leaderboard

- View top 10 users ranked by total study time
- See your current rank and total minutes studied
- Compete with friends to stay motivated!

### 6. Settings

- Change your password
- Toggle dark mode on/off
- Logout from your account

## Security Features

- ✅ Password hashing using `password_hash()` and `password_verify()`
- ✅ SQL injection prevention with prepared statements (PDO)
- ✅ Input sanitization and validation
- ✅ Session-based authentication
- ✅ Session timeout (30 minutes of inactivity)
- ✅ XSS protection with `htmlspecialchars()`
- ✅ HTTP-only cookies for sessions

## Database Schema

### Tables

1. **users**
   - `id` (INT, PRIMARY KEY)
   - `username` (VARCHAR(50), UNIQUE)
   - `email` (VARCHAR(100), UNIQUE)
   - `password_hash` (VARCHAR(255))
   - `date_joined` (DATETIME)
   - `dark_mode` (TINYINT(1))

2. **study_sessions**
   - `id` (INT, PRIMARY KEY)
   - `user_id` (INT, FOREIGN KEY)
   - `topic` (VARCHAR(255))
   - `duration_minutes` (INT)
   - `timestamp` (DATETIME)

3. **goals**
   - `id` (INT, PRIMARY KEY)
   - `user_id` (INT, FOREIGN KEY)
   - `goal_type` (ENUM: 'daily', 'weekly')
   - `topic` (VARCHAR(255))
   - `target_minutes` (INT)
   - `progress` (INT)
   - `created_at` (DATETIME)
   - `updated_at` (DATETIME)

## Demo Accounts

The database comes with 3 demo accounts:

| Username    | Email            | Password |
|------------|------------------|----------|
| john_doe   | john@example.com | demo123  |
| jane_smith | jane@example.com | demo123  |
| alex_chen  | alex@example.com | demo123  |

## Troubleshooting

### Database Connection Error

- Ensure MySQL is running in XAMPP Control Panel
- Check database credentials in `config.php`
- Verify database `studysprint` exists in phpMyAdmin

### Page Not Found (404)

- Ensure project is in `htdocs/studysprint/` folder
- Check Apache is running
- Verify file permissions

### Charts Not Loading

- Check browser console for JavaScript errors
- Ensure Chart.js CDN is accessible
- Verify AJAX requests are returning valid JSON

### Session Issues

- Clear browser cookies and cache
- Check `php.ini` session settings
- Ensure `session_start()` is called before output

## Development Notes

### Code Structure

- **MVC-like architecture**: Separation of concerns
- **Prepared statements**: All database queries use PDO prepared statements
- **Modular code**: Reusable components and functions
- **Clean code**: Well-commented and organized

### Customization

- **Colors**: Modify CSS variables in `assets/css/style.css`
- **Timer duration**: Change in `assets/js/timer.js` (default: 25 minutes work, 5 minutes break)
- **Session timeout**: Adjust in `config.php` (default: 30 minutes)

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

This project is open source and available for educational purposes.

## Credits

- **Bootstrap 5**: UI framework
- **Chart.js**: Data visualization
- **SweetAlert2**: Beautiful alerts
- **Bootstrap Icons**: Icon library

## Future Enhancements

- [ ] Email notifications for goal reminders
- [ ] Study groups and collaboration features
- [ ] Mobile app (React Native)
- [ ] Integration with calendar apps
- [ ] Advanced analytics and insights
- [ ] Study streak tracking
- [ ] Custom Pomodoro intervals
- [ ] Study notes and flashcards

## Support

For issues or questions, please check the troubleshooting section or review the code comments for detailed explanations.

---

**Built with ❤️ for productive studying**

