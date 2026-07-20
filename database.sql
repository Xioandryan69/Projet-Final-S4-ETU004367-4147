PRAGMA foreign_keys = ON;

CREATE TABLE Role (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL
);

INSERT INTO Role (name) VALUES ('admin'), ('rh'), ('user');

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    role_id INTEGER DEFAULT 3,
    FOREIGN KEY (role_id) REFERENCES Role (id)
);

INSERT INTO
    users (
        username,
        email,
        password,
        role_id
    )
VALUES (
        'admin',
        'admin@example.com',
        'hashed_password',
        1
    ),
    (
        'rh',
        'rh@example.com',
        'hashed_password',
        2
    ),
    (
        'user',
        'user@example.com',
        'hashed_password',
        3
    );