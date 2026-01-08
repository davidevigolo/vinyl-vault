USE tecweb_db;
CREATE TABLE IF NOT EXISTS users (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1)),
    first_name VARCHAR(100) NOT NULL UNIQUE,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL UNIQUE,
    pw_hash CHAR(255) NOT NULL,

    bio TEXT,
    propic_path VARCHAR(255),

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS genre (
    genre_name VARCHAR(50) NOT NULL,

    PRIMARY KEY (genre_name)
);

CREATE TABLE IF NOT EXISTS author (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1)),
    author_name VARCHAR(100) NOT NULL UNIQUE,

    image_path VARCHAR(255),

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS disk (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1)),

    title VARCHAR(200) NOT NULL,
    disk_type ENUM('EP','ALBUM','SINGLE') NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS track (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1)),

    title VARCHAR(200) NOT NULL,
    duration_seconds SMALLINT NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS edition (
    disk_id BINARY(16),
    edition_name VARCHAR(100) NOT NULL,
    release_date DATE NOT NULL,
    image_path VARCHAR(255),
    country VARCHAR(100) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS review (
    user_id BINARY(16),
    disk_id BINARY(16),
    edition_name VARCHAR(100),
    publish_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    PRIMARY KEY (user_id, disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS featuring (
    author_id BINARY(16) NOT NULL,
    track_id BINARY(16) NOT NULL,

    PRIMARY KEY (author_id, track_id)
);

CREATE TABLE IF NOT EXISTS wishlist(
    user_id BINARY(16),
    disk_id BINARY(16),
    edition_name VARCHAR(100),
    date_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    priority_level TINYINT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    PRIMARY KEY (user_id, disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS ownership(
    user_id BINARY(16),
    disk_id BINARY(16),
    edition_name VARCHAR(100),
    date_acquired DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    PRIMARY KEY (user_id, disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS edition_track_part_of (
    disk_id BINARY(16) NOT NULL,
    edition_name VARCHAR(100) NOT NULL,
    track_id BINARY(16) NOT NULL,
    track_number SMALLINT NOT NULL,

    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    FOREIGN KEY (track_id) REFERENCES track(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, edition_name, track_id)
);

CREATE TABLE IF NOT EXISTS disk_author_release(
    disk_id BINARY(16) NOT NULL,
    author_id BINARY(16) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES author(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, author_id)
);

CREATE TABLE IF NOT EXISTS disk_genre_classification(
    disk_id BINARY(16) NOT NULL,
    genre_name VARCHAR(50) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_name) REFERENCES genre(genre_name) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, genre_name)
);