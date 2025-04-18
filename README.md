# School Management System

A web-based application built with Laravel to manage school-related operations, including admin and teacher modules, announcements, and more.

## Table of Contents
- [Overview](#overview)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Admin and Teacher Access](#admin-and-teacher-access)
- [Announcement Mail Feature](#announcement-mail-feature)
- [Contributing](#contributing)
- [License](#license)

## Overview
The School Management System is a robust platform designed to streamline administrative and academic tasks in a school environment. It provides modules for administrators and teachers, supports email notifications for announcements, and is built using modern web technologies.

## System Requirements
To run this project, ensure your environment meets the following requirements:
- **PHP**: 8.2
- **Laravel**: 12.0
- **Composer**: 2.8.8
- **Node.js** and **NPM** (for frontend assets)
- **MySQL** (or compatible database)
- **Mailtrap** (or another SMTP service for email functionality)

## Installation
Follow these steps to set up the project locally:

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/jaydeep892/schoolmanagement.git
   ```

2. **Open the Project**:
   Open the project folder in your preferred code editor.

3. **Create `.env` File**:
   - Copy the `.env.example` file in the root directory and rename it to `.env`.
   - Configure the database credentials in the `.env` file:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=schoolmanagement
     DB_USERNAME=<your-username>
     DB_PASSWORD=<your-password>
     ```

4. **Configure Mail Settings**:
   - Set up mail configuration (e.g., using Mailtrap for testing) in the `.env` file:
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=sandbox.smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=<mailtrap-username>
     MAIL_PASSWORD=<mailtrap-password>
     MAIL_ENCRYPTION=null
     MAIL_FROM_ADDRESS="hello@example.com"
     MAIL_FROM_NAME="${APP_NAME}"
     ```

5. **Install Dependencies**:
   - Open a terminal in the project directory and run:
     ```bash
     composer install
     npm install
     npm run build
     ```

6. **Set Up the Application**:
   - Clear cached configurations:
     ```bash
     php artisan optimize:clear
     ```
   - Generate an application key:
     ```bash
     php artisan key:generate
     ```
   - Run database migrations:
     ```bash
     php artisan migrate
     ```
   - Seed the database with initial data:
     ```bash
     php artisan db:seed
     ```

7. **Run the Application**:
   - Start the Laravel development server:
     ```bash
     php artisan serve
     ```
   - The command will output a URL (e.g., `http://127.0.0.1:8000`). Open it in your browser.

## Usage
- Navigate to the application URL in your browser.
- Click the **Login** button to access the system.
- Use the credentials provided below to log in as an admin or teacher.
- Explore the available modules, including administrative tasks, teacher management, and announcements.

## Admin and Teacher Access
- **Admin Login**:
  - **Username**: `admin@testmail.com`
  - **Password**: `12345678`
  - After logging in, you can access all modules as per the system requirements.

- **Teacher Login**:
  - Log in using any teacher account (credentials seeded in the database).
  - **Password**: `12345678` (default for all teacher accounts).

## Announcement Mail Feature
The system supports automated announcement emails. To enable this feature locally:
1. Run the following command in the project terminal to process scheduled tasks:
   ```bash
   php artisan schedule:work
   ```
   - This command continuously checks for new announcements and sends emails every minute.

2. For production environments, configure the scheduler using a cron job:
   - Add the following cron entry to your server:
     ```bash
     * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
     ```

**Note**: Ensure your mail configuration in the `.env` file is correct to send emails successfully.

Please ensure your code follows the project's coding standards and includes appropriate tests.

## License
This project is licensed under the [MIT License](LICENSE). See the LICENSE file for details.