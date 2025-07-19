# ChefAI - AI-Powered Recipe Creator

## Overview

ChefAI is a dynamic web application built with PHP and MySQL that leverages Artificial Intelligence to generate unique recipes based on user inputs. It serves as a personalized culinary assistant, allowing users to request recipes by providing available ingredients. Users can store and manage their favorite AI-created recipes through robust features for saving and viewing. The application also includes a separate administrative panel for managing users.

## Setup Instructions

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/ChefAI.git
    ```

2.  **Install dependencies:**

    This project uses Composer to manage PHP dependencies. If you don't have Composer installed, you can download it from [getcomposer.org](https://getcomposer.org/).

    ```bash
    composer install
    ```

3.  **Create the database:**

    Create a new MySQL database named `ChefAI_DB`. You can use the following SQL queries to create the necessary tables:

    ```sql
    -- Create Database
    CREATE DATABASE IF NOT EXISTS ChefAI_DB;
    USE ChefAI_DB;

    -- 1. Users Table (for normal users)
    CREATE TABLE Users (
       user_id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       password_hash VARCHAR(255) NOT NULL, -- Stores hashed passwords (use PASSWORD_BCRYPT)
       email VARCHAR(100) UNIQUE,
       profile_image VARCHAR(255) DEFAULT NULL, -- Stores file path or URL to profile image
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- 2. Admins Table (for platform administrators)
    CREATE TABLE Admins (
       admin_id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       password_hash VARCHAR(255) NOT NULL, -- Stores hashed passwords (use PASSWORD_BCRYPT)
       email VARCHAR(100) UNIQUE,
       last_login TIMESTAMP DEFAULT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- 3. Recipes Table (stores all generated/saved recipes)
    CREATE TABLE Recipes (
       recipe_id INT AUTO_INCREMENT PRIMARY KEY,
       recipe_name VARCHAR(255) NOT NULL,
       ingredients TEXT NOT NULL, -- Store as JSON string or comma-separated list
       instructions TEXT NOT NULL,
       cooking_time VARCHAR(50), -- e.g., "30 mins", "1 hour"
       serving_size VARCHAR(50) DEFAULT NULL,
       difficulty VARCHAR(50) DEFAULT NULL, -- e.g., "Easy", "Medium", "Hard"
       ai_generated BOOLEAN DEFAULT TRUE, -- TRUE if AI-generated, FALSE if manually added (future feature)
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- 4. User_Saved_Recipes Table (Many-to-many relationship for user collections)
    CREATE TABLE User_Saved_Recipes (
       user_id INT,
       recipe_id INT,
       is_favorite BOOLEAN DEFAULT FALSE, -- To mark recipes as favorites/bookmarks
       saved_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       PRIMARY KEY (user_id, recipe_id), -- Composite primary key
       FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
       FOREIGN KEY (recipe_id) REFERENCES Recipes(recipe_id) ON DELETE CASCADE
    );
    ```

4.  **Configure environment variables:**

    Rename the `.env.example` file to `.env` and update the following variables with your database credentials and AI API key:

    ```
    DB_HOST=localhost
    DB_NAME=ChefAI_DB
    DB_USER=root
    DB_PASS=
    AI_API_KEY=YOUR_API_KEY
    AI_API_URL=https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=
    ```

5.  **Run the application:**

    Start your local web server (e.g., XAMPP, WAMP) and navigate to the project directory in your web browser.

