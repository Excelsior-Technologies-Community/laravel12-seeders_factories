# PHP_Laravel12_Use_Seeders_And_Factories_For_Dummy_Records

A Laravel 12 demonstration project showing how to generate **dummy records** using **Factories and Database Seeders**.
This project covers real-world relationships such as **Products, Tags, Multiple Images, Soft Deletes, and Pivot Tables**, making it ideal for learning and practice.

---

## Project Overview

This repository helps developers understand:

* How to use Laravel Factories to generate fake data
* How to use Seeders to insert bulk records
* How to manage Many-to-Many relationships using pivot tables
* How to store multiple images per product
* How to implement Soft Deletes in Laravel

This project is suitable for:

* Beginners learning Laravel database concepts
* Interview preparation
* Practice projects
* Reference for seeding real-world data

---

## Features

* Laravel 12 setup
* Factory-based dummy data generation
* Database seeders
* Product module with:

  * Multiple images
  * Tags (Many-to-Many relationship)
  * Soft Deletes
* Clean and beginner-friendly structure

---

## Tech Stack

* Backend: Laravel 12
* Database: MySQL / SQLite
* ORM: Eloquent
* Faker: Fake data generation

---

## Project Screenshots

<img width="1712" height="969" alt="image" src="https://github.com/user-attachments/assets/fa1b1a3f-978d-4cfb-ad2c-70588cf817c8" />
<img width="1783" height="954" alt="image" src="https://github.com/user-attachments/assets/dea4c5b0-a3e3-41e7-a9b8-f1607e53b2c1" />

---

## Installation Guide

### Step 1: Clone the Repository

```bash
git clone https://github.com/your-username/laravel-dummy-data.git
cd laravel-dummy-data
```

### Step 2: Install Dependencies

```bash
composer install
npm install
```

### Step 3: Create Environment File

```bash
cp .env.example .env
```

Update your database credentials in `.env`:

```env
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

### Step 6: Run Database Seeders

```bash
php artisan db:seed
```

Or run everything at once:

```bash
php artisan migrate:fresh --seed
```

---

## Database Structure

Tables included in this project:

* products
* tags
* product_images
* product_tag (pivot table)

---

## Sample Data Generated

After running the seeders:

* 50 products will be created
* Each product will have:

  * 1 to 5 images
  * 1 to 4 tags

---

## Key Learning Points

* Usage of Laravel Factories
* Database seeding techniques
* Handling pivot tables
* Soft delete implementation
* Generating realistic test data

---

