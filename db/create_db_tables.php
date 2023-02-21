<?php
require 'db_credentials.php';

// Create connection
$conn = mysqli_connect($servername, $username, $db_password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database created successfully<br>";
} else {
    echo "<br>Error creating database: " . mysqli_error($conn);
}

// Choose database
$sql = "USE $dbname";
if (mysqli_query($conn, $sql)) {
    echo "<br>Database changed successfully<br>";
} else {
    echo "<br>Error changing database: " . mysqli_error($conn);
}

// sql to create table
$sql = "CREATE TABLE $table_users (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(128) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME,
  UNIQUE (email)
);";

if (mysqli_query($conn, $sql)) {
    echo "<br>Table created successfully<br>";
} else {
    echo "<br>Error creating table: " . mysqli_error($conn);
}

$sql = "INSERT INTO $table_users (name, email, password) VALUES ('admin', 'admin@admin.com', md5('admin'))";
  
  if (mysqli_query($conn, $sql)) {
      echo "<br>Inserted admin into users successfully<br>";
  } else {
      echo "<br>Error inserting into database: " . mysqli_error($conn);
  }

$sql = "CREATE TABLE $table_posts(
    id INT UNSIGNED AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    autor_id INT UNSIGNED NOT NULL,
    categoria VARCHAR(255),
    PRIMARY KEY(id),
    FOREIGN KEY(autor_id) REFERENCES $table_users(id));";

if (mysqli_query($conn, $sql)) {
    echo "<br>Table posts created successfully<br>";
} else {
    echo "<br>Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE $table_comments(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    autor_id INT UNSIGNED NOT NULL,
    content TEXT NOT NULL,
    data_plubicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(post_id) REFERENCES $table_posts(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(autor_id) REFERENCES $table_users(id) ON UPDATE CASCADE ON DELETE CASCADE);";

if (mysqli_query($conn, $sql)) {
    echo "<br>Table comments created successfully<br>";
} else {
    echo "<br>Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn)
?>
