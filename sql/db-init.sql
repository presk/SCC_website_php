CREATE DATABASE IF NOT EXISTS hrc353_2 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE hrc353_2;

SET default_storage_engine=INNODB;

-- The password field will be SHA1 encrypted

CREATE TABLE system_config(
    id INT PRIMARY KEY AUTO_INCREMENT,
    charge_rate DOUBLE
);


CREATE TABLE roles(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_role VARCHAR(50) NOT NULL,
    auth_lvl int NOT NULL
);

CREATE TABLE users(
    id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT NOT NULL,
    username VARCHAR(50) NOT NULL,
    user_password VARCHAR(40) NOT NULL,
    email VARCHAR(50) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    adr_number INT NOT NULL,
    apt_number INT,
    street VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    UNIQUE (username)
);

CREATE TABLE organizations(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    org_name VARCHAR(50) NOT NULL,
    org_type VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE debit_details(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    bank_num INT NOT NULL,
    account_code INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE events(
    id INT PRIMARY KEY AUTO_INCREMENT,
    manager_id INT NOT NULL,
    event_name VARCHAR(50) NOT NULL,
    event_status BOOLEAN,
    fee DOUBLE,
    event_description VARCHAR(250),
    lifetime DATETIME NOT NULL,
    recurring BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (manager_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE event_participants(
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE user_groups(
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    manager_id INT NOT NULL,
    group_name VARCHAR(50),
    group_description VARCHAR(250),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE group_participants(
    user_id INT NOT NULL,
    group_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES user_groups(id) ON DELETE CASCADE
);

CREATE TABLE content (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    type INT NOT NULL,
    content BLOB NOT NULL,
    post_time DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE event_content(
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    content_id INT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (content_id) REFERENCES content(id) ON DELETE CASCADE
);

CREATE TABLE group_content(
    id INT PRIMARY KEY AUTO_INCREMENT,
    group_id INT NOT NULL,
    content_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES user_groups(id) ON DELETE CASCADE,
    FOREIGN KEY (content_id) REFERENCES content(id) ON DELETE CASCADE
);


CREATE TABLE content_comments(
    id INT PRIMARY KEY AUTO_INCREMENT,
    content_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text VARCHAR(250) NOT NULL,
    post_time DATETIME,
    FOREIGN KEY (content_id) REFERENCES content(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE requests(
    id int PRIMARY KEY AUTO_INCREMENT,
    source_id INT NOT NULL,
    dest_id INT NOT NULL,
    group_id INT NOT NULL,
    request_type VARCHAR(7) NOT NULL,
    request_status BOOLEAN NOT NULL,
    FOREIGN KEY (source_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (dest_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES user_groups(id) ON DELETE CASCADE
);

CREATE TABLE messages(
    id INT PRIMARY KEY AUTO_INCREMENT,
    source_id INT NOT NULL,
    dest_id INT NOT NULL,
    message_text VARCHAR(250) NOT NULL,
    sent_time DATETIME NOT NULL,
    soft_delete BOOLEAN DEFAULT FALSE,
    archive_delete BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (source_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (dest_id) REFERENCES users(id) ON DELETE CASCADE
);