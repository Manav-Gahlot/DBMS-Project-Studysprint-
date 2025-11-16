# StudySprint - Quick Start Checklist

Use this checklist to quickly set up StudySprint. For detailed explanations, see `DETAILED_SETUP_GUIDE.md`.

## Pre-Setup Checklist

- [ ] Windows computer ready
- [ ] Administrator privileges available
- [ ] Internet connection available
- [ ] Modern web browser installed

## Setup Steps

### Step 1: Install XAMPP
- [ ] Downloaded XAMPP from https://www.apachefriends.org/
- [ ] Installed XAMPP to `C:\xampp\`
- [ ] Selected Apache, MySQL, PHP, and phpMyAdmin during installation

### Step 2: Place Project Files
- [ ] Copied project folder to `C:\xampp\htdocs\studysprint\`
- [ ] Verified folder structure exists (public, includes, models, controllers, assets)
- [ ] Confirmed `config.php` and `studysprint.sql` are present

### Step 3: Start XAMPP Services
- [ ] Opened XAMPP Control Panel
- [ ] Started Apache (status shows "Running" in green)
- [ ] Started MySQL (status shows "Running" in green)
- [ ] Both services are running simultaneously

### Step 4: Create Database
- [ ] Opened browser to http://localhost/phpmyadmin
- [ ] Clicked "Import" tab
- [ ] Selected `studysprint.sql` file
- [ ] Clicked "Go" button
- [ ] Saw success message: "Import has been successfully finished"
- [ ] Verified `studysprint` database exists in left sidebar
- [ ] Confirmed 3 tables exist: `users`, `study_sessions`, `goals`
- [ ] Verified demo users exist (john_doe, jane_smith, alex_chen)

### Step 5: Configure Database (Optional)
- [ ] Opened `config.php` file
- [ ] Verified database settings:
  - DB_HOST: `localhost`
  - DB_NAME: `studysprint`
  - DB_USER: `root`
  - DB_PASS: `` (empty)
- [ ] Made changes if MySQL password was set
- [ ] Saved file

### Step 6: Test Database Connection (Optional)
- [ ] Created `test_db.php` file (optional)
- [ ] Opened http://localhost/studysprint/test_db.php
- [ ] Saw "✅ Database connection successful!"
- [ ] Deleted test file after verification

### Step 7: Access Application
- [ ] Opened browser
- [ ] Navigated to http://localhost/studysprint/public/
- [ ] Saw login page with "Welcome to StudySprint"
- [ ] No errors displayed

### Step 8: Login with Demo Account
- [ ] Entered username: `john_doe`
- [ ] Entered password: `demo123`
- [ ] Clicked "Login" button
- [ ] Successfully logged in
- [ ] Saw dashboard with Pomodoro timer
- [ ] Navigation menu appears at top

### Step 9: Test Features
- [ ] Tested Pomodoro timer (start, pause, reset)
- [ ] Created a new goal
- [ ] Viewed statistics page (charts load)
- [ ] Checked leaderboard (users display)
- [ ] Opened settings page
- [ ] Toggled dark mode
- [ ] Changed password (optional)

### Step 10: Register New Account (Optional)
- [ ] Logged out from demo account
- [ ] Clicked "Register here" link
- [ ] Filled in registration form
- [ ] Successfully registered new account
- [ ] Logged in with new account
- [ ] Saw empty dashboard (normal for new account)

## Verification Checklist

### Authentication
- [ ] Can register new account
- [ ] Can login with credentials
- [ ] Can logout
- [ ] Session persists after page refresh
- [ ] Cannot access pages without login

### Pomodoro Timer
- [ ] Timer starts and counts down
- [ ] Can pause timer
- [ ] Can reset timer
- [ ] Session logs when completed
- [ ] Break timer works after work session

### Goals Management
- [ ] Can create new goal
- [ ] Can edit existing goal
- [ ] Can delete goal
- [ ] Progress bars display correctly
- [ ] Goals show on dashboard

### Statistics
- [ ] Charts load and display
- [ ] Daily time chart shows data
- [ ] Weekly goal chart shows data
- [ ] Cumulative chart shows trend
- [ ] Topic distribution chart works
- [ ] CSV export downloads file

### Leaderboard
- [ ] Top users display correctly
- [ ] User rank shows correctly
- [ ] Total time displays correctly
- [ ] Rankings update when sessions logged

### Settings
- [ ] Can change password
- [ ] Dark mode toggles
- [ ] Dark mode preference saves
- [ ] Settings persist after logout/login

### UI/UX
- [ ] Navigation works on all pages
- [ ] Responsive on mobile devices
- [ ] Flash messages appear
- [ ] Loading states work
- [ ] Forms validate correctly

## Troubleshooting

### If Apache Won't Start:
- [ ] Checked if port 80 is in use
- [ ] Closed other programs using port 80 (Skype, IIS)
- [ ] Changed Apache port to 8080 (if needed)
- [ ] Restarted Apache

### If MySQL Won't Start:
- [ ] Checked if port 3306 is in use
- [ ] Checked XAMPP MySQL error log
- [ ] Restarted computer
- [ ] Reinstalled XAMPP (if needed)

### If Database Connection Fails:
- [ ] Verified MySQL is running
- [ ] Checked `config.php` database settings
- [ ] Verified database `studysprint` exists
- [ ] Checked MySQL username/password

### If 404 Error:
- [ ] Verified project in `C:\xampp\htdocs\studysprint\`
- [ ] Checked folder name is `studysprint`
- [ ] Tried alternative URL: http://localhost/studysprint/public/index.php
- [ ] Verified Apache is running

### If Charts Don't Load:
- [ ] Checked internet connection (Chart.js from CDN)
- [ ] Checked browser console for errors
- [ ] Verified JavaScript files loading
- [ ] Refreshed page

## Quick Reference

### URLs:
- **Application**: http://localhost/studysprint/public/
- **phpMyAdmin**: http://localhost/phpmyadmin
- **XAMPP Dashboard**: http://localhost/dashboard/

### Paths:
- **Project**: `C:\xampp\htdocs\studysprint\`
- **Config**: `C:\xampp\htdocs\studysprint\config.php`
- **Database**: `C:\xampp\htdocs\studysprint\studysprint.sql`

### Demo Account:
- **Username**: `john_doe`
- **Password**: `demo123`

### Database Settings:
- **Host**: `localhost`
- **Port**: `3307` (change if your MySQL uses a different port)
- **Database**: `studysprint`
- **Username**: `root`
- **Password**: (empty)

## Daily Usage

### Starting the App:
1. [ ] Open XAMPP Control Panel
2. [ ] Start Apache
3. [ ] Start MySQL
4. [ ] Open browser to http://localhost/studysprint/public/
5. [ ] Login with your credentials

### Using the App:
1. [ ] Set daily/weekly goals
2. [ ] Start Pomodoro timer
3. [ ] Track study sessions
4. [ ] View statistics
5. [ ] Check leaderboard

### Stopping the App:
1. [ ] Close browser tabs
2. [ ] Stop Apache (optional)
3. [ ] Stop MySQL (optional)
4. [ ] Close XAMPP Control Panel

## Success Criteria

✅ All setup steps completed  
✅ Database created and imported  
✅ Application accessible in browser  
✅ Can login with demo account  
✅ All features work correctly  
✅ No errors in browser console  
✅ No errors in Apache/MySQL logs  

## Next Steps

- [ ] Start using the application for studying
- [ ] Set up study goals
- [ ] Invite friends to register
- [ ] Customize colors and settings
- [ ] Explore all features
- [ ] Track your study progress

---

**✅ Setup Complete! Ready to Study! 🎉**

For detailed explanations of each step, see `DETAILED_SETUP_GUIDE.md`


