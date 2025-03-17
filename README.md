# Causali Macchinari Web App

This is a simple web application built with PHP and MariaDB to track machine usage and downtime.

## Features

* **User and Machine Selection:** Select a user and machine from dropdown lists.
* **Start/Stop Tracking:** Start and stop machine usage tracking with timestamped events.
* **Downtime Cause Recording:** Record the cause of machine downtime when stopping an event.
* **Live Clock:** Displays a live clock at the top of the page.

## Requirements

* Debian 12 or similar Linux distribution
* Apache web server
* PHP (with `mysqli` extension)
* MariaDB database server
* Simple.css (https://simplecss.org/) for basic styling

## Installation

1.  **Clone or copy the PHP files** into your Apache document root (e.g., `/var/www/html/mywebapp`).
2.  **Create a MariaDB database** named `causali_macchinari`.
3.  **Import the provided SQL schema** (or create the tables manually) into the `causali_macchinari` database. The table definitions are:
    ```sql
    CREATE TABLE utenti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utente VARCHAR(255) NOT NULL
    );

    CREATE TABLE macchinari (
        id INT AUTO_INCREMENT PRIMARY KEY,
        macchinario VARCHAR(255) NOT NULL
    );

    CREATE TABLE causali (
        id INT AUTO_INCREMENT PRIMARY KEY,
        causale VARCHAR(255) NOT NULL
    );

    CREATE TABLE eventi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_utente INT,
        id_macchinario INT,
        data_ora DATETIME,
        id_causale INT,
        evento INT,
        FOREIGN KEY (id_utente) REFERENCES utenti(id),
        FOREIGN KEY (id_macchinario) REFERENCES macchinari(id),
        FOREIGN KEY (id_causale) REFERENCES causali(id)
    );
    ```
4.  **Populate the `utenti`, `macchinari`, and `causali` tables** with initial data.
5.  **Configure the database connection** in `db_connect.php` with your MariaDB credentials.
6.  **Access the web app** through your web browser (e.g., `http://localhost/mywebapp/index.php`).

## Usage

1.  Select a user and machine from the dropdown lists.
2.  Click the "Start" button to begin tracking.
3.  Click the "Stop" button to stop tracking.
4.  If you click "Stop", select a cause from the "Causale" dropdown.

## Notes

* This is a basic application and can be extended with more features.
* Ensure proper security measures are in place for production environments.
* The `evento` column in the `eventi` table uses `1` for start events and `2` for stop events.