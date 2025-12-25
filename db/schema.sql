CREATE TABLE user (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1)),
    first_name VARCHAR(100) NOT NULL UNIQUE,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL UNIQUE,
    pw_hash CHAR(512) NOT NULL,

    bio TEXT,
    propic_path VARCHAR(255),

    PRIMARY KEY (id),
);

CREATE TABLE genre (
    genre_name VARCHAR(50) NOT NULL,

    PRIMARY KEY (genre_name),
);

CREATE TABLE author (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1)),
    author_name VARCHAR(100) NOT NULL UNIQUE,

    image_path VARCHAR(255),

    PRIMARY KEY (id),
);

CREATE TABLE disk (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1),

    title VARCHAR(200) NOT NULL,
    disk_type ENUM('EP','ALBUM','SINGLE') NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE track (
    id BINARY(16) NOT NULL DEFAULT (UUID_TO_BIN(UUID(), 1),

    title VARCHAR(200) NOT NULL,
    duration_seconds SMALLINT NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE edition (
    disk_id BINARY(16),
    edition_name VARCHAR(100) NOT NULL,
    release_date DATE NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, edition_name),
);

CREATE TABLE review (
    user_id BINARY(16),
    disk_id BINARY(16),
    ed_name VARCHAR(100),
    publish_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, ed_name) REFERENCES edition(disk_id, edition_name),
    PRIMARY KEY (user_id, disk_id, ed_name),
)

CREATE TABLE featuring (
    author_id BINARY(16) NOT NULL,
    track_id BINARY(16) NOT NULL,

    PRIMARY KEY (author_id, track_id),
)

CREATE TABLE wishlist(
    user_id BINARY(16),
    disk_id BINARY(16),
    ed_name VARCHAR(100),
    date_added DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, ed_name) REFERENCES edition(disk_id, edition_name),
    PRIMARY KEY (user_id, disk_id, ed_name)
);

CREATE TABLE ownership(
    user_id BINARY(16),
    disk_id BINARY(16),
    ed_name VARCHAR(100),
    date_acquired DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (disk_id, ed_name) REFERENCES edition(disk_id, edition_name),
    PRIMARY KEY (user_id, disk_id, ed_name)
)

CREATE TABLE edition_track_part_of (
    disk_id BINARY(16) NOT NULL,
    ed_name VARCHAR(100) NOT NULL,
    track_id BINARY(16) NOT NULL,
    track_number SMALLINT NOT NULL,

    FOREIGN KEY (disk_id, ed_name) REFERENCES edition(disk_id, edition_name) ON DELETE CASCADE,
    FOREIGN KEY (track_id) REFERENCES track(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, ed_name, track_id)
);

CREATE TABLE disk_author_release(
    disk_id BINARY(16) NOT NULL,
    author_id BINARY(16) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES author(id) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, author_id)
)

CREATE TABLE disk_genre_classification(
    disk_id BINARY(16) NOT NULL,
    genre_name VARCHAR(50) NOT NULL,

    FOREIGN KEY (disk_id) REFERENCES disk(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_name) REFERENCES genre(genre_name) ON DELETE CASCADE,
    PRIMARY KEY (disk_id, genre_name)
);