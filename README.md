# GreenStayHub

GreenStayHub is a website that helps students find and book accommodations for their academic year. It allows users to manage accommodation bookings and reservations.

## User Types

There are four types of users in the system:

### Admin

- Can create users of type warden, landlord, and student.
- Can create and edit articles.

### Student

- Can view available accommodations as advertisements.
- Can request for accommodation.
- Can view articles posted by the admin.

### Landlord

- Can post advertisements for accommodations.
- Can view requests for accommodations.

### Warden

- Must approve or reject advertisements posted by landlords.

## Local Setup Guide

Follow these steps to host the project locally using XAMPP:

### Step 1: Install XAMPP

Download and install XAMPP from the official website: [XAMPP](https://www.apachefriends.org/index.html)

### Step 2: Create Database

- Open phpMyAdmin by navigating to `http://localhost/phpmyadmin` in your browser.
- Create a new database named `greenstayhubdb`.

### Step 3: Import SQL Files

- Locate the `sql` directory in the project repository.
- Import the SQL files into the `greenstayhubdb` database by following these steps:
    - Click on the `greenstayhubdb` database in phpMyAdmin.
    - Go to the `Import` tab.
    - Choose the SQL files from the `sql` directory and click `Go`.

### Step 4: Create User in phpMyAdmin

- Create a new user with appropriate privileges for accessing the `greenstayhubdb` database in phpMyAdmin.

### Step 5: Update Configuration File

- Locate the `app/backend/config.php` file in the project repository.
- Update the database and user details in the `config.php` file with the credentials you created in Steps 2 and 4.

### Step 6: Copy Project Files to htdocs

- Copy all the project files or clone the repository into the `htdocs` directory of your XAMPP installation.
  The `htdocs` directory is usually located at `C:\xampp\htdocs` on Windows or `/Applications/XAMPP/htdocs` on macOS.

### Step 7: Update Base URL

- Open the `app/init.php` file in the project repository.
- Update the `BASE_URL` constant with the appropriate URL. For example, if your Apache server is running on port 80 (default port), set the `BASE_URL` as follows:
    ```php
    const BASE_URL = 'http://localhost:80/';
    ```

### Step 8: Start Apache and MySQL Servers

- Open the XAMPP Control Panel.
- Start the Apache and MySQL servers by clicking the `Start` button next to their respective services.

### Step 9: Access the Project

- Open your web browser and go to `http://localhost:80`.
