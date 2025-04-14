# Library Management System (PHP)

This project is a **Library Management System** built using PHP, HTML, CSS, and MySQL. It provides a platform for managing library operations such as searching for books, borrowing, returning, and providing feedback. The system is designed to be user-friendly and efficient for both library administrators and users.

---

## Features

1. **Home Page**: Displays a list of all available books in the library.
2. **Search Books**: Allows users to search for books by title or author.
3. **Borrow Books**: Enables users to borrow books and tracks borrowed books with due dates.
4. **Return Books**: Allows users to return borrowed books and updates the inventory.
5. **Feedback Form**: Users can provide feedback about the library services.
6. **Contact Us**: Users can send queries or messages to the library administrators.
7. **Login System**: Provides a login page for user authentication.
8. **Responsive Design**: The system is styled with CSS for a clean and responsive user interface.
9. **Unique Footer Feature**: Displays the last page visited by the user on every page.

---

## Unique Footer Feature: Last Visited Page

One of the unique features of this project is the **Last Visited Page** functionality. This feature displays the last page the user visited in the footer of every page. It enhances user experience by providing a quick reference to their previous activity.

### How It Works:
- A **cookie** named `last_visited_page` is set whenever a user visits a page.
- The cookie stores the URL of the current page.
- On each page load, the footer retrieves the value of the `last_visited_page` cookie and displays it.

### Example:
If a user visits the "Search Books" page and then navigates to the "Borrow Books" page, the footer on the "Borrow Books" page will display:

---

## Database Structure

The project uses a MySQL database named `library_books` with the following tables:

### 1. `books` Table
This table stores information about all the books in the library.

| Column Name       | Data Type    | Description                          |
|-------------------|--------------|--------------------------------------|
| `book_id`         | INT          | Unique identifier for each book.     |
| `title`           | VARCHAR(255) | Title of the book.                   |
| `author`          | VARCHAR(255) | Author of the book.                  |
| `genre`           | VARCHAR(100) | Genre of the book.                   |
| `publication_year`| YEAR         | Year the book was published.         |
| `price`           | DECIMAL(10,2)| Price of the book.                   |
| `language`        | VARCHAR(50)  | Language of the book.                |
| `quantity`        | INT          | Number of copies available.          |

### 2. `borrowed_books` Table
This table tracks books that have been borrowed by users.

| Column Name       | Data Type    | Description                          |
|-------------------|--------------|--------------------------------------|
| `book_id`         | INT          | ID of the borrowed book.             |
| `title`           | VARCHAR(255) | Title of the borrowed book.          |
| `author`          | VARCHAR(255) | Author of the borrowed book.         |
| `borrowed_date`   | DATE         | Date when the book was borrowed.     |
| `return_date`     | DATE         | Due date for returning the book.     |

### 3. `returned_books` Table
This table tracks books that have been returned by users.

| Column Name       | Data Type    | Description                          |
|-------------------|--------------|--------------------------------------|
| `book_id`         | INT          | ID of the returned book.             |
| `title`           | VARCHAR(255) | Title of the returned book.          |
| `author`          | VARCHAR(255) | Author of the returned book.         |
| `borrowed_date`   | DATE         | Date when the book was borrowed.     |
| `return_date`     | DATE         | Date when the book was returned.     |

---

---

## SQL Queries for Database Setup

Use the following SQL queries to create the database, tables, and insert the sample data:

-- Create the database
CREATE DATABASE library_books;

-- Use the database
USE library_books;

-- Create the `books` table
CREATE TABLE books (
    book_id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    publication_year YEAR,
    price DECIMAL(10, 2),
    language VARCHAR(50),
    quantity INT
);

-- Insert data into the `books` table
INSERT INTO books (book_id, title, author, genre, publication_year, price, language, quantity) VALUES
(1, 'The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 1951, 9.99, 'English', 100),
(2, 'To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1960, 12.99, 'English', 74),
(3, 'Pride and Prejudice', 'Jane Austen', 'Romance', 1813, 14.99, 'English', 50),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 1925, 13.99, 'English', 25),
(5, 'Jane Eyre', 'Charlotte Bronte', 'Romance', 1847, 11.99, 'English', 60),
(6, 'Wuthering Heights', 'Emily Bronte', 'Gothic', 1847, 12.99, 'English', 40),
(7, 'The Adventures of Huckleberry Finn', 'Mark Twain', 'Adventure', 1884, 10.99, 'English', 80),
(8, 'Moby Dick', 'Herman Melville', 'Adventure', 1851, 13.99, 'English', 30),
(9, 'Frankenstein', 'Mary Shelley', 'Gothic', 1818, 14.99, 'English', 50),
(10, 'Dracula', 'Bram Stoker', 'Gothic', 1897, 14.99, 'English', 50),
(11, 'The Picture of Dorian Gray', 'Oscar Wilde', 'Gothic', 1890, 13.99, 'English', 60),
(12, 'The Scarlet Letter', 'Nathaniel Hawthorne', 'Fiction', 1850, 11.99, 'English', 60),
(13, 'The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', 'Science Fiction', 1979, 12.99, 'English', 75),
(14, 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 1954, 39.99, 'English', 25),
(15, 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 1937, 14.99, 'English', 50),
(16, 'The Hunger Games', 'Suzanne Collins', 'Science Fiction', 2008, 11.99, 'English', 100),
(17, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Fantasy', 1997, 14.99, 'English', 150),
(18, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'Crime', 2005, 13.99, 'Swedish', 80),
(19, 'The Da Vinci Code', 'Dan Brown', 'Mystery', 2003, 12.99, 'English', 120),
(20, 'Gone with the Wind', 'Margaret Mitchell', 'Historical Fiction', 1936, 14.99, 'English', 100),
(21, 'The Kite Runner', 'Khaled Hosseini', 'Fiction', 2003, 14.99, 'English', 100),
(22, 'The Book Thief', 'Markus Zusak', 'Historical Fiction', 2005, 14.99, 'English', 75),
(23, 'The Giver', 'Lois Lowry', 'Science Fiction', 1993, 11.99, 'English', 100);

-- Create the `borrowed_books` table
CREATE TABLE borrowed_books (
    book_id INT,
    title VARCHAR(255),
    author VARCHAR(255),
    borrowed_date DATE,
    return_date DATE
);

-- Insert data into the `borrowed_books` table
INSERT INTO borrowed_books (book_id, title, author, borrowed_date, return_date) VALUES
(3, 'Pride and Prejudice', 'Jane Austen', '2024-05-21', '2024-05-21'),
(2, 'To Kill a Mockingbird', 'Harper Lee', '2024-05-21', '2024-06-10');

-- Create the `returned_books` table
CREATE TABLE returned_books (
    book_id INT,
    title VARCHAR(255),
    author VARCHAR(255),
    borrowed_date DATE,
    return_date DATE
);

-- Insert data into the `returned_books` table
INSERT INTO returned_books (book_id, title, author, borrowed_date, return_date) VALUES
(3, 'Pride and Prejudice', 'Jane Austen', '2024-05-21', '2024-05-21');

---

## Project Structure

---

## Setup Instructions

1. **Prerequisites**:
   - Install [XAMPP](https://www.apachefriends.org/index.html) or any other PHP and MySQL server.
   - Ensure the MySQL database is running.

2. **Database Setup**:
   - Create a database named `library_books`.
   - Import the required tables and data using the SQL scripts (if provided).

3. **Project Deployment**:
   - Place the project folder in the `htdocs` directory of your XAMPP installation.
   - Start the Apache and MySQL servers from the XAMPP control panel.

4. **Configuration**:
   - Update the database credentials in [`config.php`](config.php) if necessary.

5. **Access the Application**:
   - After completing the setup, open a browser and navigate to the following URL to access the homepage : `http://localhost/PHP/library_books.php`

---

## Usage

1. **Home Page**:
   - View all available books in the library.

2. **Search Books**:
   - Use the search bar to find books by title or author.

3. **Borrow Books**:
   - Select a book and click "Add" to borrow it. The system will automatically calculate the return date.

4. **Return Books**:
   - View borrowed books and return them. The system updates the inventory accordingly.

5. **Feedback**:
   - Submit feedback about the library services.

6. **Contact Us**:
   - Send queries or messages to the library administrators.

7. **Login**:
   - Use the login page to authenticate and access personalized features.

---

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP (Apache)

---

## Screenshots

1. **Home Page**:
   Displays all available books in the library.
   ![image](https://github.com/user-attachments/assets/796d957c-b9f1-4d91-8d71-16740e2dce60)


3. **Search Books**:
   Allows users to search for books by title or author.
   ![image](https://github.com/user-attachments/assets/3299f6ac-85e3-4256-a0c4-ee229d6ea597)


5. **Borrowed Books**:
   Tracks books borrowed by users.
   ![image](https://github.com/user-attachments/assets/b7ce8d65-d359-46a6-b437-e3fdf9db81c0)


7. **Return Books**:
   Allows users to return borrowed books.
   ![image](https://github.com/user-attachments/assets/b9237f75-eef6-4d62-af74-88f7515cf2fd)


9. **Feedback Form**:
   Collects user feedback.
   ![image](https://github.com/user-attachments/assets/ceacf9af-db14-485c-a6df-ae94865781fc)


---

## License

This project is open-source and available for educational purposes. Feel free to modify and use it as needed.

---

## Contact
   ![image](https://github.com/user-attachments/assets/924dafb0-71e7-4c6a-8538-c800a727fbfa)
For any queries or issues, please contact the project administrator via the **Contact Us** page.
