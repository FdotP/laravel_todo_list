

# Installation and Configuration Guide for Laravel Application

## Table of Contents
1. [Installing Dependencies (npm, Composer, Artisan)](#installing-dependencies)
2. [Configuring SMTP with Mailtrap](#configuring-smtp-with-mailtrap)
3. [Configuring Google API for Calendar Integration](#configuring-google-api)
4. [Running Laravel Schedulers and Workers](#running-schedulers-and-workers)

---

## Installing Dependencies

### 1.1 Installing npm Dependencies

To install all npm dependencies, run the following command in the root directory of the project:

```bash
npm install
```

### 1.2 Installing Composer Dependencies

To install PHP dependencies (Composer), run the following command in the root directory of the project:

```bash
composer install
```

### 1.3 Database Configuration

Fill in your database connection details in the `.env` file:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 1.4 Running Artisan Commands

Once the Composer dependencies are installed, run the following Artisan commands to set up the environment:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

---

## Configuring SMTP with Mailtrap

### 2.1 Registering with Mailtrap

1. Sign up at [Mailtrap.io](https://mailtrap.io/).
2. Create a new inbox and get the SMTP credentials (username, password, host, port).

### 2.2 Configuring the `.env` File

Once you have the Mailtrap credentials, update your `.env` file to enable Laravel to use Mailtrap for sending emails:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

Replace `your_mailtrap_username` and `your_mailtrap_password` with the credentials from Mailtrap.

---

## Configuring Google API for Calendar Integration

### 3.1 Creating a Project in Google Cloud Console

1. Log in to [Google Cloud Console](https://console.cloud.google.com/).
2. Create a new project.
3. In the `APIs & Services > Library` section, search for and enable the Google Calendar API.
4. In the `APIs & Services > Credentials` section, create OAuth 2.0 credentials (Client ID and Client Secret).

### 3.2 Updating the `.env` File

After obtaining your Client ID and Client Secret, add them to your `.env` file:

```dotenv
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Replace `your_google_client_id` and `your_google_client_secret` with your credentials.

### 3.3 Installing the Required Packages

Run the following command to install the required package for Google API integration:

```bash
composer require google/apiclient:^2.0
```

---

## Running Laravel Schedulers and Workers

### 4.1 Configuring Cron for Scheduler

To run the Laravel Scheduler, add the following cron entry on your server:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

This cron will run the scheduler every minute.

### 4.2 Running Queue Workers

To run Laravel queue workers, execute the following command:

```bash
php artisan queue:work
```

---

## General Application Usage

= User Guide for Task Management Application

The application allows you to create, edit, view, and delete tasks. You can also generate public links to tasks and archive their versions.

== Features

1. **Creating a Task**
   - To create a new task, navigate to the "Tasks" section and click the "Create Task" button.
   - In the form, enter the task name, description, priority, status, and due date.
   - Once the form is completed, click "Save Task."

2. **Task List**
   - The homepage of the application displays a list of all created tasks.
   - You can click on any task to view its details.
   - You can filter tasks by priority, status, and due date using the available filters.

3. **Viewing Task Details**
   - Click on any task in the list to view its details.
   - On the task detail page, you’ll see the task name, description, priority, status, and due date.
   - You can edit the task by clicking the "Edit Task" button or delete it by clicking "Delete Task."

4. **Editing a Task**
   - Click on the task you want to edit, then click the "Edit Task" button.
   - In the edit form, you can change the task name, description, priority, status, and due date.
   - After making changes, click "Save Changes."

5. **Deleting a Task**
   - On the task details page, click the "Delete Task" button to remove the task from the database.
   - The task will be deleted after confirmation.

6. **Generating a Public Link**
   - You can generate a public link to the task by clicking the "Generate Link" button.
   - The task link can be copied and shared with others. The link expires after a set time.

7. **Archiving Task Versions**
   - Every edited version of a task is automatically archived.
   - To view earlier versions of a task, go to the "Archived Versions" section on the task details page.
   - You can browse archived versions, including their name, description, priority, status, and due date.

8. **Viewing Tasks in Calendar**
   - The application allows you to view tasks in a calendar to easily track their due dates and importance.
   - Tasks are displayed in the calendar based on their due date.
   - To view tasks in the calendar, go to the appropriate section of the application where the calendar view is available, showing the dates assigned to tasks.

9. **Google Login**
   - The application allows you to log in via Google, making it easier to sync tasks and other data.
   - If you're not logged in, a "Connect with Google" button will appear in the top right corner, which will redirect you to Google login.
   - After logging in with Google, access to the app and task management becomes more streamlined, and your tasks may sync with your Google account if that option is enabled in the application.

== Author
The application was created by Maksymilian Paluśkiewicz.

