# Shoe Shop

#### _This app allows a user to track the relationship between different shoe stores and brands._

#### By Aundra Miller

## Description

This application allows a user to create shoe stores and brands and manage their various relationships.
The application was developed using PHP, MySQL, Silex, Twig, and PHPUnit.

## Setup/Installation Requirements

To work properly, this application requires:

* Composer.
* Twig and Silex installation.
* Local server.
* MySQL database.

Setup instructions:

1. Clone this repository.

2. Go to the root directory.

3. Run 'composer install' in the terminal (to install Twig and Silex).

4. Start the MySQL server:
  * Enter 'apachectl start' in the terminal.
  * Navigate to 'localhost:8080/phpmyadmin'.

5. Upload MySQL database:
  * Log in to your account on PHPMyAdmin.
  * Select the 'Import' tab.
  * Choose the .mysql database file in the project folder.
  * Click 'Go'.

6. Start your local server.
  * Navigate in the terminal to the web folder in the main project folder.
  * Enter 'php -S localhost:8000' in the terminal.
  * Enter 'localhost:8000' into your browser.

## Known Bugs

No bugs known.

## Support and contact details

If you have any questions, concerns, or suggestions, contact me directly at miller.aundra@gmail.com. Pull requests can be submitted directly to milleraundra on Github.

## Technologies Used

* PHP
* MySQL
* HTML
* Twig
* Silex
* PHPUnit
* CSS
* Bootstrap

### License

The MIT License (MIT)

Copyright (c) 2016 Aundra Miller

### MySQL Command Line History
mysql> CREATE DATABASE shoes;
Query OK, 1 row affected (0.00 sec)

mysql> USE shoes
Database changed
mysql> CREATE TABLE stores(id serial PRIMARY KEY, store_name VARCHAR(255), street VARCHAR (255), city VARCHAR (255), state VARCHAR (255));
Query OK, 0 rows affected (0.15 sec)

mysql> CREATE TABLE brands(id serial PRIMARY KEY, brand_name VARCHAR(255));
Query OK, 0 rows affected (0.07 sec)

mysql> UPDATE brands ADD type ARRAY;
ERROR 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ADD type ARRAY' at line 1

mysql> CREATE TABLE stores_brands(id serial PRIMARY KEY, store_id INT, brand_id INT);
Query OK, 0 rows affected (0.07 sec)

mysql> CREATE TABLE stores_brands(id serial PRIMARY KEY, store_id INT, brand_id INT);
