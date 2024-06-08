# Project Setup Guide

## Prerequisites

1. **Composer**: [Download Composer](https://getcomposer.org/download/)
2. **Xampp**: [Download Xampp](https://www.apachefriends.org/download.html)
3. **Git**: [Download Git](https://git-scm.com/downloads)

Optional: Install TablePlus or use phpMyAdmin to manage your database.

## Steps to Setup

### 1. Start Xampp

- Open Xampp and turn on Apache and MySQL.
- Note: You can close Xampp after you have turned on Apache and MySQL.

### 2. Create the Database

Run the following command in the terminal anywhere:

```bash
mysql -u root -p
```

When prompted for a password, simply press Enter without typing anything. Then run:

```bash
CREATE DATABASE EMS_database;
```

### 3. Configure Environment

In the project, create a new file named `.env` and copy everything from `.env.example` to .env.

### 4. Clone the Repository

Run this command in the terminal to clone the repository to your PC:

```bash
git clone https://github.com/tmzm/EMS_backend
```

### 5. Install Dependencies and Setup Project

Navigate to the root folder of the project and run the following commands in order (make sure Xampp is running):

```bash
composer install
php artisan passport:install
php artisan migrate –seed
php artisan passport:client –personal
```

These commands are necessary to set up the project for the first time.

### 6. Run the Project

Every time you want to run this project (always ensure Xampp is running), use the command:

```bash
php artisan serve
```

