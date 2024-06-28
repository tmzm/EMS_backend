# Project Setup Guide

## Prerequisites

1. **Composer**: [Download Composer](https://getcomposer.org/download/)
2. **Xampp**: [Download Xampp](https://www.apachefriends.org/download.html)
3. **Git**: [Download Git](https://git-scm.com/downloads)

Optional: Install TablePlus or use phpMyAdmin to manage your database.

## Use TablePlus Guide:

### 1. Press on the plus button then chose `MySQL`

<img style="border: 2px solid red; border-radius: 10px" src="./public//images/docs/Screenshot 2024-06-28 191935.png" />

### 2. Enter Database Information as shown in this image:

<img style="border: 2px solid red; border-radius: 10px" src="./public//images/docs/Screenshot 2024-06-28 192253.jpg" />

### 3. Press on the database

<img style="border: 2px solid red; border-radius: 10px" src="./public//images/docs/Screenshot 2024-06-28 192452.png" />

### 4. You can now see the information of the tables and edit the records

<img style="border: 2px solid red; border-radius: 10px" src="./public//images/docs/Screenshot 2024-06-28 192508.png" />

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

```mysql
CREATE DATABASE EMS_database;
```

### 3. Clone the Repository

Run this command in the terminal to clone the repository to your PC:

```git
git clone https://github.com/tmzm/EMS_backend
```

### 4. Configure Environment

In the project root directory, create a new file named `.env` and copy everything from `.env.example` to `.env`.

### 5. Install Dependencies and Setup Project

Navigate to the root folder of the project and run the following commands in order (make sure Xampp is running):

```laravel
composer install
php artisan migrate:fresh 
php artisan passport:client -–personal
```

These commands are necessary to set up the project for the first time.

### 6. Run the Project

Every time you want to run this project (always ensure Xampp is running), use the command:

```laravel
php artisan serve
```

