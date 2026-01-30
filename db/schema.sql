USE tecweb_db;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL UNIQUE,
    pw_hash VARCHAR(255) NOT NULL, -- see why 255 at https://www.php.net/manual/en/function.password-hash.php
    is_admin TINYINT(1) NOT NULL DEFAULT 0,

    bio TEXT,
    propic_path VARCHAR(255),

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS genre (
    genre_name VARCHAR(50) NOT NULL,

    PRIMARY KEY (genre_name)
);

CREATE TABLE IF NOT EXISTS author (
    id INT AUTO_INCREMENT,
    author_name VARCHAR(100) NOT NULL UNIQUE,
    nationality VARCHAR(100),
    image_path VARCHAR(255),

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS disk (
    id INT AUTO_INCREMENT,
    label VARCHAR(100),

    title VARCHAR(200) NOT NULL,
    disk_type ENUM('EP','ALBUM','SINGLE') NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS track (
    id INT AUTO_INCREMENT,

    title VARCHAR(200) NOT NULL,
    duration_seconds SMALLINT NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS edition (
    disk_id INT,
    edition_name VARCHAR(100) NOT NULL,
    release_date DATE NOT NULL,
    image_path VARCHAR(255),
    country VARCHAR(100) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS review (
    user_id INT,
    disk_id INT,
    edition_name VARCHAR(100),
    publish_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    PRIMARY KEY (user_id, disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS featuring (
    author_id INT NOT NULL,
    track_id INT NOT NULL,

    PRIMARY KEY (author_id, track_id)
);

CREATE TABLE IF NOT EXISTS wishlist(
    user_id INT,
    disk_id INT,
    edition_name VARCHAR(100),
    date_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    priority_level TINYINT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    PRIMARY KEY (user_id, disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS ownership(
    user_id INT,
    disk_id INT,
    edition_name VARCHAR(100),
    date_acquired DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rating TINYINT DEFAULT NULL CHECK (rating >= 0 AND rating <= 5),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    PRIMARY KEY (user_id, disk_id, edition_name)
);

CREATE TABLE IF NOT EXISTS edition_track_part_of (
    disk_id INT NOT NULL,
    edition_name VARCHAR(100) NOT NULL,
    track_id INT NOT NULL,
    track_number SMALLINT NOT NULL,

    FOREIGN KEY (disk_id, edition_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    FOREIGN KEY (track_id) REFERENCES track(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, edition_name, track_id)
);

CREATE TABLE IF NOT EXISTS disk_author_release(
    disk_id INT NOT NULL,
    author_id INT NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES author(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, author_id)
);

CREATE TABLE IF NOT EXISTS disk_genre_classification(
    disk_id INT NOT NULL,
    genre_name VARCHAR(50) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_name) REFERENCES genre(genre_name) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, genre_name)
);

-- View per contare gli album nelle wishlist
CREATE OR REPLACE VIEW wishlist_count AS
SELECT disk_id, edition_name, COUNT(*) as wl_count
FROM wishlist
GROUP BY disk_id, edition_name;

-- Index per velocizzare
CREATE INDEX idx_ownership_user ON ownership(user_id);
CREATE INDEX idx_ownership_disk_edition ON ownership(disk_id, edition_name);
CREATE INDEX idx_ownership_date ON ownership(date_acquired);
CREATE INDEX idx_wishlist_user ON wishlist(user_id);
CREATE INDEX idx_dar_disk ON disk_author_release(disk_id);
CREATE INDEX idx_dar_author ON disk_author_release(author_id);
CREATE INDEX idx_author_name ON author(author_name);
CREATE INDEX idx_edition_lookup ON edition(disk_id, edition_name);