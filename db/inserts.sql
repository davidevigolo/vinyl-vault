-- Sample data inserts for Vinyl Vault database
USE tecweb_db;

-- Insert genres (no dependencies)
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

-- Insert users (no dependencies)
INSERT INTO users (first_name, last_name, email, pw_hash, bio, propic_path) VALUES
('John', 'Doe', 'john.doe@example.com', '$2y$10$abcdefghijklmnopqrstuv', 'Music enthusiast and vinyl collector', '/assets/images/users/john.jpg'),
('Jane', 'Smith', 'jane.smith@example.com', '$2y$10$bcdefghijklmnopqrstuvw', 'Jazz lover and audiophile', '/assets/images/users/jane.jpg'),
('Mike', 'Johnson', 'mike.johnson@example.com', '$2y$10$cdefghijklmnopqrstuvwx', 'Rock and roll fan', '/assets/images/users/mike.jpg'),
('Sarah', 'Williams', 'sarah.williams@example.com', '$2y$10$defghijklmnopqrstuvwxy', 'Alternative music collector', '/assets/images/users/sarah.jpg');

-- Insert authors/artists (no dependencies)
INSERT INTO author (author_name, image_path) VALUES
('The Beatles', '/assets/images/artists/beatles.jpg'),
('Pink Floyd', '/assets/images/artists/pinkfloyd.jpg'),
('Miles Davis', '/assets/images/artists/milesdavis.jpg'),
('Led Zeppelin', '/assets/images/artists/ledzeppelin.jpg'),
('Radiohead', '/assets/images/artists/radiohead.jpg'),
('Queen', '/assets/images/artists/queen.jpg'),
('David Bowie', '/assets/images/artists/bowie.jpg'),
('Fleetwood Mac', '/assets/images/artists/fleetwoodmac.jpg');

-- Insert disks (no dependencies)
INSERT INTO disk (title, disk_type) VALUES
('Abbey Road', 'ALBUM'),
('The Dark Side of the Moon', 'ALBUM'),
('Kind of Blue', 'ALBUM'),
('Led Zeppelin IV', 'ALBUM'),
('OK Computer', 'ALBUM'),
('A Night at the Opera', 'ALBUM'),
('The Rise and Fall of Ziggy Stardust', 'ALBUM'),
('Rumours', 'ALBUM'),
('Hey Jude', 'SINGLE'),
('Bohemian Rhapsody', 'SINGLE');

-- Insert tracks (no dependencies)
INSERT INTO track (title, duration_seconds) VALUES
('Come Together', 259),
('Something', 182),
('Here Comes the Sun', 185),
('Maxwells Silver Hammer', 207),
('Octopus Garden', 171),
('Breathe', 163),
('Time', 413),
('Money', 382),
('Us and Them', 462),
('So What', 563),
('Freddie Freeloader', 578),
('Blue in Green', 337),
('Stairway to Heaven', 482),
('Black Dog', 295),
('Rock and Roll', 220),
('Paranoid Android', 383),
('Karma Police', 261),
('No Surprises', 228),
('Bohemian Rhapsody', 355),
('Youre my best friend', 172),
('Love of My Life', 218),
('Five Years', 263),
('Starman', 256),
('Dreams', 257),
('Go Your Own Way', 218),
('The Chain', 267),
('Hey Jude', 431);

-- Insert editions (depends on disk)
INSERT INTO edition (disk_id, edition_name, release_date, image_path) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', '1969-09-26', '/assets/images/covers/abbey-road-original.jpg'),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', '2009-09-09', '/assets/images/covers/abbey-road-remastered.jpg'),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', '1973-03-01', '/assets/images/covers/darkside-original.jpg'),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), '50th Anniversary', '2023-03-24', '/assets/images/covers/darkside-50th.jpg'),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', '1959-08-17', '/assets/images/covers/kindofblue-original.jpg'),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', '1971-11-08', '/assets/images/covers/ledzep4-original.jpg'),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release', '1997-05-21', '/assets/images/covers/okcomputer-original.jpg'),
((SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Original Release', '1975-11-21', '/assets/images/covers/nightopera-original.jpg'),
((SELECT id FROM disk WHERE title = 'The Rise and Fall of Ziggy Stardust' LIMIT 1), 'Original Release', '1972-06-16', '/assets/images/covers/ziggy-original.jpg'),
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Original Release', '1977-02-04', '/assets/images/covers/rumours-original.jpg'),
((SELECT id FROM disk WHERE title = 'Hey Jude' LIMIT 1), 'Original 7" Single', '1968-08-26', '/assets/images/covers/heyjude-single.jpg'),
((SELECT id FROM disk WHERE title = 'Bohemian Rhapsody' LIMIT 1), 'Original 7" Single', '1975-10-31', '/assets/images/covers/bohemianrhapsody-single.jpg');

-- Insert disk-author relationships (depends on disk and author)
INSERT INTO disk_author_release (disk_id, author_id) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), (SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Radiohead' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Queen' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'The Rise and Fall of Ziggy Stardust' LIMIT 1), (SELECT id FROM author WHERE author_name = 'David Bowie' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Fleetwood Mac' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Hey Jude' LIMIT 1), (SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1)),
((SELECT id FROM disk WHERE title = 'Bohemian Rhapsody' LIMIT 1), (SELECT id FROM author WHERE author_name = 'Queen' LIMIT 1));

-- Insert disk-genre classifications (depends on disk and genre)
INSERT INTO disk_genre_classification (disk_id, genre_name) VALUES
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Pop'),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Jazz'),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'The Rise and Fall of Ziggy Stardust' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Pop'),
((SELECT id FROM disk WHERE title = 'Hey Jude' LIMIT 1), 'Rock'),
((SELECT id FROM disk WHERE title = 'Hey Jude' LIMIT 1), 'Pop'),
((SELECT id FROM disk WHERE title = 'Bohemian Rhapsody' LIMIT 1), 'Rock');

-- Insert edition-track relationships (depends on edition and track)
INSERT INTO edition_track_part_of (disk_id, edition_name, track_id, track_number) VALUES

((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Come Together' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Something' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Maxwells Silver Hammer' LIMIT 1), 3),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Octopus Garden' LIMIT 1), 4),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Here Comes the Sun' LIMIT 1), 5),
-- Abbey Road Remastered
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', (SELECT id FROM track WHERE title = 'Come Together' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', (SELECT id FROM track WHERE title = 'Something' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', (SELECT id FROM track WHERE title = 'Maxwells Silver Hammer' LIMIT 1), 3),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', (SELECT id FROM track WHERE title = 'Octopus Garden' LIMIT 1), 4),
((SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009', (SELECT id FROM track WHERE title = 'Here Comes the Sun' LIMIT 1), 5),
-- Dark Side of the Moon
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Breathe' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Time' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Money' LIMIT 1), 3),
((SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Us and Them' LIMIT 1), 4),
-- Kind of Blue
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'So What' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Freddie Freeloader' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Blue in Green' LIMIT 1), 3),
-- Led Zeppelin IV
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Black Dog' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Rock and Roll' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Stairway to Heaven' LIMIT 1), 4),
-- OK Computer
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Paranoid Android' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Karma Police' LIMIT 1), 6),
((SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'No Surprises' LIMIT 1), 11),
-- A Night at the Opera
((SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Bohemian Rhapsody' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Youre my best friend' LIMIT 1), 3),
((SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Love of My Life' LIMIT 1), 9),
-- Ziggy Stardust
((SELECT id FROM disk WHERE title = 'The Rise and Fall of Ziggy Stardust' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Five Years' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'The Rise and Fall of Ziggy Stardust' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Starman' LIMIT 1), 4),
-- Rumours
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Dreams' LIMIT 1), 2),
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'Go Your Own Way' LIMIT 1), 5),
((SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Original Release', (SELECT id FROM track WHERE title = 'The Chain' LIMIT 1), 10),
-- Singles
((SELECT id FROM disk WHERE title = 'Hey Jude' LIMIT 1), 'Original 7" Single', (SELECT id FROM track WHERE title = 'Hey Jude' LIMIT 1), 1),
((SELECT id FROM disk WHERE title = 'Bohemian Rhapsody' LIMIT 1), 'Original 7" Single', (SELECT id FROM track WHERE title = 'Bohemian Rhapsody' LIMIT 1), 1);

-- Insert featuring relationships (depends on author and track)
INSERT INTO featuring (author_id, track_id) VALUES
-- The Beatles
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Come Together' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Something' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Here Comes the Sun' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Maxwells Silver Hammer' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Octopus Garden' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'The Beatles' LIMIT 1), (SELECT id FROM track WHERE title = 'Hey Jude' LIMIT 1)),
-- Pink Floyd
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Breathe' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Time' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Money' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Pink Floyd' LIMIT 1), (SELECT id FROM track WHERE title = 'Us and Them' LIMIT 1)),
-- Miles Davis
((SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1), (SELECT id FROM track WHERE title = 'So What' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1), (SELECT id FROM track WHERE title = 'Freddie Freeloader' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Miles Davis' LIMIT 1), (SELECT id FROM track WHERE title = 'Blue in Green' LIMIT 1)),
-- Led Zeppelin
((SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1), (SELECT id FROM track WHERE title = 'Stairway to Heaven' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1), (SELECT id FROM track WHERE title = 'Black Dog' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Led Zeppelin' LIMIT 1), (SELECT id FROM track WHERE title = 'Rock and Roll' LIMIT 1)),
-- Radiohead
((SELECT id FROM author WHERE author_name = 'Radiohead' LIMIT 1), (SELECT id FROM track WHERE title = 'Paranoid Android' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Radiohead' LIMIT 1), (SELECT id FROM track WHERE title = 'Karma Police' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Radiohead' LIMIT 1), (SELECT id FROM track WHERE title = 'No Surprises' LIMIT 1)),
-- Queen
((SELECT id FROM author WHERE author_name = 'Queen' LIMIT 1), (SELECT id FROM track WHERE title = 'Bohemian Rhapsody' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Queen' LIMIT 1), (SELECT id FROM track WHERE title = 'Youre my best friend' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Queen' LIMIT 1), (SELECT id FROM track WHERE title = 'Love of My Life' LIMIT 1)),
-- David Bowie
((SELECT id FROM author WHERE author_name = 'David Bowie' LIMIT 1), (SELECT id FROM track WHERE title = 'Five Years' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'David Bowie' LIMIT 1), (SELECT id FROM track WHERE title = 'Starman' LIMIT 1)),
-- Fleetwood Mac
((SELECT id FROM author WHERE author_name = 'Fleetwood Mac' LIMIT 1), (SELECT id FROM track WHERE title = 'Dreams' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Fleetwood Mac' LIMIT 1), (SELECT id FROM track WHERE title = 'Go Your Own Way' LIMIT 1)),
((SELECT id FROM author WHERE author_name = 'Fleetwood Mac' LIMIT 1), (SELECT id FROM track WHERE title = 'The Chain' LIMIT 1));

-- Insert reviews (depends on users and editions)
INSERT INTO review (user_id, disk_id, edition_name, content) VALUES
((SELECT id FROM users WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release', 'A masterpiece! One of the greatest albums ever recorded. The medley on side B is absolutely transcendent.'),
((SELECT id FROM users WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release', 'Essential jazz listening. Miles Davis at his finest. This album defined modal jazz.'),
((SELECT id FROM users WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release', 'Rock perfection. Stairway to Heaven alone makes this album legendary.'),
((SELECT id FROM users WHERE email = 'sarah.williams@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release', 'A groundbreaking album that predicted the digital age. Still relevant today.'),
((SELECT id FROM users WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release', 'An absolute classic. The production quality is mind-blowing for 1973.'),
((SELECT id FROM users WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Original Release', 'Beautiful songwriting, incredible harmonies. A timeless classic.'),
((SELECT id FROM users WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Original Release', 'Queen at their peak. Bohemian Rhapsody changed rock music forever.');

-- Insert wishlist items (depends on users and editions)
INSERT INTO wishlist (user_id, disk_id, edition_name) VALUES
((SELECT id FROM users WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), '50th Anniversary'),
((SELECT id FROM users WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'The Rise and Fall of Ziggy Stardust' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'sarah.williams@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Remastered 2009'),
((SELECT id FROM users WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release');

-- Insert ownership records (depends on users and editions)
INSERT INTO ownership (user_id, disk_id, edition_name) VALUES
((SELECT id FROM users WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Abbey Road' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Kind of Blue' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Led Zeppelin IV' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'sarah.williams@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'OK Computer' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'john.doe@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'The Dark Side of the Moon' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'jane.smith@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Rumours' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'mike.johnson@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'A Night at the Opera' LIMIT 1), 'Original Release'),
((SELECT id FROM users WHERE email = 'sarah.williams@example.com' LIMIT 1), (SELECT id FROM disk WHERE title = 'Hey Jude' LIMIT 1), 'Original 7" Single');

-- Views

CREATE VIEW vinyl AS(
  SELECT wl.disk_id, wl.edition_name, d.title, au.author_name, ed.image_path
                  FROM wishlist as wl
                  JOIN edition  as ed on wl.disk_id = ed.disk_id AND wl.edition_name = ed.edition_name 
                  JOIN disk_author_release as dar on dar.disk_id = wl.disk_id
    			  JOIN disk as d on d.id = wl.disk_id
                  JOIN author as au on au.id = dar.author_id
);

CREATE VIEW wishlist_count(disk_id,edition_name,wl_count) AS(
  SELECT wl.disk_id,wl.edition_name,COUNT(*)
  FROM wishlist as wl
  GROUP BY wl.disk_id, wl.edition_name
);
