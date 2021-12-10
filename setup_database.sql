DROP DATABASE IF EXISTS pineapplepizza;
CREATE DATABASE IF NOT EXISTS pineapplepizza CHARACTER SET 'utf8';

CREATE OR REPLACE TABLE pineapplepizza.user (
    id VARCHAR(13) NOT NULL,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    createdAt DATETIME NOT NULL,
    admin BOOLEAN NOT NULL,
    PRIMARY KEY(id)
);

CREATE OR REPLACE TABLE pineapplepizza.post (
    id VARCHAR(13) NOT NULL,
    userId VARCHAR(13) NOT NULL,
	title TEXT NOT NULL,
	content TEXT NOT NULL,
    createdAt DATETIME NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (userId) REFERENCES pineapplepizza.user(id)
);

CREATE OR REPLACE TABLE pineapplepizza.comment (
    id VARCHAR(13) NOT NULL,
    userId VARCHAR(13) NOT NULL,
    postId VARCHAR(13) NOT NULL,
	content TEXT NOT NULL,
    createdAt DATETIME NOT NULL,
    FOREIGN KEY (userId) REFERENCES pineapplepizza.user(id),
    FOREIGN KEY (postId) REFERENCES pineapplepizza.post(id)
);