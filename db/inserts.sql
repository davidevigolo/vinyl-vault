-- Sample data inserts for Vinyl Vault database

-- Insert users
INSERT INTO user (first_name, last_name, email, pw_hash, bio, propic_path) VALUES
('John', 'Doe', 'john.doe@example.com', 'hash1', 'Music enthusiast and vinyl collector', '/assets/images/users/john.jpg'),
('Jane', 'Smith', 'jane.smith@example.com', 'hash2', 'Jazz lover and audiophile', '/assets/images/users/jane.jpg'),
('Mike', 'Johnson', 'mike.johnson@example.com', 'hash3', 'Rock and roll fan', '/assets/images/users/mike.jpg');

-- Insert genres
INSERT INTO genre (genre_name) VALUES
('Rock'),
('Jazz'),
('Pop'),
('Electronic'),
('Hip Hop'),
('Classical'),
('R&B'),
('Country'),
('Blues'),
('Metal');

-- Insert authors/artists
INSERT INTO author (author_name, image_path) VALUES
('The Beatles', '/assets/images/artists/beatles.jpg'),
('Pink Floyd', '/assets/images/artists/pinkfloyd.jpg'),
('Miles Davis', '/assets/images/artists/milesdavis.jpg'),
('Led Zeppelin', '/assets/images/artists/ledzeppelin.jpg'),
('Radiohead', '/assets/images/artists/radiohead.jpg');

-- Insert disks
INSERT INTO disk (title, disk_type) VALUES
('Abbey Road', 'ALBUM'),
('The Dark Side of the Moon', 'ALBUM'),
('Kind of Blue', 'ALBUM'),
('Led Zeppelin IV', 'ALBUM'),
('OK Computer', 'ALBUM');

-- Insert editions (using variables for disk_id - adjust as needed)
-- Note: You'll need to get actual UUIDs from disk table after insertion
INSERT INTO edition (disk_id, edition_name, release_date) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', '1969-09-26'),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', '2009-09-09'),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', '1973-03-01'),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', '1959-08-17'),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', '1971-11-08'),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release', '1997-05-21');

-- Insert tracks
INSERT INTO track (title, duration_seconds) VALUES
('Come Together', 259),
('Something', 182),
('Here Comes the Sun', 185),
('Breathe', 163),
('Time', 413),
('Money', 382),
('So What', 563),
('Freddie Freeloader', 578),
('Stairway to Heaven', 482),
('Black Dog', 295);

-- Insert disk-author relationships
INSERT INTO disk_author_release (disk_id, author_id) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), (SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Radiohead' LIMIT 1));

-- Insert disk-genre classifications
INSERT INTO disk_genre_classification (disk_id, genre_name) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Pop'),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Jazz'),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Rock');

-- Insert edition-track relationships
INSERT INTO edition_track_part_of (disk_id, ed_name, track_id, track_number) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Come Together' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Something' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Here Comes the Sun' LIMIT 1), 3),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Breathe' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Time' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Money' LIMIT 1), 3);

-- Insert reviews
INSERT INTO review (user_id, disk_id, ed_name, content) VALUES
((SELECT id FROM user WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', 'A masterpiece! One of the greatest albums ever recorded.'),
((SELECT id FROM user WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', 'Essential jazz listening. Miles Davis at his finest.'),
((SELECT id FROM user WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', 'Rock perfection. Stairway to Heaven alone makes this album legendary.');

-- Insert wishlist items
INSERT INTO wishlist (user_id, disk_id, ed_name) VALUES
((SELECT id FROM user WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release'),
((SELECT id FROM user WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release');

-- Insert ownership records
INSERT INTO ownership (user_id, disk_id, ed_name) VALUES
((SELECT id FROM user WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release'),
((SELECT id FROM user WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release'),
((SELECT id FROM user WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release');

-- Insert featuring relationships (for tracks with featured artists)
-- Example: Add more as needed for tracks with multiple artists
INSERT INTO featuring (author_id, track_id) VALUES
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Come Together' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Something' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Here Comes the Sun' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Breathe' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Time' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Money' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1), (SELECT id FROM track WHERE title = 'So What' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1), (SELECT id FROM track WHERE title = 'Freddie Freeloader' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1), (SELECT id FROM track WHERE title = 'Stairway to Heaven' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1), (SELECT id FROM track WHERE title = 'Black Dog' LIMIT 1));
