# StudySprint - Detailed Step-by-Step Setup Guide

This guide will walk you through setting up StudySprint on your Windows computer using XAMPP. Each step is explained in detail so you understand what you're doing and why.

---

## Prerequisites

Before starting, make sure you have:
- A Windows computer (Windows 10 or later recommended)
- Administrator privileges (for installing XAMPP)
- Internet connection (for downloading XAMPP and CDN resources)
- A modern web browser (Chrome, Firefox, Edge, or Safari)

---

## Step 1: Download and Install XAMPP

### What is XAMPP?
XAMPP is a free, open-source web server solution stack that includes:
- **Apache** - Web server that runs PHP files
- **MySQL** - Database server for storing data
- **PHP** - Programming language for the backend
- **phpMyAdmin** - Web interface for managing databases

### Instructions:

1. **Download XAMPP**
   - Go to: https://www.apachefriends.org/download.html
   - Click "Download" for the latest Windows version (PHP 7.4 or 8.x)
   - Choose the installer version (not ZIP)
   - The file will be named something like `xampp-windows-x64-8.x.x-installer.exe`

2. **Run the Installer**
   - Double-click the downloaded file
   - If Windows asks for permission, click "Yes"
   - Click "Next" on the welcome screen

3. **Select Components**
   - Make sure these are checked:
     - ✅ Apache (Web Server)
     - ✅ MySQL (Database)
     - ✅ PHP
     - ✅ phpMyAdmin
   - You can uncheck other components if you don't need them
   - Click "Next"

4. **Choose Installation Location**
   - Default location: `C:\xampp\`
   - **Important**: Keep the default location unless you have a specific reason to change it
   - Click "Next"

5. **Complete Installation**
   - Uncheck "Learn more about Bitnami" (optional)
   - Click "Next"
   - Click "Finish"
   - **Do NOT** start XAMPP Control Panel yet (we'll do that in the next step)

### Why This Step?
XAMPP provides the server environment needed to run PHP applications. Without it, your computer can't execute PHP code or run a MySQL database.

---

## Step 2: Verify Project Files Location

### What We're Checking:
We need to make sure the StudySprint project files are in the correct location where XAMPP can access them.

### Instructions:

1. **Navigate to XAMPP htdocs Folder**
   - Open File Explorer (Windows key + E)
   - Go to: `C:\xampp\htdocs\`
   - This folder is where all web projects go

2. **Check Your Project Location**
   - Look for a folder named `studysprint` in `C:\xampp\htdocs\`
   - If the folder exists, skip to Step 3
   - If the folder doesn't exist, continue below

3. **Move Project Files (if needed)**
   - If your project is in a different location (like `Desktop\cursor proj`):
     - Copy the entire `studysprint` folder (or all project files)
     - Paste it into `C:\xampp\htdocs\`
     - Rename it to `studysprint` if it has a different name
   - **Final location should be**: `C:\xampp\htdocs\studysprint\`

4. **Verify Folder Structure**
   - Open `C:\xampp\htdocs\studysprint\`
   - You should see these folders:
     - `public/`
     - `includes/`
     - `models/`
     - `controllers/`
     - `assets/`
   - And these files:
     - `config.php`
     - `studysprint.sql`
     - `README.md`

### Why This Step?
XAMPP's Apache server looks for web files in the `htdocs` folder. By placing the project there, Apache can serve the PHP files to your browser.

---

## Step 3: Start XAMPP Services

### What We're Starting:
- **Apache** - Runs the web server
- **MySQL** - Runs the database server

### Instructions:

1. **Open XAMPP Control Panel**
   - Click Windows Start menu
   - Search for "XAMPP Control Panel"
   - Click on it (or run as Administrator if needed)

2. **Start Apache**
   - Find "Apache" in the list
   - Click the "Start" button next to it
   - Wait until the status turns green
   - You should see "Running" in green text
   - If you see an error, see "Troubleshooting" section below

3. **Start MySQL**
   - Find "MySQL" in the list
   - Click the "Start" button next to it
   - Wait until the status turns green
   - You should see "Running" in green text

4. **Verify Services are Running**
   - Both Apache and MySQL should show green "Running" status
   - Port numbers should appear (usually 80 for Apache, 3306 for MySQL)
   - If ports are in use, you'll see a warning (usually okay)

### Why This Step?
- **Apache** must be running to execute PHP files and serve web pages
- **MySQL** must be running to store and retrieve data from the database

### Troubleshooting:
- **Port 80 or 3306 already in use**: Another program is using these ports. You can:
  - Close the other program
  - Or change XAMPP ports (advanced, see XAMPP documentation)
- **Apache won't start**: Check if port 80 is free or if another web server is running
- **MySQL won't start**: Check if port 3306 is free or if another database is running

---

## Step 4: Create the Database

### What is a Database?
A database is like a digital filing cabinet that stores all the application's data:
- User accounts
- Study sessions
- Goals
- Settings

### Instructions:

1. **Open phpMyAdmin**
   - Open your web browser
   - Go to: http://localhost/phpmyadmin
   - You should see the phpMyAdmin interface
   - If you see an error, make sure Apache and MySQL are running

2. **Import the Database Schema**
   - Click on the "Import" tab at the top
   - Click "Choose File" or "Browse" button
   - Navigate to: `C:\xampp\htdocs\studysprint\studysprint.sql`
   - Select the file and click "Open"
   - Scroll down and click the "Go" button at the bottom

3. **Verify Database Creation**
   - Wait for the import to complete (should take a few seconds)
   - You should see a success message: "Import has been successfully finished"
   - Look at the left sidebar - you should see a database named `studysprint`
   - Click on `studysprint` to expand it
   - You should see 3 tables:
     - `users`
     - `study_sessions`
     - `goals`

4. **Verify Demo Data**
   - Click on the `users` table
   - Click "Browse" tab
   - You should see 3 demo users:
     - john_doe
     - jane_smith
     - alex_chen
   - All have the password: `demo123`

### Why This Step?
The database schema file (`studysprint.sql`) contains:
- Table structures (how data is organized)
- Relationships between tables
- Demo data for testing
- Indexes for faster queries

Without importing this file, the application won't have anywhere to store data.

### What Was Created?
- **users table**: Stores user accounts (username, email, password, settings)
- **study_sessions table**: Stores study session records (topic, duration, timestamp)
- **goals table**: Stores user goals (daily/weekly targets, progress)

---

## Step 5: Configure Database Connection (If Needed)

### What We're Checking:
The application needs to know how to connect to the database. By default, XAMPP uses:
- Host: `localhost`
- Username: `root`
- Password: (empty)

### Instructions:

1. **Open config.php**
   - Navigate to: `C:\xampp\htdocs\studysprint\config.php`
   - Right-click and choose "Open with" → "Notepad" or any text editor

2. **Verify Database Settings**
   - Look for these lines:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_PORT', '3307'); // MySQL port (default: 3306, change if your MySQL uses a different port)
     define('DB_NAME', 'studysprint');
     define('DB_USER', 'root');
     define('DB_PASS', ''); // Default XAMPP password (empty)
     ```

3. **Configure Your Settings**
   - **DB_PORT**: Change to your MySQL port number
     - Default MySQL port is 3306
     - If your MySQL uses port 3307 (like yours), keep it as '3307'
     - If your MySQL uses port 3306, change it to '3306' or remove the port from the DSN
   - **DB_PASS**: If you set a MySQL password during XAMPP setup, change this to your password
   - Save the file after making changes

### Why This Step?
The `config.php` file tells the application:
- Where the database is located (`localhost`)
- Which database to use (`studysprint`)
- What credentials to use (`root` with no password by default)

If these settings are wrong, the application can't connect to the database.

---

## Step 6: Test Database Connection

### What We're Testing:
We want to make sure the application can successfully connect to the database.

### Instructions:

1. **Create a Test File (Optional)**
   - In `C:\xampp\htdocs\studysprint\`, create a file named `test_db.php`
   - Open it in a text editor
   - Paste this code:
     ```php
     <?php
     require_once 'config.php';
     require_once 'includes/db.php';
     
     try {
         $db = getDB();
         echo "✅ Database connection successful!<br>";
         echo "Database: " . DB_NAME . "<br>";
         echo "Host: " . DB_HOST . "<br>";
         if (defined('DB_PORT')) {
             echo "Port: " . DB_PORT . "<br>";
         }
     } catch (Exception $e) {
         echo "❌ Database connection failed: " . $e->getMessage();
         echo "<br><br>Check your config.php settings:<br>";
         echo "- DB_HOST: " . DB_HOST . "<br>";
         if (defined('DB_PORT')) {
             echo "- DB_PORT: " . DB_PORT . "<br>";
         }
         echo "- DB_NAME: " . DB_NAME . "<br>";
         echo "- DB_USER: " . DB_USER . "<br>";
     }
     ?>
     ```
   - Save the file

2. **Test the Connection**
   - Open your browser
   - Go to: http://localhost/studysprint/test_db.php
   - You should see: "✅ Database connection successful!"
   - If you see an error, check your `config.php` settings

3. **Delete Test File (Optional)**
   - After confirming it works, you can delete `test_db.php` for security

### Why This Step?
This verifies that:
- PHP can connect to MySQL
- Database credentials are correct
- The database exists and is accessible

---

## Step 7: Access the Application

### What We're Doing:
Opening the StudySprint application in your web browser for the first time.

### Instructions:

1. **Open Your Web Browser**
   - Use Chrome, Firefox, Edge, or any modern browser
   - Make sure Apache is still running in XAMPP Control Panel

2. **Navigate to the Application**
   - Type in the address bar: `http://localhost/studysprint/public/`
   - Press Enter
   - You should see the login page

3. **Alternative URLs to Try**
   - If the above doesn't work, try:
     - `http://localhost/studysprint/public/index.php`
     - `http://127.0.0.1/studysprint/public/`

4. **What You Should See**
   - A login page with:
     - "Welcome to StudySprint" heading
     - Username/email input field
     - Password input field
     - Login button
     - Link to register page
     - Demo user information

### Why This Step?
This confirms that:
- Apache is serving PHP files correctly
- The application files are in the right location
- PHP is processing the code
- The web server is working

### If You See an Error:
- **404 Not Found**: Check that the folder is named `studysprint` in `htdocs`
- **500 Internal Server Error**: Check Apache error log in XAMPP
- **Database Connection Error**: Go back to Step 5 and verify database settings
- **Blank Page**: Check PHP error log or enable error display in `config.php`

---

## Step 8: Login with Demo Account

### What We're Doing:
Testing the application by logging in with a pre-configured demo account.

### Instructions:

1. **On the Login Page**
   - You should see demo account information displayed
   - If not, use these credentials:
     - **Username**: `john_doe`
     - **Password**: `demo123`

2. **Enter Credentials**
   - Type `john_doe` in the username/email field
   - Type `demo123` in the password field
   - Click "Login" button

3. **You Should Be Redirected**
   - After clicking login, you should see the dashboard
   - The dashboard shows:
     - Welcome message
     - Pomodoro timer
     - Daily goals section
     - Recent study sessions

4. **Verify Everything Works**
   - Check that the navigation menu appears at the top
   - Try clicking different menu items:
     - Home
     - My Goals
     - My Stats
     - Leaderboard
     - Settings

### Why This Step?
This confirms that:
- User authentication is working
- Database queries are functioning
- Sessions are being created
- The application is fully operational

### If Login Fails:
- Check that the database was imported correctly (Step 4)
- Verify demo users exist in phpMyAdmin
- Check browser console for JavaScript errors
- Check Apache error log for PHP errors

---

## Step 9: Explore the Application

### What We're Doing:
Familiarizing yourself with all the features of StudySprint.

### Instructions:

1. **Test the Pomodoro Timer**
   - On the dashboard (Home page)
   - Enter a study topic (e.g., "Mathematics - Calculus")
   - Click "Start" button
   - Watch the timer count down from 25:00
   - Let it complete or click "Reset" to stop
   - When completed, the session should be logged automatically

2. **Create a Goal**
   - Click "My Goals" in the navigation
   - Click "New Goal" button
   - Fill in the form:
     - Goal Type: Daily or Weekly
     - Topic: e.g., "Mathematics"
     - Target Minutes: e.g., 120
   - Click "Save Goal"
   - You should see your goal appear with a progress bar

3. **View Statistics**
   - Click "My Stats" in the navigation
   - You should see charts:
     - Daily study time (bar chart)
     - Weekly goal completion (pie chart)
     - Cumulative time trend (line chart)
     - Study time by topic (doughnut chart)
   - If you just started, charts may be empty (normal)

4. **Check Leaderboard**
   - Click "Leaderboard" in the navigation
   - You should see top 10 users ranked by study time
   - Your current rank and total time should be displayed

5. **Test Settings**
   - Click on your username in the top right
   - Click "Settings"
   - Try changing your password
   - Try toggling dark mode
   - Changes should be saved

6. **Test Dark Mode**
   - Click the moon/sun icon in the navigation
   - The page should switch between light and dark themes
   - Refresh the page - your preference should be saved

### Why This Step?
This helps you understand:
- How each feature works
- What the application can do
- How to use it effectively
- If everything is functioning correctly

---

## Step 10: Register a New Account (Optional)

### What We're Doing:
Creating your own user account instead of using the demo account.

### Instructions:

1. **Logout from Demo Account**
   - Click on your username in the top right
   - Click "Logout"

2. **Go to Registration Page**
   - Click "Register here" link on the login page
   - Or go to: `http://localhost/studysprint/public/register.php`

3. **Fill in Registration Form**
   - **Username**: Choose a unique username (e.g., "student123")
   - **Email**: Enter a valid email (e.g., "student@example.com")
   - **Password**: Enter a password (minimum 6 characters)
   - **Confirm Password**: Enter the same password again
   - Click "Register" button

4. **Login with New Account**
   - After registration, you'll be redirected to login page
   - Login with your new credentials
   - You should see an empty dashboard (normal for new accounts)

5. **Start Using the Application**
   - Create some goals
   - Start study sessions
   - Track your progress
   - Build up your statistics

### Why This Step?
This allows you to:
- Have your own account
- Start fresh with no demo data
- Experience the full registration process
- Build your own study data

---

## Step 11: Verify All Features Work

### What We're Testing:
Making sure every feature of the application works correctly.

### Checklist:

- [ ] **Authentication**
  - [ ] Can register new account
  - [ ] Can login with credentials
  - [ ] Can logout
  - [ ] Session persists after page refresh
  - [ ] Cannot access pages without login

- [ ] **Pomodoro Timer**
  - [ ] Timer starts and counts down
  - [ ] Can pause timer
  - [ ] Can reset timer
  - [ ] Session logs when completed
  - [ ] Break timer works after work session

- [ ] **Goals Management**
  - [ ] Can create new goal
  - [ ] Can edit existing goal
  - [ ] Can delete goal
  - [ ] Progress bars display correctly
  - [ ] Goals show on dashboard

- [ ] **Statistics**
  - [ ] Charts load and display
  - [ ] Daily time chart shows data
  - [ ] Weekly goal chart shows data
  - [ ] Cumulative chart shows trend
  - [ ] Topic distribution chart works
  - [ ] CSV export downloads file

- [ ] **Leaderboard**
  - [ ] Top users display correctly
  - [ ] User rank shows correctly
  - [ ] Total time displays correctly
  - [ ] Rankings update when sessions logged

- [ ] **Settings**
  - [ ] Can change password
  - [ ] Dark mode toggles
  - [ ] Dark mode preference saves
  - [ ] Settings persist after logout/login

- [ ] **UI/UX**
  - [ ] Navigation works on all pages
  - [ ] Responsive on mobile devices
  - [ ] Flash messages appear
  - [ ] Loading states work
  - [ ] Forms validate correctly

### Why This Step?
This ensures:
- Everything works as expected
- No bugs or errors
- Good user experience
- Production readiness

---

## Step 12: Troubleshooting Common Issues

### Issue: Apache Won't Start

**Symptoms:**
- XAMPP shows Apache as "Stopped"
- Error message about port 80

**Solutions:**
1. Check if another program is using port 80:
   - Skype sometimes uses port 80
   - Other web servers (IIS) use port 80
   - Close these programs

2. Change Apache port:
   - Open XAMPP Control Panel
   - Click "Config" next to Apache
   - Click "httpd.conf"
   - Find "Listen 80" and change to "Listen 8080"
   - Save and restart Apache
   - Access app at: `http://localhost:8080/studysprint/public/`

### Issue: MySQL Won't Start

**Symptoms:**
- XAMPP shows MySQL as "Stopped"
- Error message about port 3306

**Solutions:**
1. Check if another database is running
2. Check XAMPP MySQL error log
3. Try restarting your computer
4. Reinstall XAMPP if problem persists

### Issue: Database Connection Error

**Symptoms:**
- Error message: "Database connection failed"
- Blank page or error on login
- "Access denied" or "Connection refused" errors

**Solutions:**
1. Verify MySQL is running in XAMPP Control Panel
2. **Check MySQL Port:**
   - Look at XAMPP Control Panel - MySQL should show the port number (e.g., 3306, 3307)
   - Open `config.php` and verify `DB_PORT` matches your MySQL port
   - If MySQL uses port 3307, set: `define('DB_PORT', '3307');`
   - If MySQL uses port 3306, set: `define('DB_PORT', '3306');` or remove the port line
3. Check `config.php` database settings:
   - **DB_HOST**: Should be `localhost`
   - **DB_PORT**: Must match your MySQL port (check XAMPP Control Panel)
   - **DB_NAME**: Should be `studysprint`
   - **DB_USER**: Should be `root`
   - **DB_PASS**: Should be empty `''` unless you set a password
4. Verify database `studysprint` exists in phpMyAdmin
5. Test connection using `test_db.php` (see Step 6)
6. Check MySQL error log in XAMPP for more details

### Issue: 404 Page Not Found

**Symptoms:**
- Browser shows "404 Not Found"
- Cannot access application

**Solutions:**
1. Verify project is in `C:\xampp\htdocs\studysprint\`
2. Check folder name is exactly `studysprint`
3. Try accessing: `http://localhost/studysprint/public/index.php`
4. Check Apache is running

### Issue: Charts Not Loading

**Symptoms:**
- Charts don't appear on stats page
- Blank spaces where charts should be

**Solutions:**
1. Check internet connection (Chart.js loads from CDN)
2. Check browser console for JavaScript errors
3. Verify JavaScript files are loading
4. Try refreshing the page

### Issue: Session Not Persisting

**Symptoms:**
- Logged out after page refresh
- Cannot stay logged in

**Solutions:**
1. Check browser cookies are enabled
2. Clear browser cache and cookies
3. Try a different browser
4. Check `config.php` session settings

### Issue: Password Hash Not Working

**Symptoms:**
- Cannot login with demo accounts
- "Invalid password" error

**Solutions:**
1. Register a new account (recommended)
2. Or update password hash in database:
   - Go to phpMyAdmin
   - Open `users` table
   - Edit a user's `password_hash`
   - Generate new hash using PHP:
     ```php
     <?php echo password_hash('demo123', PASSWORD_DEFAULT); ?>
     ```

---

## Step 13: Understanding the File Structure

### Why This Matters:
Understanding the file structure helps you:
- Know where to make changes
- Debug issues
- Add new features
- Maintain the code

### File Structure Explained:

```
studysprint/
│
├── public/                    # Public web files (accessible via browser)
│   ├── includes/             # Reusable components
│   │   ├── header.php       # Navigation and page header
│   │   └── footer.php       # Page footer and scripts
│   ├── index.php            # Dashboard (main page)
│   ├── login.php            # Login page
│   ├── register.php         # Registration page
│   ├── goals.php            # Goals management page
│   ├── stats.php            # Statistics and charts page
│   ├── leaderboard.php      # Leaderboard page
│   └── settings.php         # Settings page
│
├── includes/                 # Core PHP includes
│   ├── auth.php             # Authentication functions
│   └── db.php               # Database connection
│
├── models/                   # Data models (database interactions)
│   ├── User.php             # User operations
│   ├── StudySession.php     # Study session operations
│   ├── Goal.php             # Goal operations
│   └── Leaderboard.php      # Leaderboard operations
│
├── controllers/              # Business logic
│   ├── auth_controller.php  # Handle login/register/logout
│   ├── session_controller.php # Handle study sessions
│   ├── goal_controller.php  # Handle goals CRUD
│   ├── settings_controller.php # Handle settings
│   └── leaderboard_controller.php # Handle leaderboard
│
├── assets/                   # Static files
│   ├── css/
│   │   └── style.css        # Custom styles
│   ├── js/
│   │   ├── main.js          # Main JavaScript
│   │   ├── timer.js         # Pomodoro timer
│   │   ├── goals.js         # Goals management
│   │   └── stats.js         # Charts and statistics
│   └── images/              # Image files
│
├── config.php                # Configuration file
├── studysprint.sql          # Database schema
├── README.md                # Documentation
├── SETUP.md                 # Quick setup guide
└── DETAILED_SETUP_GUIDE.md  # This file
```

### Key Files Explained:

- **config.php**: Database credentials and app settings
- **studysprint.sql**: Database structure and demo data
- **public/index.php**: Main dashboard page
- **includes/auth.php**: Functions for login/logout/sessions
- **includes/db.php**: Database connection function
- **models/**: Classes that interact with database
- **controllers/**: Handle form submissions and AJAX requests
- **assets/**: CSS and JavaScript files

---

## Step 14: Making Changes and Customizing

### How to Customize:

1. **Change Colors**
   - Edit: `assets/css/style.css`
   - Look for CSS variables at the top
   - Change color values to your preference

2. **Modify Timer Duration**
   - Edit: `assets/js/timer.js`
   - Find: `let timeLeft = 25 * 60;` (25 minutes)
   - Change to your preferred duration

3. **Add New Features**
   - Add new PHP files in `public/`
   - Create new models in `models/`
   - Add new controllers in `controllers/`
   - Update navigation in `public/includes/header.php`

4. **Change Database Settings**
   - Edit: `config.php`
   - Modify database credentials
   - Change session timeout
   - Update base URL if needed

### Best Practices:

- Always backup files before making changes
- Test changes in a browser
- Check for errors in browser console
- Check Apache error logs for PHP errors
- Use version control (Git) for tracking changes

---

## Step 15: Daily Usage

### Starting the Application Each Time:

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache
   - Start MySQL
   - Keep XAMPP running while using the app

2. **Access the Application**
   - Open browser
   - Go to: `http://localhost/studysprint/public/`
   - Login with your credentials

3. **Using the Application**
   - Set daily/weekly goals
   - Start Pomodoro timer for study sessions
   - Track your progress
   - Check leaderboard
   - Export data as needed

4. **Stopping the Application**
   - Close browser tabs
   - Stop Apache and MySQL in XAMPP (optional)
   - Close XAMPP Control Panel

### Tips for Best Experience:

- Keep XAMPP running while studying
- Set realistic study goals
- Use the Pomodoro technique effectively
- Review your statistics regularly
- Compete with friends on the leaderboard
- Export your data periodically as backup

---

## Summary

You have successfully set up StudySprint! Here's what you accomplished:

✅ Installed XAMPP (Apache, MySQL, PHP)  
✅ Placed project files in correct location  
✅ Started web server and database  
✅ Created database and imported schema  
✅ Configured database connection  
✅ Accessed the application in browser  
✅ Logged in with demo account  
✅ Tested all features  
✅ Registered your own account  

### Next Steps:

1. **Start Studying!**
   - Set your study goals
   - Use the Pomodoro timer
   - Track your progress

2. **Explore Features**
   - Try all the features
   - Customize settings
   - Check your statistics

3. **Invite Friends**
   - Have friends register accounts
   - Compete on the leaderboard
   - Motivate each other

4. **Customize**
   - Modify colors and styles
   - Add new features
   - Adapt to your needs

### Need Help?

- Check `README.md` for detailed documentation
- Check `SETUP.md` for quick reference
- Review error logs in XAMPP
- Check browser console for JavaScript errors
- Verify database in phpMyAdmin

---

**Congratulations! You're ready to start your productive study journey with StudySprint! 🎉📚**

---

## Quick Reference

### Important URLs:
- Application: `http://localhost/studysprint/public/`
- phpMyAdmin: `http://localhost/phpmyadmin`
- XAMPP Dashboard: `http://localhost/dashboard/`

### Important Paths:
- Project Location: `C:\xampp\htdocs\studysprint\`
- Config File: `C:\xampp\htdocs\studysprint\config.php`
- Database Schema: `C:\xampp\htdocs\studysprint\studysprint.sql`

### Demo Account:
- Username: `john_doe`
- Password: `demo123`

### Default Database Settings:
- Host: `localhost`
- Database: `studysprint`
- Username: `root`
- Password: (empty)

---

**Happy Studying! 🚀**


