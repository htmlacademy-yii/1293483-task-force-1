CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE cities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    latitude FLOAT NOT NULL,
    longitude FLOAT NOT NULL
);

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    icon VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(64) NOT NULL,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    city_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id),

    FULLTEXT (name)
);

CREATE TABLE profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dt_last_visit DATETIME,
    dt_birth DATETIME,
    avatar VARCHAR(100),
    info TEXT,
    phone VARCHAR(50),
    skype VARCHAR(50),
    telegram VARCHAR(50),
    rating INT UNSIGNED,
    role VARCHAR(50) NOT NULL,
    view_count INT UNSIGNED DEFAULT 0,
    show_new_message INT UNSIGNED DEFAULT 0,
    show_task_actions INT UNSIGNED DEFAULT 0,
    show_new_review INT UNSIGNED DEFAULT 0,
    show_contacts_customer INT UNSIGNED DEFAULT 0,
    show_profile INT UNSIGNED DEFAULT 0,

    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE photos_of_works (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(100) NOT NULL,

    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE user_specialization (
    user_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, category_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dt_end DATETIME,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    address VARCHAR(50),
    budget INT UNSIGNED,
    status VARCHAR(50),
    latitude VARCHAR(50),
    longitude VARCHAR(50),

    category_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    customer_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES users(id),
    executor_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (executor_id) REFERENCES users(id),
    city_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(id),

    FULLTEXT (title)
);

CREATE TABLE files (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(100) NOT NULL,

    task_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id)
);

CREATE TABLE replies (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    price INT UNSIGNED NOT NULL,
    content TEXT NOT NULL,

    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    task_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id)
);

CREATE TABLE opinions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rate INT UNSIGNED NOT NULL,
    content TEXT NOT NULL,

    task_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id),
    customer_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES users(id),
    executor_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (executor_id) REFERENCES users(id)
);

CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    is_read INT UNSIGNED DEFAULT 0,

    sender_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    receiver_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (receiver_id) REFERENCES users(id),
    task_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id)
);

CREATE TABLE favorites (
    customer_id INT UNSIGNED NOT NULL,
    executor_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (customer_id, executor_id),
    FOREIGN KEY (customer_id) REFERENCES users(id),
    FOREIGN KEY (executor_id) REFERENCES users(id)
);
