-- Sample data inserts for VinylVault database
-- Disable foreign key checks for smooth import
SET FOREIGN_KEY_CHECKS = 0;

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
INSERT INTO users (first_name, last_name, username, email, pw_hash, bio, propic_path, is_admin) VALUES
('Maria', 'Rossi','admin', 'admin@admin.com', '$2y$10$j8Hsc4sabUF5Kv9NfbRTMu/W9aWIzECeTSZEACtqnJ1QeKbN6.KNm' /*admin*/, 'Music enthusiast and vinyl collector', 'assets/images/users/admin.jpg', 1),
('Stan', 'Smith', 'user', 'user@user.com', '$2y$10$IERZN9gEazLu0ot6Wb.gBerkvFZLnJEAiQOeR3ainGlxA..L2u9c.' /*user*/, 'Jazz lover and audiophile', 'assets/images/users/user.jpg', 0),
('Mike', 'Johnson', 'mikeJohn1234', 'mike.johnson@example.com', '$2y$10$cdefghijklmnopqrstuvwx', 'Rock and roll fan', 'assets/images/users/mike.jpg', 0),
('Sarah', 'Williams', 'sssaaraahh','sarah.williams@example.com', '$2y$10$defghijklmnopqrstuvwxy', 'Alternative music collector', 'assets/images/users/sarah.jpg', 0);


-- Insert authors/artists (no dependencies)
-- Insert authors/artists con Bio concise (ideali per Mobile)
INSERT INTO author (author_name, image_path, nationality, bio_author) VALUES
('Taylor Swift', 'assets/images/artists/taylorswift.jpg', 'us', 'Icona del pop globale nota per la sua scrittura narrativa e la capacità di reinventarsi in ogni "Era" della sua carriera.'),
('Dua Lipa', 'assets/images/artists/dualipa.jpg', 'uk', 'Cantante britannica che ha ridefinito il pop contemporaneo fondendo sonorità disco-pop anni ''80 e produzione moderna.'),
('Ariana Grande', 'assets/images/artists/arianagrande.jpg', 'us', 'Popstar internazionale celebre per la sua straordinaria estensione vocale e i successi che spaziano tra R&B e pop teatrale.'),
('The Weeknd', 'assets/images/artists/theweeknd.jpg', 'ca', 'Artista canadese pioniere del dark R&B e del synth-pop cinematografico, con hit mondiali che dominano le classifiche.'),
('The Beatles', 'assets/images/artists/beatles.jpg', 'uk', 'Leggendaria band di Liverpool che ha rivoluzionato la musica e la cultura popolare influenzando ogni generazione successiva.'),
('Radiohead', 'assets/images/artists/radiohead.jpg', 'uk', 'Gruppo rock sperimentale britannico acclamato per la costante innovazione sonora e album che hanno cambiato la musica alternativa.'),
('Linkin Park', 'assets/images/artists/linkinpark.jpg', 'us', 'Band iconica che ha fuso rock, rap ed elettronica, diventando la voce di una generazione con testi onesti e potenti.'),
('Lana Del Rey', 'assets/images/artists/lanadelrey.jpg', 'us', 'Cantautrice celebre per il suo stile malinconico e cinematografico che richiama l''estetica e il fascino dell''Americana vintage.'),
('BABYMETAL', 'assets/images/artists/babymetal.jpg', 'jp', 'Fenomeno giapponese che fonde J-pop e heavy metal estremo, creando l''unico ed energico genere conosciuto come "Kawaii Metal".'),
('Pink Floyd', 'assets/images/artists/pinkfloyd.jpg', 'uk', 'Maestri del rock progressivo e psichedelico, celebri per concept album filosofici e sperimentazioni sonore leggendarie.'),
('Pinguini Tattici Nucleari', 'assets/images/artists/ptn.jpg', 'it', 'Protagonisti dell''indie-pop italiano, amati per testi ironici e citazionisti che raccontano con freschezza la quotidianità.'),
('5 Seconds of Summer', 'assets/images/artists/5sos.jpg', 'au', 'Band australiana evolutasi dal pop-punk a un pop-rock maturo e sperimentale, nota per le grandi doti vocali e le performance live.'),
('Madonna', 'assets/images/artists/madonna.jpg', 'us', 'La Regina del Pop e icona culturale eterna, celebre per la continua reinvenzione e per aver sfidato i limiti dell''industria musicale.'),
('Annalisa', 'assets/images/artists/annalisa.jpg', 'it', 'Cantautrice italiana tra le più apprezzate del momento, capace di spaziare con successo tra pop elettronico e ballate raffinate.'),
('Nirvana', 'assets/images/artists/nirvana.jpg', 'us', 'Band simbolo del movimento grunge degli anni ''90 che, guidata da Kurt Cobain, ha cambiato per sempre il volto del rock mondiale.'),
('AC/DC', 'assets/images/artists/acdc.jpg', 'au', 'Pilastri dell''hard rock mondiale, famosi per i loro riff elettrizzanti e un''energia inarrestabile che attraversa cinque decenni.'),
('The Rolling Stones', 'assets/images/artists/rollingstones.jpg', 'uk', 'L''essenza stessa del rock ''n'' roll britannico, con una carriera leggendaria, un carisma senza tempo e hit immortali.'),
('SZA', 'assets/images/artists/sza.jpg', 'us', 'Voce di spicco dell''R&B contemporaneo, acclamata dalla critica per la sua vulnerabilità e per testi profondamente onesti e personali.');


-- Insert disks (no dependencies)
INSERT INTO disk (title, disk_type, label) VALUES
-- Taylor Swift
('1989', 'Album', 'Big Machine Records'),
('reputation', 'Album', 'Big Machine Records'),
('Lover', 'Album', 'Republic Records'),
('folklore', 'Album', 'Republic Records'),
('Midnights', 'Album', 'Republic Records'),
('The Taylor Swift Holiday Collection', 'EP', 'Big Machine Records'),
('Beautiful Eyes', 'EP', 'Big Machine Records'),
('Shake It Off', 'Single', 'Big Machine Records'),
('Blank Space', 'Single', 'Big Machine Records'),
('Anti-Hero', 'Single', 'Republic Records'),


-- Dua Lipa
('Dua Lipa', 'Album', 'Warner Records'),
('Future Nostalgia', 'Album', 'Warner Records'),
('Radical Optimism', 'Album', 'Warner Records'),
('Be the One', 'Single', 'Warner Records'),
('New Rules', 'Single', 'Warner Records'),
('Levitating', 'Single', 'Warner Records'),
('Houdini', 'Single', 'Warner Records'),
('Training Season', 'Single', 'Warner Records'),
('Illusion', 'Single', 'Warner Records'),

-- Ariana Grande
('Dangerous Woman', 'Album', 'Republic Records'),
('Sweetener', 'Album', 'Republic Records'),
('thank u, next', 'Album', 'Republic Records'),
('Positions', 'Album', 'Republic Records'),
('eternal sunshine', 'Album', 'Republic Records'),
('7 rings', 'Single', 'Republic Records'),
('yes, and?', 'Single', 'Republic Records'),
('we can''t be friends (wait for your love)', 'Single', 'Republic Records'),

-- The Weeknd
('Starboy', 'Album', 'XO/Republic Records'),
('After Hours', 'Album', 'XO/Republic Records'),
('Dawn FM', 'Album', 'XO/Republic Records'),
('House of Balloons', 'EP', 'XO/Republic Records'),
('My Dear Melancholy,', 'EP', 'XO/Republic Records'),
('Blinding Lights', 'Single', 'XO/Republic Records'),
('Save Your Tears', 'Single', 'XO/Republic Records'),
('Dancing In The Flames', 'Single', 'XO/Republic Records'),

-- The Beatles
('Magical Mystery Tour', 'Album', 'Apple Records'),
('The Beatles (White Album)', 'Album', 'Apple Records'),
('Yellow Submarine', 'Album', 'Apple Records'),
('Abbey Road', 'Album', 'Apple Records'),
('Let It Be', 'Album', 'Apple Records'),
('Long Tall Sally', 'EP', 'Parlophone'),
('Magical Mystery Tour (EP)', 'EP', 'Parlophone'),
('Hey Jude', 'Single', 'Apple Records'),
('Let It Be', 'Single', 'Apple Records'),
('Now and Then', 'Single', 'Apple Records'),

-- Radiohead
('Hail to the Thief', 'Album', 'Parlophone'),
('In Rainbows', 'Album', 'XL Recordings'),
('The King of Limbs', 'Album', 'XL Recordings'),
('A Moon Shaped Pool', 'Album', 'XL Recordings'),
('Airbag / How Am I Driving?', 'EP', 'Parlophone'),
('Karma Police', 'Single', 'Parlophone'),
('No Surprises', 'Single', 'Parlophone'),

-- Linkin Park
('The Hunting Party', 'Album', 'Warner Bros. Records'),
('One More Light', 'Album', 'Warner Bros. Records'),
('From Zero', 'Album', 'Warner Bros. Records'),
('Hybrid Theory EP', 'EP', 'Warner Bros. Records'),
('In the End', 'Single', 'Warner Bros. Records'),
('Numb', 'Single', 'Warner Bros. Records'),

-- Lana Del Rey
('Lana Del Ray', 'Album', 'Polydor Records'),
('Born to Die', 'Album', 'Interscope Records'),
('Ultraviolence', 'Album', 'Interscope Records'),
('Honeymoon', 'Album', 'Interscope Records'),
('Lasso', 'Album', 'Interscope Records'),
('Paradise', 'EP', 'Interscope Records'),
('Tropico', 'EP', 'Interscope Records'),
('Video Games', 'Single', 'Interscope Records'),
('Summertime Sadness', 'Single', 'Interscope Records'),
('Young and Beautiful', 'Single', 'Interscope Records'),

-- BABYMETAL
('Babymetal', 'Album', 'Toy\'s Factory'),
('Metal Resistance', 'Album', 'Toy\'s Factory'),
('Metal Galaxy', 'Album', 'Toy\'s Factory'),
('The Other One', 'Album', 'Toy\'s Factory'),
('Gimme Chocolate!!', 'Single', 'Toy\'s Factory'),
('Road of Resistance', 'Single', 'Toy\'s Factory'),

-- Pink Floyd
('The Wall', 'Album', 'Columbia Records'),
('The Final Cut', 'Album', 'Columbia Records'),
('A Momentary Lapse of Reason', 'Album', 'Columbia Records'),
('The Division Bell', 'Album', 'Columbia Records'),
('The Endless River', 'Album', 'Columbia Records'),
('See Emily Play', 'Single', 'Columbia Records'),
('Money', 'Single', 'Harvest Records'),
('Hey Hey Rise Up', 'Single', 'Parlophone'),

-- Pinguini Tattici Nucleari
('Fuori dall''hype', 'Album', 'Sony Music'),
('Fake News', 'Album', 'Sony Music'),
('Hello World', 'Album', 'Sony Music'),
('Ahia!', 'EP', 'Sony Music'),
('Pastello bianco', 'Single', 'Sony Music'),
('Ricordi', 'Single', 'Sony Music'),
('Rubami la notte', 'Single', 'Sony Music'),
('Romantico ma muori', 'Single', 'Sony Music'),

-- 5 Seconds of Summer
('5 Seconds of Summer', 'Album', 'Capitol Records'),
('Sounds Good Feels Good', 'Album', 'Capitol Records'),
('Youngblood', 'Album', 'Capitol Records'),
('Calm', 'Album', 'Interscope Records'),
('5SOS5', 'Album', 'BMG Rights Management'),
('She Looks So Perfect EP', 'EP', 'Capitol Records'),
('Don''t Stop EP', 'EP', 'Capitol Records'),
('She Looks So Perfect', 'Single', 'Capitol Records'),
('Youngblood', 'Single', 'Capitol Records'),
('Teeth', 'Single', 'Interscope Records'),
('Lighter', 'Single', 'BMG Rights Management'),

-- Madonna
('Confessions on a Dance Floor', 'Album', 'Warner Bros. Records'),
('Hard Candy', 'Album', 'Warner Bros. Records'),
('MDNA', 'Album', 'Interscope Records'),
('Rebel Heart', 'Album', 'Interscope Records'),
('Madame X', 'Album', 'Interscope Records'),
('Holiday', 'Single', 'Sire Records'),
('Like a Virgin', 'Single', 'Sire Records'),
('Vogue', 'Single', 'Sire Records'),
('Hung Up', 'Single', 'Warner Bros. Records'),
('Popular', 'Single', 'Warner Bros. Records'),

-- Annalisa
('Bye Bye', 'Album', 'Warner Music Italy'),
('Nuda', 'Album', 'Warner Music Italy'),
('E poi siamo finiti nel vortice', 'Album', 'Warner Music Italy'),
('Bellissima', 'Single', 'Warner Music Italy'),
('Mon Amour', 'Single', 'Warner Music Italy'),
('Ragazza Sola', 'Single', 'Warner Music Italy'),
('Sinceramente', 'Single', 'Warner Music Italy'),

-- Nirvana
('Bleach', 'Album', 'Sub Pop'),
('Nevermind', 'Album', 'DGC Records'),
('In Utero', 'Album', 'DGC Records'),
('Hormoaning', 'EP', 'DGC Records'),
('Smells Like Teen Spirit', 'Single', 'DGC Records'),
('Come as You Are', 'Single', 'DGC Records'),
('Lithium', 'Single', 'DGC Records'),
('Heart-Shaped Box', 'Single', 'DGC Records'),

-- AC/DC
('Stiff Upper Lip', 'Album', 'Columbia Records'),
('Black Ice', 'Album', 'Columbia Records'),
('Rock or Bust', 'Album', 'Columbia Records'),
('Power Up', 'Album', 'Columbia Records'),
('''74 Jailbreak', 'EP', 'Atlantic Records'),
('Thunderstruck', 'Single', 'Atlantic Records'),
('Shot in the Dark', 'Single', 'Columbia Records'),

-- The Rolling Stones
('Bridges to Babylon', 'Album', 'Virgin Records'),
('A Bigger Bang', 'Album', 'Virgin Records'),
('Blue & Lonesome', 'Album', 'Interscope Records'),
('Hackney Diamonds', 'Album', 'Interscope Records'),
('Five by Five', 'EP', 'Decca Records'),
('Got Live If You Want It!', 'EP', 'Decca Records'),
('Start Me Up', 'Single', 'Rolling Stones Records'),
('Angry', 'Single', 'Interscope Records'),

-- SZA
('Ctrl', 'Album', 'Top Dawg Entertainment'),
('SOS', 'Album', 'Top Dawg Entertainment'),
('Lana', 'Album', 'Top Dawg Entertainment'),
('See.SZA.Run', 'EP', 'Top Dawg Entertainment'),
('S', 'EP', 'Top Dawg Entertainment'),
('Z', 'EP', 'Top Dawg Entertainment'),
('Kill Bill', 'Single', 'Top Dawg Entertainment'),
('Saturn', 'Single', 'Top Dawg Entertainment');


-- Mapping tra dischi e autori
INSERT INTO disk_author_release (disk_id, author_id) VALUES
-- Taylor Swift (Author ID: 1)
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), (10, 1),

-- Dua Lipa (Author ID: 2)
(11, 2), (12, 2), (13, 2), (14, 2), (15, 2), (16, 2), (17, 2), (18, 2), (19, 2),

-- Ariana Grande (Author ID: 3)
(20, 3), (21, 3), (22, 3), (23, 3), (24, 3), (25, 3), (26, 3), (27, 3),

-- The Weeknd (Author ID: 4)
(28, 4), (29, 4), (30, 4), (31, 4), (32, 4), (33, 4), (34, 4), (35, 4),

-- The Beatles (Author ID: 5)
(36, 5), (37, 5), (38, 5), (39, 5), (40, 5), (41, 5), (42, 5), (43, 5), (44, 5), (45, 5),

-- Radiohead (Author ID: 6)
(46, 6), (47, 6), (48, 6), (49, 6), (50, 6), (51, 6), (52, 6),

-- Linkin Park (Author ID: 7)
(53, 7), (54, 7), (55, 7), (56, 7), (57, 7), (58, 7),

-- Lana Del Rey (Author ID: 8)
(59, 8), (60, 8), (61, 8), (62, 8), (63, 8), (64, 8), (65, 8), (66, 8), (67, 8), (68, 8),

-- BABYMETAL (Author ID: 9)
(69, 9), (70, 9), (71, 9), (72, 9), (73, 9), (74, 9),

-- Pink Floyd (Author ID: 10)
(75, 10), (76, 10), (77, 10), (78, 10), (79, 10), (80, 10), (81, 10), (82, 10),

-- Pinguini Tattici Nucleari (Author ID: 11)
(83, 11), (84, 11), (85, 11), (86, 11), (87, 11), (88, 11), (89, 11), (90, 11),

-- 5 Seconds of Summer (Author ID: 12)
(91, 12), (92, 12), (93, 12), (94, 12), (95, 12), (96, 12), (97, 12), (98, 12), (99, 12), (100, 12), (101, 12),

-- Madonna (Author ID: 13)
(102, 13), (103, 13), (104, 13), (105, 13), (106, 13), (107, 13), (108, 13), (109, 13), (110, 13), (111, 13),

-- Annalisa (Author ID: 14)
(112, 14), (113, 14), (114, 14), (115, 14), (116, 14), (117, 14), (118, 14),

-- Nirvana (Author ID: 15)
(119, 15), (120, 15), (121, 15), (122, 15), (123, 15), (124, 15), (125, 15), (126, 15),

-- AC/DC (Author ID: 16)
(127, 16), (128, 16), (129, 16), (130, 16), (131, 16), (132, 16), (133, 16),

-- The Rolling Stones (Author ID: 17)
(134, 17), (135, 17), (136, 17), (137, 17), (138, 17), (139, 17), (140, 17), (141, 17),

-- SZA (Author ID: 18)
(142, 18), (143, 18), (144, 18), (145, 18), (146, 18), (147, 18), (148, 18), (149, 18);


-- Disks genres
INSERT INTO disk_genre_classification (disk_id, genre_name) VALUES
-- Taylor Swift (IDs 1-10)
(1, 'Pop'), (2, 'Pop'), (2, 'Electronic'), (3, 'Pop'), (4, 'Rock'), (5, 'Pop'), (5, 'Electronic'),
(6, 'Country'), (6, 'Pop'), (7, 'Country'), (8, 'Pop'), (9, 'Pop'), (10, 'Pop'),

-- Dua Lipa (IDs 11-19)
(11, 'Pop'), (12, 'Pop'), (13, 'Pop'), (14, 'Pop'), (15, 'Pop'), (16, 'Pop'), (17, 'Pop'), (18, 'Pop'), (19, 'Pop'),

-- Ariana Grande (IDs 20-27)
(20, 'Pop'), (20, 'R&B'), (21, 'Pop'), (22, 'Pop'), (22, 'R&B'), (23, 'Pop'), (23, 'R&B'), 
(24, 'Pop'), (24, 'R&B'), (25, 'Pop'), (26, 'Pop'), (27, 'Pop'),

-- The Weeknd (IDs 28-35)
(28, 'Pop'), (28, 'R&B'), (29, 'Pop'), (29, 'R&B'), (30, 'Pop'), (30, 'Electronic'), 
(31, 'R&B'), (32, 'R&B'), (33, 'Pop'), (34, 'Pop'), (35, 'Pop'),

-- The Beatles (IDs 36-45)
(36, 'Rock'), (36, 'Pop'), (37, 'Rock'), (37, 'Pop'), (38, 'Rock'), (39, 'Rock'), (40, 'Rock'), 
(41, 'Rock'), (42, 'Rock'), (43, 'Pop'), (44, 'Rock'), (45, 'Rock'),

-- Radiohead (IDs 46-52)
(46, 'Rock'), (47, 'Rock'), (48, 'Electronic'), (49, 'Rock'), (49, 'Electronic'), (50, 'Rock'), (51, 'Rock'), (52, 'Rock'),

-- Linkin Park (IDs 53-58)
(53, 'Rock'), (54, 'Rock'), (54, 'Pop'), (55, 'Rock'), (55, 'Metal'), (56, 'Rock'), (57, 'Rock'), (58, 'Rock'),

-- Lana Del Rey (IDs 59-68)
(59, 'Pop'), (60, 'Pop'), (61, 'Rock'), (62, 'Pop'), (63, 'Country'), (64, 'Pop'), (65, 'Pop'), 
(66, 'Pop'), (67, 'Pop'), (68, 'Pop'),

-- BABYMETAL (IDs 69-74)
(69, 'Metal'), (69, 'Pop'), (70, 'Metal'), (71, 'Metal'), (71, 'Electronic'), (72, 'Metal'), (73, 'Pop'), (74, 'Metal'),

-- Pink Floyd (IDs 75-82)
(75, 'Rock'), (76, 'Rock'), (77, 'Rock'), (78, 'Rock'), (79, 'Rock'), (80, 'Rock'), (81, 'Rock'), (82, 'Rock'),

-- Pinguini Tattici Nucleari (IDs 83-90)
(83, 'Pop'), (83, 'Rock'), (84, 'Pop'), (85, 'Pop'), (86, 'Pop'), (87, 'Pop'), (88, 'Pop'), (89, 'Pop'), (90, 'Pop'),

-- 5 Seconds of Summer (IDs 91-101)
(91, 'Pop'), (91, 'Rock'), (92, 'Rock'), (93, 'Pop'), (94, 'Pop'), (94, 'Electronic'), (95, 'Pop'), 
(96, 'Rock'), (97, 'Rock'), (98, 'Pop'), (99, 'Pop'), (100, 'Pop'), (101, 'Pop'),

-- Madonna (IDs 102-111)
(102, 'Pop'), (102, 'Electronic'), (103, 'Pop'), (103, 'Electronic'), (104, 'Pop'), (105, 'Pop'), (106, 'Electronic'), 
(107, 'Pop'), (108, 'Pop'), (109, 'Pop'), (110, 'Electronic'), (111, 'Pop'),

-- Annalisa (IDs 112-118)
(112, 'Pop'), (113, 'Pop'), (114, 'Pop'), (114, 'Electronic'), (115, 'Pop'), (116, 'Pop'), (117, 'Pop'), (118, 'Pop'),

-- Nirvana (IDs 119-126)
(119, 'Rock'), (120, 'Rock'), (121, 'Rock'), (122, 'Rock'), (123, 'Rock'), (124, 'Rock'), (125, 'Rock'), (126, 'Rock'),

-- AC/DC (IDs 127-133)
(127, 'Rock'), (128, 'Rock'), (129, 'Rock'), (130, 'Rock'), (131, 'Rock'), (132, 'Rock'), (133, 'Rock'),

-- The Rolling Stones (IDs 134-141)
(134, 'Rock'), (135, 'Rock'), (136, 'Rock'), (136, 'Blues'), (137, 'Rock'), (138, 'Rock'), (139, 'Rock'), (140, 'Rock'), (141, 'Rock'),

-- SZA (IDs 142-149)
(142, 'R&B'), (143, 'R&B'), (143, 'Hip Hop'), (144, 'R&B'), (145, 'R&B'), (146, 'R&B'), (147, 'R&B'), (148, 'Pop'), (149, 'R&B');


-- Tracks
INSERT INTO track (title, duration_seconds) VALUES
-- Taylor Swift (1989, reputation, Lover, folklore, Midnights, Holiday Collection, Beautiful Eyes)
('Welcome To New York', 212), ('Blank Space', 231), ('Style', 231), ('Out Of The Woods', 235), ('All You Had To Do Was Stay', 193), ('Shake It Off', 202), ('I Wish You Would', 207), ('Bad Blood', 211), ('Wildest Dreams', 220), ('How You Get The Girl', 247), ('This Love', 250), ('I Know Places', 195), ('Clean', 270),
('...Ready For It?', 208), ('End Game', 244), ('I Did Something Bad', 238), ('Don''t Blame Me', 236), ('Delicate', 232), ('Look What You Made Me Do', 211), ('So It Goes...', 227), ('Gorgeous', 209), ('Getaway Car', 233), ('King Of My Heart', 214), ('Dancing With Our Hands Tied', 211), ('Dress', 230), ('Nice Things', 207), ('Call It What You Want', 203), ('New Year''s Day', 235),
('I Forgot That You Existed', 171), ('Cruel Summer', 178), ('Lover', 221), ('The Man', 190), ('The Archer', 211), ('I Think He Knows', 173), ('Miss Americana & The Heartbreak Prince', 234), ('Paper Rings', 222), ('Cornelia Street', 287), ('Death By A Thousand Cuts', 199), ('London Boy', 190), ('Soon You''ll Get Better', 202), ('False God', 200), ('You Need To Calm Down', 171), ('Afterglow', 223), ('ME!', 193), ('It''s Nice To Have A Friend', 150), ('Daylight', 293),
('the 1', 210), ('cardigan', 239), ('the last great american dynasty', 231), ('exile', 285), ('my tears ricochet', 255), ('mirrorball', 209), ('seven', 208), ('august', 261), ('this is me trying', 195), ('illicit affairs', 190), ('invisible string', 252), ('mad woman', 237), ('epiphany', 289), ('betty', 294), ('peace', 234), ('hoax', 220),
('Lavender Haze', 202), ('Maroon', 218), ('Anti-Hero', 200), ('Snow On The Beach', 256), ('You''re On Your Own, Kid', 194), ('Midnight Rain', 174), ('Question...?', 210), ('Vigilante Shit', 164), ('Bejeweled', 194), ('Labyrinth', 247), ('Karma', 204), ('Sweet Nothing', 188), ('Mastermind', 191),
('Beautiful Eyes', 179), ('I Heart ?', 195),

-- Dua Lipa (Dua Lipa, Future Nostalgia, Radical Optimism)
('Genesis', 205), ('Lost In Your Light', 203), ('Hotter Than Hell', 187), ('Be the One', 202), ('IDGAF', 217), ('Blow Your Mind (Mwah)', 178), ('Garden', 227), ('No Goodbyes', 213), ('New Rules', 209), ('Begging', 189), ('Homesick', 230),
('Future Nostalgia', 184), ('Don''t Start Now', 183), ('Cool', 209), ('Physical', 193), ('Levitating', 203), ('Pretty Please', 194), ('Hallucinate', 208), ('Love Again', 258), ('Break My Heart', 221), ('Good In Bed', 218), ('Boys Will Be Boys', 166),
('End of an Era', 196), ('Houdini', 185), ('Training Season', 209), ('These Walls', 217), ('Whatcha Doing', 198), ('French Exit', 201), ('Illusion', 188), ('Falling Forever', 223), ('Anything for Love', 142), ('Maria', 187), ('Happy for You', 226),

-- Ariana Grande (Dangerous Woman, Sweetener, thank u, next, Positions, eternal sunshine)
('Moonlight', 202), ('Dangerous Woman', 235), ('Be Alright', 179), ('Into You', 244), ('Side To Side', 226), ('Let Me Love You', 223), ('Greedy', 214), ('Leave Me Lonely', 229), ('Everyday', 194), ('Bad Decisions', 226), ('Thinking Bout You', 200),
('raindrops (an angel cried)', 37), ('blazed', 196), ('the light is coming', 228), ('R.E.M', 245), ('God is a woman', 197), ('sweetener', 208), ('successful', 227), ('everytime', 172), ('breathin', 198), ('no tears left to cry', 205), ('borderline', 165), ('better off', 151), ('goodnight n go', 189), ('pete davidson', 73), ('get well soon', 322),
('imagine', 212), ('needy', 171), ('NASA', 182), ('bloodline', 216), ('fake smile', 208), ('bad idea', 267), ('make up', 140), ('ghostin', 271), ('in my head', 222), ('7 rings', 178), ('thank u, next', 207), ('break up with your girlfriend, i''m bored', 190),
('shut up', 157), ('34+35', 173), ('motive', 167), ('just like magic', 149), ('off the table', 239), ('six thirty', 183), ('safety net', 208), ('my hair', 158), ('nasty', 200), ('west side', 132), ('love language', 179), ('positions', 172), ('obvious', 146), ('POV', 201),
('intro (end of the world)', 92), ('bye', 164), ('don''t wanna break up again', 191), ('saturn returns interlude', 42), ('eternal sunshine', 210), ('supernatural', 163), ('true story', 163), ('the boy is mine', 173), ('yes, and?', 214), ('we can''t be friends (wait for your love)', 228), ('i wish i hated you', 153), ('imperfect for you', 182), ('ordinary things', 178),

-- The Weeknd (Starboy, After Hours, Dawn FM, House of Balloons, My Dear Melancholy)
('Starboy', 230),('Party Monster', 249),('False Alarm', 220),('Reminder', 219),('Rockin''', 233),('Secrets', 263),('True Colors', 180),('Stargirl Interlude', 112),('Sidewalks', 231),('Six Feet Under', 238),('Love to Lay', 223),('A Lonely Night', 220),('Attention', 198),('Ordinary Life', 221),
('Nothing Without You', 199),('All I Know', 321),('Die For You', 260),('I Feel It Coming', 269),('Professional', 368), ('The Town', 307), ('Adaptation', 283), ('Love In The Sky', 267), ('Belong To The World', 307), ('Live For', 224), ('Wanderlust', 306), ('Kiss Land', 455), ('Pretty', 375), ('Tears In The Rain', 444),('Lonely Star', 349), ('Life Of The Party', 297), ('Trust Issues', 281), ('The Morning', 315), ('Wicked Games', 324), ('The Party & The After Party', 459), ('Coming Down', 295), ('Loft Music', 364), ('The Knowing', 341),
('Alone Again', 250), ('Too Late', 239), ('Hardest To Love', 211), ('Scared To Live', 191), ('Snowchild', 247), ('Escape From LA', 355), ('Heartless', 198), ('Faith', 283), ('Blinding Lights', 200), ('In Your Eyes', 237), ('Save Your Tears', 215), ('After Hours', 362), ('Until I Bleed Out', 190),
('Gasoline', 212), ('How Do I Make You Love Me?', 214), ('Take My Breath', 186), ('Sacrifice', 189), ('A Tale By Quincy', 96), ('Out of Time', 214), ('Here We Go... Again', 209), ('Best Friends', 163), ('Is There Someone Else?', 199), ('Starry Eyes', 148), ('Every Angel is Terrifying', 167), ('Don''t Break My Heart', 205), ('I Heard You''re Married', 263), ('Less Than Zero', 213), ('Phantom Regret by Jim', 179),
('Dancing In The Flames', 220), ('Hurry Up Tomorrow', 235), ('Wake Me Up', 210),

-- The Beatles (Magical Mystery Tour, White Album, Yellow Submarine, Abbey Road, Let It Be)
('I Saw Her Standing There', 175), ('Misery', 109), ('Please Please Me', 119), ('Love Me Do', 142), ('Twist And Shout', 155),
('It Won''t Be Long', 133), ('All My Loving', 128), ('Roll Over Beethoven', 165), ('I Wanna Be Your Man', 120),
('A Hard Day''s Night', 154), ('And I Love Her', 150), ('Can''t Buy Me Love', 132),
('No Reply', 135), ('Eight Days A Week', 164), ('Help!', 138), ('Yesterday', 125),
('Drive My Car', 145), ('Norwegian Wood', 121), ('Nowhere Man', 160), ('Michelle', 160), ('In My Life', 144),
('Taxman', 159), ('Eleanor Rigby', 126), ('Yellow Submarine', 158), ('Tomorrow Never Knows', 177),
('Sgt. Pepper''s Lonely Hearts Club Band', 122), ('With A Little Help From My Friends', 164), ('Lucy In The Sky With Diamonds', 208), ('A Day In The Life', 333),
('Back In The U.S.S.R.', 163), ('While My Guitar Gently Weeps', 285), ('Blackbird', 138), ('Helter Skelter', 269),
('Come Together', 259), ('Something', 183), ('Here Comes The Sun', 185), ('The End', 141),
('Let It Be', 243), ('Get Back', 187), ('Hey Jude', 431), ('Now and Then', 248),

-- Radiohead (Hail to the Thief, In Rainbows, The King of Limbs, A Moon Shaped Pool)
('You', 209), ('Creep', 236), ('Stop Whispering', 326),
('Planet Telex', 259), ('The Bends', 246), ('High and Dry', 257), ('Fake Plastic Trees', 307), ('Street Spirit (Fade Out)', 253),
('Airbag', 284), ('Paranoid Android', 383), ('Subterranean Homesick Alien', 267), ('Exit Music (For A Film)', 264), ('Karma Police', 261), ('No Surprises', 228),
('Everything In Its Right Place', 251), ('Kid A', 284), ('The National Anthem', 351), ('How To Disappear Completely', 356), ('Idioteque', 309),
('Packt Like Sardines in a Crushd Tin Box', 240), ('Pyramid Song', 289), ('Knives Out', 255),
('2 + 2 = 5', 199), ('There There', 323),
('15 Step', 238), ('Bodysnatchers', 242), ('Nude', 255), ('Weird Fishes/Arpeggi', 318), ('All I Need', 228), ('Reckoner', 290),
('Bloom', 315), ('Lotus Flower', 301),
('Burn The Witch', 220), ('Daydreaming', 384), ('Decks Dark', 281), ('True Love Waits', 287),

-- Linkin Park (The Hunting Party, One More Light, From Zero)
('Papercut', 184), ('One Step Closer', 155), ('Crawling', 209), ('In The End', 216),
('Don''t Stay', 187), ('Somewhere I Belong', 213), ('Lying From You', 175), ('Faint', 162), ('Numb', 187),
('Wake', 100), ('Given Up', 189), ('Leave Out All The Rest', 209), ('Bleed It Out', 164), ('Shadow Of The Day', 289), ('What I''ve Done', 205),
('The Catalyst', 339), ('Waiting For The End', 231),
('Lost In The Echo', 205), ('Burn It Down', 230), ('Castle Of Glass', 205),
('Guilty All The Same', 353), ('Final Masquerade', 217),
('One More Light', 255), ('Heavy', 169),
('The Emptiness Machine', 191), ('Heavy Is the Crown', 167), ('Over Each Other', 170),

-- Lana Del Rey (Lana Del Ray, Born to Die, Ultraviolence, Honeymoon, Paradise, Tropico)
('Born To Die', 286), ('Off To The Races', 300), ('Blue Jeans', 210), ('Video Games', 282), ('Summertime Sadness', 265), ('National Anthem', 231),
('Ride', 289), ('American', 248), ('Cola', 259), ('Gods & Monsters', 237),
('Cruel World', 400), ('Ultraviolence', 251), ('Shades Of Cool', 342), ('Brooklyn Baby', 351), ('West Coast', 257),
('Honeymoon', 410), ('Music To Watch Boys To', 291), ('High By The Beach', 258), ('Terrence Loves You', 291),
('Love', 272), ('Lust For Life', 264), ('13 Beaches', 295), ('Cherry', 180), ('White Mustang', 164),
('Norman Fucking Rockwell', 248), ('Mariners Apartment Complex', 246), ('Venice Bitch', 577), ('Fuck It I Love You', 218), ('The Greatest', 300), ('Hope Is A Dangerous Thing...', 324),
('White Dress', 333), ('Chemtrails Over The Country Club', 271),
('Blue Banisters', 300), ('Arcadia', 264),
('The Grants', 295), ('Did You Know That There''s a Tunnel Under Ocean Blvd', 285), ('A&W', 427), ('Candy Necklace', 314),
('Lasso', 240), ('Tough', 180),

-- BABYMETAL (Babymetal, Metal Resistance, Metal Galaxy, The Other One)
('BABYMETAL DEATH', 348), ('Megitsune', 249), ('Gimme Chocolate!!', 243), ('Iine!', 251), ('Akatsuki', 327), ('Headbangeeeeerrrrr!!!!!', 242), ('Ijime, Dame, Zettai', 366),
('Road of Resistance', 318), ('KARATE', 263), ('Awadama Fever', 253), ('THE ONE', 629),
('Future Metal', 125), ('DA DA DANCE', 230), ('PA PA YA!!', 235), ('Distortion', 184),
('Metal Kingdom', 351), ('Divine Attack - Shingeki -', 219), ('Monochrome', 237), ('THE LEGEND', 407),
('RATATATA', 179),

-- Pink Floyd (The Wall, The Final Cut, A Momentary Lapse of Reason, The Division Bell, The Endless River)
('Astronomy Domine', 252), ('Lucifer Sam', 187), ('Interstellar Overdrive', 581), ('See Emily Play', 174),
('Let There Be More Light', 333), ('Set the Controls for the Heart of the Sun', 328), ('A Saucerful of Secrets', 712),
('Atom Heart Mother', 1424), ('Summer ''68', 328),
('One of These Days', 357), ('Echoes', 1410),
('Free Four', 252), ('Stay', 247),
('Speak to Me', 65), ('Breathe (In the Air)', 169), ('On the Run', 215), ('Time', 421), ('The Great Gig in the Sky', 273), ('Money', 382), ('Us and Them', 462), ('Any Colour You Like', 205), ('Brain Damage', 228), ('Eclipse', 123),
('Shine On You Crazy Diamond (Parts I–V)', 812), ('Welcome to the Machine', 452), ('Have a Cigar', 308), ('Wish You Were Here', 334), ('Shine On You Crazy Diamond (Parts VI–IX)', 751),
('Pigs on the Wing 1', 85), ('Dogs', 1024), ('Pigs (Three Different Ones)', 682), ('Sheep', 622), ('Pigs on the Wing 2', 85),
('In the Flesh?', 196), ('The Thin Ice', 147), ('Another Brick in the Wall, Part 1', 191), ('The Happiest Days of Our Lives', 112), ('Another Brick in the Wall, Part 2', 239), ('Mother', 332), ('Goodbye Blue Sky', 165), ('Young Lust', 208), ('One of My Turns', 214), ('Comfortably Numb', 382), ('Run Like Hell', 260),
('The Fletcher Memorial Home', 251), ('The Final Cut', 286),
('Learning to Fly', 293), ('On the Turning Away', 342),
('High Hopes', 511), ('Keep Talking', 371),
('Louder than Words', 396),
('Hey Hey Rise Up', 206),

-- Pinguini Tattici Nucleari (Fuori dall'hype, Fake News, Hello World, Ahia!)
('Cancelleria', 224), ('Test di Medicina', 226),
('Tetris', 212), ('Irene', 185), ('Verdura', 230),
('Sashimi', 225), ('Fuori dall''hype', 232), ('Antartide', 208), ('Ringo Starr', 191), ('Ridere', 214), ('La storia di un impiegato', 234),
('Scrivile scemo', 215), ('Bohémien', 194), ('Pastello bianco', 236), ('Ahia!', 231),
('Giovani Wannabe', 213), ('Ricordi', 204), ('Dentista Croazia', 263), ('Zen', 198), ('Rubami la notte', 190),
('Romantico ma muori', 205), ('Hello World', 212),

-- 5 Seconds of Summer (5SOS, Sounds Good Feels Good, Youngblood, Calm, 5SOS5, EPs)
('She Looks So Perfect', 202), ('Don''t Stop', 169), ('Good Girls', 207), ('Amnesia', 237),
('Hey Everybody!', 196), ('Jet Black Heart', 221), ('She''s Kicking 20', 195),
('Youngblood', 203), ('Want You Back', 173), ('Lie to Me', 150), ('Ghost of You', 197),
('Old Me', 184), ('Easier', 157), ('Teeth', 204), ('No Shame', 190), ('Wildflower', 220),
('Complete Mess', 206), ('Take My Hand', 239), ('Bad Omens', 215), ('Lighter', 172),

-- Madonna (Confessions, Hard Candy, MDNA, Rebel Heart, Madame X)
('Lucky Star', 337), ('Borderline', 318), ('Holiday', 368), ('Like a Virgin', 191), ('Material Girl', 240), ('Angel', 221), ('Into the Groove', 283), ('Papa Don''t Preach', 269), ('Open Your Heart', 253), ('La Isla Bonita', 242), ('Like a Prayer', 341), ('Express Yourself', 279), ('Cherish', 243), ('Vogue', 289), ('Justify My Love', 300), ('Erotica', 312), ('Deeper and Deeper', 333), ('Secret', 304), ('Bedtime Story', 289), ('Ray of Light', 276), ('Frozen', 372), ('Music', 224), ('Don''t Tell Me', 280), ('American Life', 298), ('Hollywood', 264), ('Hung Up', 336), ('Sorry', 283), ('4 Minutes', 184), ('Give It 2 Me', 288), ('Girl Gone Wild', 223), ('Living for Love', 218), ('Medellín', 298), ('Popular', 212),

-- Annalisa (Bye Bye, Nuda, Vortice)
('Diamante lei e luce lui', 209), ('Senza riserva', 180), ('Alice e il blu', 238), ('A modo mio amo', 221), ('Scintille', 188), ('Sento solo il presente', 230), ('Una finestra tra le stelle', 192), ('Vincerò', 201), ('Il diluvio universale', 204), ('Se avessi un cuore', 174), ('Direzione la vita', 210), ('Il mondo prima di te', 218), ('Bye Bye', 256), ('Dieci', 198), ('Movimento lento', 193), ('Bellissima', 213), ('Mon Amour', 203), ('Ragazza Sola', 211), ('Euforia', 179), ('Sinceramente', 215),

-- Nirvana (Bleach, Nevermind, In Utero, Hormoaning)
('Blew', 175), ('Floyd the Barber', 138), ('About a Girl', 168), ('Smells Like Teen Spirit', 301), ('In Bloom', 254), ('Come as You Are', 219), ('Breed', 183), ('Lithium', 257), ('Polly', 177), ('Drain You', 223), ('Stay Away', 212), ('Something in the Way', 232), ('Serve the Servants', 216), ('Heart-Shaped Box', 281), ('Rape Me', 170), ('Dumb', 152), ('Pennyroyal Tea', 217), ('All Apologies', 231), ('You Know You''re Right', 218),

-- AC/DC (Stiff Upper Lip, Black Ice, Rock or Bust, Power Up, '74 Jailbreak)
('Baby, Please Don''t Go', 290), ('High Voltage', 243), ('It''s a Long Way to the Top', 301), ('The Jack', 352), ('T.N.T.', 214), ('Dirty Deeds Done Dirt Cheap', 251), ('Big Balls', 158), ('Whole Lotta Rosie', 324), ('Let There Be Rock', 366), ('Highway to Hell', 208), ('Girls Got Rhythm', 203), ('Touch Too Much', 267), ('If You Want Blood (You''ve Got It)', 277), ('Hells Bells', 312), ('Shoot to Thrill', 317), ('Back in Black', 255), ('You Shook Me All Night Long', 210), ('For Those About to Rock (We Salute You)', 344), ('Thunderstruck', 292), ('Moneytalks', 225), ('Are You Ready', 250), ('Hard as a Rock', 271), ('Rock or Bust', 183), ('Shot in the Dark', 186),

-- The Rolling Stones (Bridges to Babylon, A Bigger Bang, Blue & Lonesome, Hackney Diamonds)
('Route 66', 140), ('Not Fade Away', 108), ('(I Can''t Get No) Satisfaction', 223), ('Get Off of My Cloud', 155), ('Paint It, Black', 202), ('Lady Jane', 188), ('Ruby Tuesday', 196), ('Let''s Spend the Night Together', 216), ('Jumpin'' Jack Flash', 222), ('Sympathy for the Devil', 378), ('Gimme Shelter', 271), ('You Can''t Always Get What You Want', 448), ('Brown Sugar', 228), ('Wild Horses', 342), ('Rocks Off', 271), ('Angie', 273), ('It''s Only Rock ''n Roll', 307), ('Miss You', 288), ('Beast of Burden', 265), ('Emotional Rescue', 339), ('Start Me Up', 213), ('Undercover of the Night', 272), ('Mixed Emotions', 279), ('Love Is Strong', 229), ('Angry', 226), ('Sweet Sounds of Heaven', 442),

-- SZA (Ctrl, SOS, Lana, EPs)
('Supermodel', 181), ('Love Galore', 275), ('Doves in the Wind', 266), ('The Weekend', 272), ('Garden (Say It Like Dat)', 208), ('Broken Clocks', 231), ('Drew Barrymore', 231), ('Good Days', 279), ('I Hate U', 174), ('Shirt', 181), ('Kill Bill', 153), ('Snooze', 201), ('Nobody Gets Me', 180), ('Low', 181), ('Saturn', 186),

-- Taylor Swift Holiday Collection (Disk 6)
('Last Christmas', 203), ('Christmas When You Were Mine', 186),
-- My Dear Melancholy, (Disk 32)
('Call Out My Name', 228), ('Try Me', 221),
-- The Beatles - Magical Mystery Tour (Disk 36)
('Magical Mystery Tour', 171), ('The Fool on the Hill', 168), ('I Am the Walrus', 276),
-- The Beatles - Yellow Submarine (Disk 38)
('Only a Northern Song', 204), ('All Together Now', 131), ('Hey Bulldog', 191),
-- The Beatles - Long Tall Sally (Disk 41)
('Long Tall Sally', 123), ('I Call Your Name', 129),
-- The Beatles - Magical Mystery Tour EP (Disk 42)
('Your Mother Should Know', 149), ('Hello, Goodbye', 211),
-- Linkin Park - Hybrid Theory EP (Disk 56)
('Carousel', 180), ('Technique', 40),
-- Lana Del Rey - Lana Del Ray (Disk 59)
('Kill Kill', 237), ('Queen of the Gas Station', 224), ('Gramma', 230),
-- Lana Del Rey - Tropico (Disk 65)
('Body Electric', 233), ('Bel Air', 239),
-- Pink Floyd - The Endless River (Disk 79)
('Things Left Unsaid', 266), ('It''s What We Do', 357), ('Ebb and Flow', 115),
-- PTN - Hello World (Disk 85)
('Hello World', 212), ('Melting Pot', 200), ('Nightmare', 185),
-- 5SOS - Sounds Good Feels Good (Disk 92)
('Money', 174), ('She''s Kicking 20', 195), ('Castaway', 214),
-- 5SOS - Don't Stop EP (Disk 97)
('Don''t Stop', 169), ('Rejects', 169),
-- Madonna - Hard Candy (Disk 103)
('Candy Shop', 255), ('Miles Away', 288), ('She''s Not Me', 365),
-- Madonna - MDNA (Disk 104)
('Girl Gone Wild', 223), ('Gang Bang', 285), ('I''m Addicted', 273),
-- Madonna - Rebel Heart (Disk 105)
('Living for Love', 218), ('Devil Pray', 245), ('Ghosttown', 251),
-- Madonna - Madame X (Disk 106 - Aggiunta)
('Dark Ballet', 254), ('God Control', 379),
-- Annalisa - Bye Bye (Disk 112)
('Ogni festa', 198), ('Il mondo prima di te', 218), ('Un domani', 223),
-- Annalisa - Nuda (Disk 113 - Aggiunta)
('Nuda', 181), ('Tsunami', 194),

-- Aggiunte
('The Lakes', 211), ('Mirrorball (Live)', 232), ('Invisible String (Instrumental)', 252), -- folklore extras
('Hits Different', 234), ('You''re Losing Me', 278), ('Snow on the Beach (Feat. More Lana)', 230), -- Midnights extras
('Houdini (Extended Edit)', 359), ('Training Season (Vinyl Version)', 305), ('Illusion (Alternative Mix)', 220), -- Radical Optimism extras
('Sweetener Live', 208), ('Breathin (Acapella)', 198), ('Eternal Sunshine Mix', 210), -- Ariana extras
('Abbey Road Medley', 960), ('Yellow Submarine (Alt)', 158), ('Now and Then (Extended)', 300), -- Beatles extras
('Decks Dark (Live)', 281), ('Ful Stop (Live)', 360), ('Identikit (Live)', 287), -- Radiohead extras



-- Pink Floyd / Madonna / Annalisa Extras
('Poles Apart', 424), ('Craving', 201), ('I Don''t Search I Find', 298), ('Graffiti', 210),
-- Nirvana (Hormoaning)
('Aneurysm', 276), ('Even in His Youth', 183),
-- AC/DC (Stiff Upper Lip, Black Ice, Rock or Bust)
('Stiff Upper Lip', 215), ('Can''t Stop Rock ''n'' Roll', 242), ('Safe in New York City', 233),
('Rock ''n'' Roll Train', 261), ('Big Jack', 237), ('War Machine', 189),
('Rock or Bust', 183), ('Play Ball', 167), ('Rock the Blues Away', 204),
-- Rolling Stones (Bridges to Babylon, A Bigger Bang, Blue & Lonesome)
('Flip the Switch', 208), ('Anybody Seen My Baby?', 271), ('Saint of Me', 315),
('Rough Justice', 191), ('Rain Fall Down', 294), ('Streets of Love', 310),
('Just Your Fool', 136), ('Commit a Crime', 218), ('Blue and Lonesome', 312),
-- Rolling Stones (EP Extras)
('2120 South Michigan Avenue', 218), ('Under My Thumb (Live)', 220), ('Get Off of My Cloud (Live)', 175),
-- SZA (Lana, See.SZA.Run, S, Z)
('Lana Intro', 90), ('New Song 1', 180), ('New Song 2', 210),
('Bed', 235), ('Euphraxia', 210), ('Castles', 189), ('Aftermath', 221), ('Ur', 235), ('Child''s Play', 216);


-- Editions
INSERT INTO edition (disk_id, edition_name, release_date, image_path, country) VALUES
-- Taylor Swift (IDs 1-23)
(1, 'Standard Edition', '2014-10-27', 'assets/images/editions/1989_std.jpg', 'US'),
(1, 'Crystal Skies Blue Edition', '2023-10-27', 'assets/images/editions/1989_blue.jpg', 'US'),
(2, 'Standard Edition', '2017-11-10', 'assets/images/editions/rep_std.jpg', 'US'),
(2, 'Picture Disc Edition', '2017-11-10', 'assets/images/editions/rep_pic.jpg', 'US'),
(3, 'Pink & Blue Edition', '2019-08-23', 'assets/images/editions/lover_colored.jpg', 'US'),
(4, 'Standard Edition', '2020-07-24', 'assets/images/editions/folk_std.jpg', 'US'),
(4, 'Meet Me Behind The Mall (Grey Edition)', '2020-07-24', 'assets/images/editions/folk_grey.jpg', 'US'),
(5, 'Moonstone Blue Edition', '2022-10-21', 'assets/images/editions/mid_blue.jpg', 'US'),
(5, 'Blood Moon Edition', '2022-10-21', 'assets/images/editions/mid_orange.jpg', 'US'),
(6, 'Standard Edition', '2007-10-14', 'assets/images/editions/ts_holiday.jpg', 'US'),
(7, 'Standard Edition', '2008-07-15', 'assets/images/editions/ts_eyes.jpg', 'US'),
(8, 'Standard Single', '2014-08-18', 'assets/images/editions/ts_shake.jpg', 'US'),
(9, 'Standard Single', '2014-11-10', 'assets/images/editions/ts_blank.jpg', 'US'),
(10, 'Standard Single', '2022-10-21', 'assets/images/editions/ts_antihero.jpg', 'US'),

-- Dua Lipa (IDs 24-32)
(11, 'Standard Edition', '2017-06-02', 'assets/images/editions/dua_std.jpg', 'UK'),
(11, 'Pink Edition', '2017-06-02', 'assets/images/editions/dua_pink.jpg', 'UK'),
(12, 'Standard Edition', '2020-03-27', 'assets/images/editions/future_std.jpg', 'UK'),
(12, 'Neon Pink Edition', '2020-03-27', 'assets/images/editions/future_pink.jpg', 'UK'),
(13, 'Standard Edition', '2024-05-03', 'assets/images/editions/radical_std.jpg', 'UK'),
(13, 'Red Edition', '2024-05-03', 'assets/images/editions/radical_red.jpg', 'UK'),
(14, 'Standard Single', '2015-08-21', 'assets/images/editions/dua_beone.jpg', 'UK'),
(15, 'Standard Single', '2017-07-21', 'assets/images/editions/dua_rules.jpg', 'UK'),
(16, 'Standard Single', '2020-08-13', 'assets/images/editions/dua_lev.jpg', 'UK'),
(17, 'Standard Single', '2023-11-09', 'assets/images/editions/dua_houdini.jpg', 'UK'),
(18, 'Standard Single', '2024-02-15', 'assets/images/editions/dua_train.jpg', 'UK'),
(19, 'Standard Single', '2024-04-11', 'assets/images/editions/dua_illusion.jpg', 'UK'),

-- Ariana Grande (IDs 33-46)
(20, 'Standard Edition', '2016-05-20', 'assets/images/editions/dangerous_std.jpg', 'US'),
(21, 'Standard Edition', '2018-08-17', 'assets/images/editions/sweet_std.jpg', 'US'),
(21, 'Peach Edition', '2018-08-17', 'assets/images/editions/sweet_peach.jpg', 'US'),
(22, 'Standard Edition', '2019-02-08', 'assets/images/editions/tun_std.jpg', 'US'),
(23, 'Coke Bottle Clear Edition', '2020-10-30', 'assets/images/editions/pos_clear.jpg', 'US'),
(24, 'Standard Edition', '2024-03-08', 'assets/images/editions/eternal_std.jpg', 'US'),
(24, 'Ruby Edition', '2024-03-08', 'assets/images/editions/eternal_red.jpg', 'US'),
(25, 'Standard Single', '2019-01-18', 'assets/images/editions/ari_7rings.jpg', 'US'),
(26, 'Standard Single', '2024-01-12', 'assets/images/editions/ari_yesand.jpg', 'US'),
(27, 'Standard Single', '2024-03-08', 'assets/images/editions/ari_friends.jpg', 'US'),

-- The Weeknd (IDs 47-60)
(28, 'Standard Edition', '2016-11-25', 'assets/images/editions/star_std.jpg', 'US'),
(28, 'Translucent Red Edition', '2016-11-25', 'assets/images/editions/star_red.jpg', 'US'),
(29, 'Standard Edition', '2020-03-20', 'assets/images/editions/after_std.jpg', 'US'),
(29, 'Gold with Red Splatter Edition', '2020-03-20', 'assets/images/editions/after_splatter.jpg', 'US'),
(30, 'Standard Edition', '2022-01-07', 'assets/images/editions/dawn_std.jpg', 'US'),
(30, 'Silver Edition', '2022-01-07', 'assets/images/editions/dawn_silver.jpg', 'US'),
(31, 'Standard Edition', '2011-03-21', 'assets/images/editions/balloons_std.jpg', 'US'),
(32, 'Standard Edition', '2018-03-30', 'assets/images/editions/melancholy_std.jpg', 'US'),
(33, 'Standard Single', '2019-11-29', 'assets/images/editions/weeknd_blinding.jpg', 'US'),
(34, 'Standard Single', '2020-08-09', 'assets/images/editions/weeknd_save.jpg', 'US'),
(35, 'Standard Single', '2024-09-13', 'assets/images/editions/weeknd_flames.jpg', 'US'),

-- The Beatles (IDs 61-81)
(36, 'Standard Edition', '1967-11-27', 'assets/images/editions/mmt_std.jpg', 'US'),
(37, 'Standard Edition', '1968-11-22', 'assets/images/editions/white_std.jpg', 'UK'),
(37, 'White Edition', '1978-01-01', 'assets/images/editions/white_colored.jpg', 'UK'),
(38, 'Standard Edition', '1969-01-13', 'assets/images/editions/ys_std.jpg', 'UK'),
(39, 'Standard Edition', '1969-09-26', 'assets/images/editions/ar_std.jpg', 'UK'),
(40, 'Standard Edition', '1970-05-08', 'assets/images/editions/lib_std.jpg', 'UK'),
(41, 'Standard Edition', '1964-06-19', 'assets/images/editions/longtallsally_std.jpg', 'UK'),
(42, 'Standard Edition', '1967-12-08', 'assets/images/editions/mmt_ep_std.jpg', 'UK'),
(43, 'Standard Single', '1968-08-26', 'assets/images/editions/beatles_heyjude.jpg', 'UK'),
(44, 'Standard Single', '1970-03-06', 'assets/images/editions/beatles_letitbe.jpg', 'UK'),
(45, 'Standard Edition', '2023-11-02', 'assets/images/editions/nat_std.jpg', 'UK'),
(45, 'Marble Blue Edition', '2023-11-02', 'assets/images/editions/nat_blue.jpg', 'UK'),

-- Radiohead (IDs 82-97)
(46, 'Standard Edition', '2003-06-09', 'assets/images/editions/htt_std.jpg', 'UK'),
(47, 'Standard Edition', '2007-10-10', 'assets/images/editions/ir_std.jpg', 'UK'),
(48, 'Standard Edition', '2011-02-18', 'assets/images/editions/kol_std.jpg', 'UK'),
(49, 'Standard Edition', '2016-05-08', 'assets/images/editions/amsp_std.jpg', 'UK'),
(49, 'Opaque White Edition', '2016-06-17', 'assets/images/editions/amsp_white.jpg', 'UK'),
(50, 'Standard EP', '1997-04-21', 'assets/images/editions/airbag_std.jpg', 'UK'),
(51, 'Standard Single', '1997-08-25', 'assets/images/editions/karma_std.jpg', 'UK'),
(52, 'Standard Single', '1998-01-12', 'assets/images/editions/surprises_std.jpg', 'UK'),

-- Linkin Park (IDs 98-111)
(53, 'Standard Edition', '2014-06-13', 'assets/images/editions/hp_std.jpg', 'US'),
(54, 'Standard Edition', '2017-05-19', 'assets/images/editions/oml_std.jpg', 'US'),
(55, 'Standard Edition', '2024-11-15', 'assets/images/editions/fz_std.jpg', 'US'),
(55, 'Blue Edition', '2024-11-15', 'assets/images/editions/fz_blue.jpg', 'US'),
(56, 'Standard EP', '1999-05-01', 'assets/images/editions/ht_ep_std.jpg', 'US'),
(57, 'Standard Single', '2001-10-24', 'assets/images/editions/lp_intend.jpg', 'US'),
(58, 'Standard Single', '2003-09-08', 'assets/images/editions/lp_numb.jpg', 'US'),

-- Lana Del Rey (IDs 112-127)
(59, 'Standard Edition', '2010-01-04', 'assets/images/editions/lana_ray_std.jpg', 'US'),
(60, 'Standard Edition', '2012-01-27', 'assets/images/editions/btd_std.jpg', 'US'),
(60, 'Red Edition', '2012-01-27', 'assets/images/editions/btd_red.jpg', 'US'),
(61, 'Standard Edition', '2014-06-13', 'assets/images/editions/ultra_std.jpg', 'US'),
(61, 'Blue & Violet Edition', '2014-06-13', 'assets/images/editions/ultra_colored.jpg', 'US'),
(62, 'Standard Edition', '2015-09-18', 'assets/images/editions/honey_std.jpg', 'US'),
(62, 'Translucent Red Edition', '2015-09-18', 'assets/images/editions/honey_red.jpg', 'US'),
(63, 'Standard Edition', '2024-09-01', 'assets/images/editions/lasso_std.jpg', 'US'),
(64, 'Standard EP', '2012-11-09', 'assets/images/editions/paradise_std.jpg', 'US'),
(65, 'Standard EP', '2013-12-04', 'assets/images/editions/tropico_std.jpg', 'US'),
(66, 'Standard Single', '2011-10-07', 'assets/images/editions/lana_video.jpg', 'US'),
(67, 'Standard Single', '2012-06-22', 'assets/images/editions/lana_summer.jpg', 'US'),
(68, 'Standard Single', '2013-04-23', 'assets/images/editions/lana_young.jpg', 'US'),

-- BABYMETAL (IDs 128-135)
(69, 'Standard Edition', '2015-06-17', 'assets/images/editions/bm_std.jpg', 'JP'),
(69, 'Red Edition', '2015-06-17', 'assets/images/editions/bm_red.jpg', 'JP'),
(70, 'Standard Edition', '2016-04-01', 'assets/images/editions/mr_std.jpg', 'JP'),
(71, 'Standard Edition', '2019-10-11', 'assets/images/editions/mg_std.jpg', 'JP'),
(71, 'Transparent Red Edition', '2019-10-11', 'assets/images/editions/mg_trans.jpg', 'JP'),
(72, 'Standard Edition', '2023-03-24', 'assets/images/editions/too_std.jpg', 'JP'),
(72, 'Clear Edition', '2023-03-24', 'assets/images/editions/too_clear.jpg', 'JP'),
(73, 'Standard Single', '2014-02-26', 'assets/images/editions/bm_chocolate.jpg', 'JP'),
(74, 'Standard Single', '2015-02-01', 'assets/images/editions/bm_road.jpg', 'JP'),

-- Pink Floyd (IDs 136-154)
(75, 'Standard Edition', '1979-11-30', 'assets/images/editions/wall_std.jpg', 'UK'),
(76, 'Standard Edition', '1983-03-21', 'assets/images/editions/final_std.jpg', 'UK'),
(77, 'Standard Edition', '1987-09-07', 'assets/images/editions/momentary_std.jpg', 'UK'),
(78, 'Standard Edition', '1994-03-28', 'assets/images/editions/div_std.jpg', 'UK'),
(78, 'Blue Edition', '1994-03-28', 'assets/images/editions/div_blue.jpg', 'UK'),
(79, 'Standard Edition', '2014-11-07', 'assets/images/editions/river_std.jpg', 'UK'),
(80, 'Standard Single', '1967-06-16', 'assets/images/editions/pf_seeemily.jpg', 'UK'),
(81, 'Standard Single', '1973-05-07', 'assets/images/editions/pf_money.jpg', 'UK'),
(82, 'Standard Single', '2022-04-08', 'assets/images/editions/hey_hey_rise_up.jpg', 'UK'),

-- Pinguini Tattici Nucleari (IDs 155-166)
(83, 'Standard Edition', '2019-04-05', 'assets/images/editions/hype_std.jpg', 'IT'),
(83, 'Green Edition', '2019-04-05', 'assets/images/editions/hype_green.jpg', 'IT'),
(84, 'Standard Edition', '2022-12-02', 'assets/images/editions/fake_std.jpg', 'IT'),
(84, 'Pink Edition', '2022-12-02', 'assets/images/editions/fake_pink.jpg', 'IT'),
(85, 'Standard Edition', '2024-01-01', 'assets/images/editions/hello_std.jpg', 'IT'),
(86, 'Standard Edition', '2020-12-04', 'assets/images/editions/ahia_std.jpg', 'IT'),
(86, 'White Edition', '2020-12-04', 'assets/images/editions/ahia_white.jpg', 'IT'),
(87, 'Standard Single', '2021-01-08', 'assets/images/editions/ptn_pastello.jpg', 'IT'),
(88, 'Standard Single', '2022-07-22', 'assets/images/editions/ptn_ricordi.jpg', 'IT'),
(89, 'Standard Single', '2023-05-19', 'assets/images/editions/ptn_rubami.jpg', 'IT'),
(90, 'Standard Single', '2024-08-30', 'assets/images/editions/ptn_romantico.jpg', 'IT'),

-- 5 Seconds of Summer (IDs 167-177)
(91, 'Standard Edition', '2014-06-27', 'assets/images/editions/5sos_std.jpg', 'AU'),
(92, 'Standard Edition', '2015-10-23', 'assets/images/editions/sounds_std.jpg', 'AU'),
(93, 'Standard Edition', '2018-06-15', 'assets/images/editions/young_std.jpg', 'AU'),
(93, 'Blue Edition', '2018-06-15', 'assets/images/editions/young_blue.jpg', 'AU'),
(94, 'Standard Edition', '2020-03-27', 'assets/images/editions/calm_std.jpg', 'AU'),
(94, 'Pink Edition', '2020-03-27', 'assets/images/editions/calm_pink.jpg', 'AU'),
(95, 'Standard Edition', '2022-09-23', 'assets/images/editions/5sos5_std.jpg', 'AU'),
(96, 'Standard EP', '2014-02-21', 'assets/images/editions/shelooks_ep.jpg', 'AU'),
(97, 'Standard EP', '2014-05-09', 'assets/images/editions/dontstop_ep.jpg', 'AU'),
(98, 'Standard Single', '2014-02-21', 'assets/images/editions/5sos_shelooks.jpg', 'AU'),
(99, 'Standard Single', '2018-04-12', 'assets/images/editions/5sos_youngblood.jpg', 'AU'),
(100, 'Standard Single', '2019-08-21', 'assets/images/editions/5sos_teeth.jpg', 'AU'),
(101, 'Standard Single', '2024-02-09', 'assets/images/editions/5sos_lighter.jpg', 'AU'),

-- Madonna (IDs 178-196)
(102, 'Pink Edition', '2005-11-15', 'assets/images/editions/confessions_pink.jpg', 'UK'),
(103, 'Standard Edition', '2008-04-19', 'assets/images/editions/hard_std.jpg', 'US'),
(104, 'Standard Edition', '2012-03-23', 'assets/images/editions/mdna_std.jpg', 'US'),
(105, 'Standard Edition', '2015-03-06', 'assets/images/editions/rebel_std.jpg', 'US'),
(106, 'Standard Edition', '2019-06-14', 'assets/images/editions/madame_std.jpg', 'US'),
(106, 'Translucent Blue Edition', '2019-06-14', 'assets/images/editions/madame_blue.jpg', 'US'),
(107, 'Standard Single', '1983-09-07', 'assets/images/editions/madonna_holiday.jpg', 'US'),
(108, 'Standard Single', '1984-10-31', 'assets/images/editions/madonna_virgin.jpg', 'US'),
(109, 'Standard Single', '1990-03-20', 'assets/images/editions/madonna_vogue.jpg', 'US'),
(110, 'Standard Single', '2005-10-17', 'assets/images/editions/madonna_hungup.jpg', 'US'),
(111, 'Standard Single', '2023-06-02', 'assets/images/editions/madonna_popular.jpg', 'US'),

-- Annalisa (IDs 197-210)
(112, 'Standard Edition', '2018-02-16', 'assets/images/editions/bye_std.jpg', 'IT'),
(113, 'Standard Edition', '2020-09-18', 'assets/images/editions/nuda_std.jpg', 'IT'),
(113, 'Red Edition', '2020-09-18', 'assets/images/editions/nuda_red.jpg', 'IT'),
(114, 'Standard Edition', '2023-09-29', 'assets/images/editions/vortice_std.jpg', 'IT'),
(114, 'Ruby Red Edition', '2023-09-29', 'assets/images/editions/vortice_red.jpg', 'IT'),
(115, 'Standard Single', '2022-09-02', 'assets/images/editions/annalisa_bellissima.jpg', 'IT'),
(116, 'Standard Single', '2023-03-31', 'assets/images/editions/annalisa_monamour.jpg', 'IT'),
(117, 'Standard Single', '2023-09-08', 'assets/images/editions/annalisa_sola.jpg', 'IT'),
(118, 'Standard Single', '2024-02-07', 'assets/images/editions/annalisa_sinceramente.jpg', 'IT'),

-- Nirvana (IDs 211-218)
(119, 'Standard Edition', '1989-06-15', 'assets/images/editions/bleach_std.jpg', 'US'),
(119, 'White Edition', '2009-11-03', 'assets/images/editions/bleach_white.jpg', 'US'),
(120, 'Standard Edition', '1991-09-24', 'assets/images/editions/never_std.jpg', 'US'),
(120, 'Silver Edition (Anniversary)', '2021-11-12', 'assets/images/editions/never_silver.jpg', 'US'),
(121, 'Standard Edition', '1993-09-21', 'assets/images/editions/utero_std.jpg', 'US'),
(121, 'Clear Edition', '2013-09-24', 'assets/images/editions/utero_clear.jpg', 'US'),
(122, 'Standard EP', '1992-02-05', 'assets/images/editions/hormoaning_std.jpg', 'JP'),
(123, 'Standard Single', '1991-09-10', 'assets/images/editions/nirvana_smells.jpg', 'US'),
(124, 'Standard Single', '1992-03-02', 'assets/images/editions/nirvana_come.jpg', 'US'),
(125, 'Standard Single', '1992-07-13', 'assets/images/editions/nirvana_lithium.jpg', 'US'),
(126, 'Standard Single', '1993-08-30', 'assets/images/editions/nirvana_heart.jpg', 'US'),

-- AC/DC (IDs 219-240)
(127, 'Standard Edition', '2000-02-28', 'assets/images/editions/stiff_std.jpg', 'AU'),
(128, 'Standard Edition', '2008-10-20', 'assets/images/editions/blackice_std.jpg', 'AU'),
(129, 'Standard Edition', '2014-11-28', 'assets/images/editions/rockbust_std.jpg', 'AU'),
(130, 'Standard Edition', '2020-11-13', 'assets/images/editions/power_std.jpg', 'AU'),
(130, 'Red Edition', '2020-11-13', 'assets/images/editions/power_red.jpg', 'AU'),
(131, 'Standard EP', '1984-10-15', 'assets/images/editions/74jailbreak_std.jpg', 'AU'),
(132, 'Standard Single', '1990-09-10', 'assets/images/editions/acdc_thunder.jpg', 'AU'),
(133, 'Standard Single', '2020-10-07', 'assets/images/editions/acdc_shot.jpg', 'AU'),

-- The Rolling Stones (IDs 241-269)
(134, 'Standard Edition', '1997-09-29', 'assets/images/editions/bridges_std.jpg', 'UK'),
(135, 'Standard Edition', '2005-09-05', 'assets/images/editions/bigger_std.jpg', 'UK'),
(136, 'Standard Edition', '2016-12-02', 'assets/images/editions/lonesome_std.jpg', 'UK'),
(137, 'Standard Edition', '2023-10-20', 'assets/images/editions/hackney_std.jpg', 'UK'),
(137, 'Clear Edition', '2023-10-20', 'assets/images/editions/hackney_clear.jpg', 'UK'),
(138, 'Standard EP', '1964-08-14', 'assets/images/editions/fivebyfive_std.jpg', 'UK'),
(139, 'Standard EP', '1965-06-11', 'assets/images/editions/gotlive_std.jpg', 'UK'),
(140, 'Standard Single', '1981-08-14', 'assets/images/editions/stones_startmeup.jpg', 'UK'),
(141, 'Standard Single', '2023-09-06', 'assets/images/editions/stones_angry.jpg', 'UK'),

-- SZA (IDs 270-280)
(142, 'Standard Edition', '2017-06-09', 'assets/images/editions/ctrl_std.jpg', 'US'),
(142, 'Translucent Green Edition', '2017-11-24', 'assets/images/editions/ctrl_green.jpg', 'US'),
(143, 'Standard Edition', '2022-12-09', 'assets/images/editions/sos_std.jpg', 'US'),
(143, 'Transparent Blue Edition', '2023-05-19', 'assets/images/editions/sos_blue.jpg', 'US'),
(144, 'Standard Edition', '2024-01-01', 'assets/images/editions/lana_sza_std.jpg', 'US'),
(145, 'Standard EP', '2012-09-24', 'assets/images/editions/see_sza_std.jpg', 'US'),
(146, 'Standard EP', '2013-04-10', 'assets/images/editions/s_ep_std.jpg', 'US'),
(147, 'Standard EP', '2014-04-08', 'assets/images/editions/z_ep_std.jpg', 'US'),
(148, 'Standard Single', '2023-01-10', 'assets/images/editions/sza_killbill.jpg', 'US'),
(149, 'Standard Single', '2024-02-22', 'assets/images/editions/sza_saturn.jpg', 'US');


-- Disk-Edition-Track
INSERT INTO edition_track_part_of (disk_id, edition_name, track_id, track_number) VALUES
-- TAYLOR SWIFT (Disk 1-10)
-- Disk 1: 1989 (Tracce 1-13)
(1, 'Standard Edition', 1, 1), (1, 'Standard Edition', 2, 2), (1, 'Standard Edition', 3, 3), (1, 'Standard Edition', 4, 4), (1, 'Standard Edition', 5, 5), (1, 'Standard Edition', 6, 6), (1, 'Standard Edition', 7, 7), (1, 'Standard Edition', 8, 8), (1, 'Standard Edition', 9, 9), (1, 'Standard Edition', 10, 10), (1, 'Standard Edition', 11, 11), (1, 'Standard Edition', 12, 12), (1, 'Standard Edition', 13, 13),
(1, 'Crystal Skies Blue Edition', 1, 1), (1, 'Crystal Skies Blue Edition', 2, 2), (1, 'Crystal Skies Blue Edition', 3, 3), (1, 'Crystal Skies Blue Edition', 4, 4), (1, 'Crystal Skies Blue Edition', 5, 5), (1, 'Crystal Skies Blue Edition', 6, 6), (1, 'Crystal Skies Blue Edition', 7, 7), (1, 'Crystal Skies Blue Edition', 8, 8), (1, 'Crystal Skies Blue Edition', 9, 9), (1, 'Crystal Skies Blue Edition', 10, 10), (1, 'Crystal Skies Blue Edition', 11, 11), (1, 'Crystal Skies Blue Edition', 12, 12), (1, 'Crystal Skies Blue Edition', 13, 13),
-- Disk 2: reputation (Tracce 14-28)
(2, 'Standard Edition', 14, 1), (2, 'Standard Edition', 15, 2), (2, 'Standard Edition', 16, 3), (2, 'Standard Edition', 17, 4), (2, 'Standard Edition', 18, 5), (2, 'Standard Edition', 19, 6), (2, 'Standard Edition', 20, 7), (2, 'Standard Edition', 21, 8), (2, 'Standard Edition', 22, 9), (2, 'Standard Edition', 23, 10), (2, 'Standard Edition', 24, 11), (2, 'Standard Edition', 25, 12), (2, 'Standard Edition', 26, 13), (2, 'Standard Edition', 27, 14), (2, 'Standard Edition', 28, 15),
(2, 'Picture Disc Edition', 14, 1), (2, 'Picture Disc Edition', 15, 2), (2, 'Picture Disc Edition', 16, 3), (2, 'Picture Disc Edition', 17, 4), (2, 'Picture Disc Edition', 18, 5), (2, 'Picture Disc Edition', 19, 6), (2, 'Picture Disc Edition', 20, 7), (2, 'Picture Disc Edition', 21, 8), (2, 'Picture Disc Edition', 22, 9), (2, 'Picture Disc Edition', 23, 10), (2, 'Picture Disc Edition', 24, 11), (2, 'Picture Disc Edition', 25, 12), (2, 'Picture Disc Edition', 26, 13), (2, 'Picture Disc Edition', 27, 14), (2, 'Picture Disc Edition', 28, 15),
-- Disk 3: Lover (Tracce 29-46)
(3, 'Pink & Blue Edition', 29, 1), (3, 'Pink & Blue Edition', 30, 2), (3, 'Pink & Blue Edition', 31, 3), (3, 'Pink & Blue Edition', 32, 4), (3, 'Pink & Blue Edition', 33, 5), (3, 'Pink & Blue Edition', 34, 6), (3, 'Pink & Blue Edition', 35, 7), (3, 'Pink & Blue Edition', 36, 8), (3, 'Pink & Blue Edition', 37, 9), (3, 'Pink & Blue Edition', 38, 10), (3, 'Pink & Blue Edition', 39, 11), (3, 'Pink & Blue Edition', 40, 12), (3, 'Pink & Blue Edition', 41, 13), (3, 'Pink & Blue Edition', 42, 14), (3, 'Pink & Blue Edition', 43, 15), (3, 'Pink & Blue Edition', 44, 16), (3, 'Pink & Blue Edition', 45, 17), (3, 'Pink & Blue Edition', 46, 18),
-- Disk 4: folklore (Tracce 47-62)
(4, 'Standard Edition', 47, 1), (4, 'Standard Edition', 48, 2), (4, 'Standard Edition', 49, 3), (4, 'Standard Edition', 50, 4), (4, 'Standard Edition', 51, 5), (4, 'Standard Edition', 52, 6), (4, 'Standard Edition', 53, 7), (4, 'Standard Edition', 54, 8), (4, 'Standard Edition', 55, 9), (4, 'Standard Edition', 56, 10), (4, 'Standard Edition', 57, 11), (4, 'Standard Edition', 58, 12), (4, 'Standard Edition', 59, 13), (4, 'Standard Edition', 60, 14), (4, 'Standard Edition', 61, 15), (4, 'Standard Edition', 62, 16),
-- Disk 5: Midnights (Tracce 63-75)
(5, 'Moonstone Blue Edition', 63, 1), (5, 'Moonstone Blue Edition', 64, 2), (5, 'Moonstone Blue Edition', 65, 3), (5, 'Moonstone Blue Edition', 66, 4), (5, 'Moonstone Blue Edition', 67, 5), (5, 'Moonstone Blue Edition', 68, 6), (5, 'Moonstone Blue Edition', 69, 7), (5, 'Moonstone Blue Edition', 70, 8), (5, 'Moonstone Blue Edition', 71, 9), (5, 'Moonstone Blue Edition', 72, 10), (5, 'Moonstone Blue Edition', 73, 11), (5, 'Moonstone Blue Edition', 74, 12), (5, 'Moonstone Blue Edition', 75, 13),
-- Disk 7: Beautiful Eyes (Tracce 76-77)
(7, 'Standard Edition', 76, 1), (7, 'Standard Edition', 77, 2),
-- Taylor Singles (Associo a ID traccia corretti)
(8, 'Standard Single', 6, 1), (9, 'Standard Single', 2, 1), (10, 'Standard Single', 65, 1),

-- DUA LIPA (Disk 11-19)
-- Disk 11: Dua Lipa (Tracce 78-88)
(11, 'Standard Edition', 78, 1), (11, 'Standard Edition', 79, 2), (11, 'Standard Edition', 80, 3), (11, 'Standard Edition', 81, 4), (11, 'Standard Edition', 82, 5), (11, 'Standard Edition', 83, 6), (11, 'Standard Edition', 84, 7), (11, 'Standard Edition', 85, 8), (11, 'Standard Edition', 86, 9), (11, 'Standard Edition', 87, 10), (11, 'Standard Edition', 88, 11),
-- Disk 12: Future Nostalgia (Tracce 89-99)
(12, 'Standard Edition', 89, 1), (12, 'Standard Edition', 90, 2), (12, 'Standard Edition', 91, 3), (12, 'Standard Edition', 92, 4), (12, 'Standard Edition', 93, 5), (12, 'Standard Edition', 94, 6), (12, 'Standard Edition', 95, 7), (12, 'Standard Edition', 96, 8), (12, 'Standard Edition', 97, 9), (12, 'Standard Edition', 98, 10), (12, 'Standard Edition', 99, 11),
-- Disk 13: Radical Optimism (Tracce 100-110)
(13, 'Standard Edition', 100, 1), (13, 'Standard Edition', 101, 2), (13, 'Standard Edition', 102, 3), (13, 'Standard Edition', 103, 4), (13, 'Standard Edition', 104, 5), (13, 'Standard Edition', 105, 6), (13, 'Standard Edition', 106, 7), (13, 'Standard Edition', 107, 8), (13, 'Standard Edition', 108, 9), (13, 'Standard Edition', 109, 10), (13, 'Standard Edition', 110, 11),
-- Dua Singles
(14, 'Standard Single', 81, 1), (15, 'Standard Single', 86, 1), (16, 'Standard Single', 93, 1), (17, 'Standard Single', 101, 1), (18, 'Standard Single', 102, 1), (19, 'Standard Single', 106, 1),

-- ARIANA GRANDE (Disk 20-27)
-- Disk 20: Dangerous Woman (Tracce 111-121)
(20, 'Standard Edition', 111, 1), (20, 'Standard Edition', 112, 2), (20, 'Standard Edition', 113, 3), (20, 'Standard Edition', 114, 4), (20, 'Standard Edition', 115, 5), (20, 'Standard Edition', 116, 6), (20, 'Standard Edition', 117, 7), (20, 'Standard Edition', 118, 8), (20, 'Standard Edition', 119, 9), (20, 'Standard Edition', 120, 10), (20, 'Standard Edition', 121, 11),
-- Disk 21: Sweetener (Tracce 122-137) 
(21, 'Standard Edition', 122, 1), (21, 'Standard Edition', 123, 2), (21, 'Standard Edition', 124, 3), (21, 'Standard Edition', 125, 4), (21, 'Standard Edition', 126, 5), (21, 'Standard Edition', 127, 6), (21, 'Standard Edition', 128, 7), (21, 'Standard Edition', 129, 8), (21, 'Standard Edition', 130, 9), (21, 'Standard Edition', 131, 10), (21, 'Standard Edition', 132, 11), (21, 'Standard Edition', 133, 12), (21, 'Standard Edition', 134, 13), (21, 'Standard Edition', 135, 14), (21, 'Standard Edition', 136, 15), (21, 'Standard Edition', 137, 16),
-- Disk 22: thank u, next (Tracce 138-149)
(22, 'Standard Edition', 138, 1), (22, 'Standard Edition', 139, 2), (22, 'Standard Edition', 140, 3), (22, 'Standard Edition', 141, 4), (22, 'Standard Edition', 142, 5), (22, 'Standard Edition', 143, 6), (22, 'Standard Edition', 144, 7), (22, 'Standard Edition', 145, 8), (22, 'Standard Edition', 146, 9), (22, 'Standard Edition', 147, 10), (22, 'Standard Edition', 148, 11), (22, 'Standard Edition', 149, 12),
-- Disk 23: Positions (Tracce 150-163)
(23, 'Coke Bottle Clear Edition', 150, 1), (23, 'Coke Bottle Clear Edition', 151, 2), (23, 'Coke Bottle Clear Edition', 152, 3), (23, 'Coke Bottle Clear Edition', 153, 4), (23, 'Coke Bottle Clear Edition', 154, 5), (23, 'Coke Bottle Clear Edition', 155, 6), (23, 'Coke Bottle Clear Edition', 156, 7), (23, 'Coke Bottle Clear Edition', 157, 8), (23, 'Coke Bottle Clear Edition', 158, 9), (23, 'Coke Bottle Clear Edition', 159, 10), (23, 'Coke Bottle Clear Edition', 160, 11), (23, 'Coke Bottle Clear Edition', 161, 12), (23, 'Coke Bottle Clear Edition', 162, 13), (23, 'Coke Bottle Clear Edition', 163, 14),
-- Disk 24: eternal sunshine (Tracce 164-176)
(24, 'Standard Edition', 164, 1), (24, 'Standard Edition', 165, 2), (24, 'Standard Edition', 166, 3), (24, 'Standard Edition', 167, 4), (24, 'Standard Edition', 168, 5), (24, 'Standard Edition', 169, 6), (24, 'Standard Edition', 170, 7), (24, 'Standard Edition', 171, 8), (24, 'Standard Edition', 172, 9), (24, 'Standard Edition', 173, 10), (24, 'Standard Edition', 174, 11), (24, 'Standard Edition', 175, 12), (24, 'Standard Edition', 176, 13),
-- Ariana Singles
(25, 'Standard Single', 147, 1), (26, 'Standard Single', 172, 1), (27, 'Standard Single', 173, 1),

-- Disk 28: Starboy (Tracce ID 176-193)
(28, 'Standard Edition', 176, 1), (28, 'Standard Edition', 177, 2), (28, 'Standard Edition', 178, 3), (28, 'Standard Edition', 179, 4), (28, 'Standard Edition', 180, 5), (28, 'Standard Edition', 181, 6), (28, 'Standard Edition', 182, 7), (28, 'Standard Edition', 183, 8), (28, 'Standard Edition', 184, 9), (28, 'Standard Edition', 185, 10), (28, 'Standard Edition', 186, 11), (28, 'Standard Edition', 187, 12), (28, 'Standard Edition', 188, 13), (28, 'Standard Edition', 189, 14), (28, 'Standard Edition', 190, 15), (28, 'Standard Edition', 191, 16), (28, 'Standard Edition', 192, 17), (28, 'Standard Edition', 193, 18),
(28, 'Translucent Red Edition', 176, 1), (28, 'Translucent Red Edition', 177, 2), (28, 'Translucent Red Edition', 178, 3), (28, 'Translucent Red Edition', 179, 4), (28, 'Translucent Red Edition', 180, 5), (28, 'Translucent Red Edition', 181, 6), (28, 'Translucent Red Edition', 182, 7), (28, 'Translucent Red Edition', 183, 8), (28, 'Translucent Red Edition', 184, 9), (28, 'Translucent Red Edition', 185, 10), (28, 'Translucent Red Edition', 186, 11), (28, 'Translucent Red Edition', 187, 12), (28, 'Translucent Red Edition', 188, 13), (28, 'Translucent Red Edition', 189, 14), (28, 'Translucent Red Edition', 190, 15), (28, 'Translucent Red Edition', 191, 16), (28, 'Translucent Red Edition', 192, 17), (28, 'Translucent Red Edition', 193, 18),

-- Nota: Gli ID 194-203 sono occupati dalle tracce di Kiss Land (Professional, ecc.) che hai nel file ma non associate a un disco.

-- Disk 31: House of Balloons (Tracce ID 204-212)
(31, 'Standard Edition', 204, 1), (31, 'Standard Edition', 205, 2), (31, 'Standard Edition', 206, 3), (31, 'Standard Edition', 207, 4), (31, 'Standard Edition', 208, 5), (31, 'Standard Edition', 209, 6), (31, 'Standard Edition', 210, 7), (31, 'Standard Edition', 211, 8), (31, 'Standard Edition', 212, 9),

-- Disk 29: After Hours (Tracce ID 213-225)
(29, 'Standard Edition', 213, 1), (29, 'Standard Edition', 214, 2), (29, 'Standard Edition', 215, 3), (29, 'Standard Edition', 216, 4), (29, 'Standard Edition', 217, 5), (29, 'Standard Edition', 218, 6), (29, 'Standard Edition', 219, 7), (29, 'Standard Edition', 220, 8), (29, 'Standard Edition', 221, 9), (29, 'Standard Edition', 222, 10), (29, 'Standard Edition', 223, 11), (29, 'Standard Edition', 224, 12), (29, 'Standard Edition', 225, 13),

-- Disk 30: Dawn FM (Tracce ID 226-240)
(30, 'Standard Edition', 226, 1), (30, 'Standard Edition', 227, 2), (30, 'Standard Edition', 228, 3), (30, 'Standard Edition', 229, 4), (30, 'Standard Edition', 230, 5), (30, 'Standard Edition', 231, 6), (30, 'Standard Edition', 232, 7), (30, 'Standard Edition', 233, 8), (30, 'Standard Edition', 234, 9), (30, 'Standard Edition', 235, 10), (30, 'Standard Edition', 236, 11), (30, 'Standard Edition', 237, 12), (30, 'Standard Edition', 238, 13), (30, 'Standard Edition', 239, 14), (30, 'Standard Edition', 240, 15),

-- Weeknd Singles
(33, 'Standard Single', 221, 1), -- Blinding Lights
(34, 'Standard Single', 223, 1), -- Save Your Tears
(35, 'Standard Single', 241, 1), -- Dancing In The Flames


-- Disk 37: White Album (Tracce ID 273-276)
(37, 'Standard Edition', 273, 1), (37, 'Standard Edition', 274, 2), (37, 'Standard Edition', 275, 3), (37, 'Standard Edition', 276, 4),
(37, 'White Edition', 273, 1), (37, 'White Edition', 274, 2), (37, 'White Edition', 275, 3), (37, 'White Edition', 276, 4),

-- Disk 39: Abbey Road (Tracce ID 277-280)
(39, 'Standard Edition', 277, 1), (39, 'Standard Edition', 278, 2), (39, 'Standard Edition', 279, 3), (39, 'Standard Edition', 280, 4),

-- Disk 40: Let It Be (Tracce ID 281-282)
(40, 'Standard Edition', 281, 1), (40, 'Standard Edition', 282, 2),

-- Beatles Singles & EPs
(43, 'Standard Single', 283, 1), -- Hey Jude
(44, 'Standard Single', 281, 1), -- Let It Be (Single)
(45, 'Standard Edition', 284, 1), -- Now and Then

-- Disk 46: Hail to the Thief (Tracce ID 307-308)
(46, 'Standard Edition', 307, 1), (46, 'Standard Edition', 308, 2),

-- Disk 47: In Rainbows (Tracce ID 309-314)
(47, 'Standard Edition', 309, 1), (47, 'Standard Edition', 310, 2), (47, 'Standard Edition', 311, 3), (47, 'Standard Edition', 312, 4), (47, 'Standard Edition', 313, 5), (47, 'Standard Edition', 314, 6),

-- Disk 48: The King of Limbs (Tracce ID 315-316)
(48, 'Standard Edition', 315, 1), (48, 'Standard Edition', 316, 2),

-- Disk 49: A Moon Shaped Pool (Tracce ID 317-320)
(49, 'Standard Edition', 317, 1), (49, 'Standard Edition', 318, 2), (49, 'Standard Edition', 319, 3), (49, 'Standard Edition', 320, 4),

-- Radiohead Singles & EPs
(50, 'Standard EP', 293, 1),     -- Airbag
(51, 'Standard Single', 297, 1), -- Karma Police
(52, 'Standard Single', 298, 1), -- No Surprises

-- LINKIN PARK (Disk 53-58)
-- Disk 53: The Hunting Party (Tracce ID 342-343)
(53, 'Standard Edition', 342, 1), (53, 'Standard Edition', 343, 2),
-- Disk 54: One More Light (Tracce ID 344-345)
(54, 'Standard Edition', 344, 1), (54, 'Standard Edition', 345, 2),
-- Disk 55: From Zero (Tracce ID 346-348)
(55, 'Standard Edition', 346, 1), (55, 'Standard Edition', 347, 2), (55, 'Standard Edition', 348, 3),
(55, 'Blue Edition', 346, 1), (55, 'Blue Edition', 347, 2), (55, 'Blue Edition', 348, 3),
-- Linkin Park Singles
(57, 'Standard Single', 325, 1), -- In the End
(58, 'Standard Single', 330, 1), -- Numb

-- LANA DEL REY (Disk 59-68)
-- Disk 60: Born to Die (Tracce ID 349-354)
(60, 'Standard Edition', 349, 1), (60, 'Standard Edition', 350, 2), (60, 'Standard Edition', 351, 3), (60, 'Standard Edition', 352, 4), (60, 'Standard Edition', 353, 5), (60, 'Standard Edition', 354, 6),
(60, 'Red Edition', 349, 1), (60, 'Red Edition', 350, 2), (60, 'Red Edition', 351, 3), (60, 'Red Edition', 352, 4), (60, 'Red Edition', 353, 5), (60, 'Red Edition', 354, 6),
-- Disk 64: Paradise EP (Tracce ID 355-358)
(64, 'Standard EP', 355, 1), (64, 'Standard EP', 356, 2), (64, 'Standard EP', 357, 3), (64, 'Standard EP', 358, 4),
-- Disk 61: Ultraviolence (Tracce ID 359-363)
(61, 'Standard Edition', 359, 1), (61, 'Standard Edition', 360, 2), (61, 'Standard Edition', 361, 3), (61, 'Standard Edition', 362, 4), (61, 'Standard Edition', 363, 5),
(61, 'Blue & Violet Edition', 359, 1), (61, 'Blue & Violet Edition', 360, 2), (61, 'Blue & Violet Edition', 361, 3), (61, 'Blue & Violet Edition', 362, 4), (61, 'Blue & Violet Edition', 363, 5),
-- Disk 62: Honeymoon (Tracce ID 364-367)
(62, 'Standard Edition', 364, 1), (62, 'Standard Edition', 365, 2), (62, 'Standard Edition', 366, 3), (62, 'Standard Edition', 367, 4),
-- Disk 63: Lasso (Tracce ID 387-388)
(63, 'Standard Edition', 387, 1),
-- Lana Del Rey Singles
(66, 'Standard Single', 352, 1), -- Video Games
(67, 'Standard Single', 353, 1), -- Summertime Sadness
(68, 'Standard Single', 388, 1), -- Tough

-- BABYMETAL (Disk 69-74)
-- Disk 69: Babymetal (Tracce ID 389-395)
(69, 'Standard Edition', 389, 1), (69, 'Standard Edition', 390, 2), (69, 'Standard Edition', 391, 3), (69, 'Standard Edition', 392, 4), (69, 'Standard Edition', 393, 5), (69, 'Standard Edition', 394, 6), (69, 'Standard Edition', 395, 7),
-- Disk 70: Metal Resistance (Tracce ID 396-399)
(70, 'Standard Edition', 396, 1), (70, 'Standard Edition', 397, 2), (70, 'Standard Edition', 398, 3), (70, 'Standard Edition', 399, 4),
-- Disk 71: Metal Galaxy (Tracce ID 400-403)
(71, 'Standard Edition', 400, 1), (71, 'Standard Edition', 401, 2), (71, 'Standard Edition', 402, 3), (71, 'Standard Edition', 403, 4),
-- Disk 72: The Other One (Tracce ID 404-407)
(72, 'Standard Edition', 404, 1), (72, 'Standard Edition', 405, 2), (72, 'Standard Edition', 406, 3), (72, 'Standard Edition', 407, 4),
-- BABYMETAL Singles
(73, 'Standard Single', 391, 1), -- Gimme Chocolate!!
(74, 'Standard Single', 396, 1), -- Road of Resistance


-- PINK FLOYD (Disk 75-82)
-- Disk 75: The Wall (Tracce ID 442-452)
(75, 'Standard Edition', 442, 1), (75, 'Standard Edition', 443, 2), (75, 'Standard Edition', 444, 3), (75, 'Standard Edition', 445, 4), (75, 'Standard Edition', 446, 5), (75, 'Standard Edition', 447, 6), (75, 'Standard Edition', 448, 7), (75, 'Standard Edition', 449, 8), (75, 'Standard Edition', 450, 9), (75, 'Standard Edition', 451, 10), (75, 'Standard Edition', 452, 11),
-- Disk 76: The Final Cut (Tracce ID 453-454)
(76, 'Standard Edition', 453, 1), (76, 'Standard Edition', 454, 2),
-- Disk 77: Momentary Lapse (Tracce ID 455-456)
(77, 'Standard Edition', 455, 1), (77, 'Standard Edition', 456, 2),
-- Disk 78: Division Bell (Tracce ID 457-458)
(78, 'Standard Edition', 457, 1), (78, 'Standard Edition', 458, 2),
-- Pink Floyd Singles
(80, 'Standard Single', 412, 1), -- See Emily Play
(81, 'Standard Single', 427, 1), -- Money
(82, 'Standard Single', 460, 1), -- Hey Hey Rise Up

-- PINGUINI TATTICI NUCLEARI (Disk 83-90)
-- Disk 83: Fuori dall'hype (Tracce ID 466-471)
(83, 'Standard Edition', 466, 1), (83, 'Standard Edition', 467, 2), (83, 'Standard Edition', 468, 3), (83, 'Standard Edition', 469, 4), (83, 'Standard Edition', 470, 5), (83, 'Standard Edition', 471, 6),
-- Disk 86: Ahia! (Tracce ID 472-475)
(86, 'Standard Edition', 472, 1), (86, 'Standard Edition', 473, 2), (86, 'Standard Edition', 474, 3), (86, 'Standard Edition', 475, 4),
-- Disk 84: Fake News (Tracce ID 476-480)
(84, 'Standard Edition', 476, 1), (84, 'Standard Edition', 477, 2), (84, 'Standard Edition', 478, 3), (84, 'Standard Edition', 479, 4), (84, 'Standard Edition', 480, 5),
-- PTN Singles
(87, 'Standard Single', 474, 1), -- Pastello bianco
(88, 'Standard Single', 477, 1), -- Ricordi
(89, 'Standard Single', 480, 1), -- Rubami la notte
(90, 'Standard Single', 481, 1), -- Romantico ma muori


-- 5 SECONDS OF SUMMER (Disk 91-101)
-- Disk 91: 5 Seconds of Summer (Tracce 482-485)
(91, 'Standard Edition', 482, 1), (91, 'Standard Edition', 483, 2), (91, 'Standard Edition', 484, 3), (91, 'Standard Edition', 485, 4),

-- Disk 93: Youngblood (Tracce 489-492)
(93, 'Standard Edition', 489, 1), (93, 'Standard Edition', 490, 2), (93, 'Standard Edition', 491, 3), (93, 'Standard Edition', 492, 4),
(93, 'Blue Edition', 489, 1), (93, 'Blue Edition', 490, 2), (93, 'Blue Edition', 491, 3), (93, 'Blue Edition', 492, 4),

-- Disk 94: Calm (Tracce 493-497)
(94, 'Standard Edition', 493, 1), (94, 'Standard Edition', 494, 2), (94, 'Standard Edition', 495, 3), (94, 'Standard Edition', 496, 4), (94, 'Standard Edition', 497, 5),

-- Disk 95: 5SOS5 (Tracce 498-501)
(95, 'Standard Edition', 498, 1), (95, 'Standard Edition', 499, 2), (95, 'Standard Edition', 500, 3), (95, 'Standard Edition', 501, 4),

-- Singles & EPs
(96, 'Standard EP', 482, 1), (98, 'Standard Single', 482, 1), (99, 'Standard Single', 489, 1), (100, 'Standard Single', 495, 1), (101, 'Standard Single', 501, 1),

-- EP (2 tracce)
(6, 'Standard Edition', 639, 1), (6, 'Standard Edition', 640, 2),
(32, 'Standard Edition', 641, 1), (32, 'Standard Edition', 642, 2),
(41, 'Standard Edition', 649, 1), (41, 'Standard Edition', 650, 2),
(42, 'Standard Edition', 651, 1), (42, 'Standard Edition', 652, 2),
(56, 'Standard EP', 653, 1), (56, 'Standard EP', 654, 2),
(65, 'Standard EP', 658, 1), (65, 'Standard EP', 659, 2),
(97, 'Standard EP', 669, 1), (97, 'Standard EP', 670, 2),

-- ALBUM (3 tracce)
(36, 'Standard Edition', 643, 1), (36, 'Standard Edition', 644, 2), (36, 'Standard Edition', 645, 3),
(38, 'Standard Edition', 646, 1), (38, 'Standard Edition', 647, 2), (38, 'Standard Edition', 648, 3),
(59, 'Standard Edition', 655, 1), (59, 'Standard Edition', 656, 2), (59, 'Standard Edition', 657, 3),
(79, 'Standard Edition', 660, 1), (79, 'Standard Edition', 661, 2), (79, 'Standard Edition', 662, 3),
(85, 'Standard Edition', 663, 1), (85, 'Standard Edition', 664, 2), (85, 'Standard Edition', 665, 3),
(92, 'Standard Edition', 666, 1), (92, 'Standard Edition', 667, 2), (92, 'Standard Edition', 668, 3),
(102, 'Pink Edition', 527, 1), (102, 'Pink Edition', 528, 2), (102, 'Pink Edition', 510, 3),
(103, 'Standard Edition', 671, 1), (103, 'Standard Edition', 672, 2), (103, 'Standard Edition', 673, 3),
(104, 'Standard Edition', 674, 1), (104, 'Standard Edition', 675, 2), (104, 'Standard Edition', 676, 3),
(105, 'Standard Edition', 677, 1), (105, 'Standard Edition', 678, 2), (105, 'Standard Edition', 679, 3),
(106, 'Standard Edition', 533, 1), (106, 'Standard Edition', 680, 2), (106, 'Standard Edition', 681, 3),
(112, 'Standard Edition', 682, 1), (112, 'Standard Edition', 683, 2), (112, 'Standard Edition', 684, 3),
(113, 'Standard Edition', 685, 1), (113, 'Standard Edition', 686, 2), (113, 'Standard Edition', 548, 3),

-- SINGOLI (1 traccia)
(107, 'Standard Single', 504, 1), -- Holiday
(108, 'Standard Single', 505, 1), -- Like a Virgin
(109, 'Standard Single', 515, 1), -- Vogue
(110, 'Standard Single', 527, 1), -- Hung Up
(111, 'Standard Single', 534, 1), -- Popular

-- TAYLOR SWIFT & DUA LIPA (Album - 3 tracce)
(4, 'Meet Me Behind The Mall (Grey Edition)', 47, 1), (4, 'Meet Me Behind The Mall (Grey Edition)', 48, 2), (4, 'Meet Me Behind The Mall (Grey Edition)', 687, 3),
(5, 'Blood Moon Edition', 63, 1), (5, 'Blood Moon Edition', 65, 2), (5, 'Blood Moon Edition', 690, 3),
(11, 'Pink Edition', 78, 1), (11, 'Pink Edition', 79, 2), (11, 'Pink Edition', 80, 3),
(12, 'Neon Pink Edition', 89, 1), (12, 'Neon Pink Edition', 90, 2), (12, 'Neon Pink Edition', 93, 3),
(13, 'Red Edition', 100, 1), (13, 'Red Edition', 101, 2), (13, 'Red Edition', 693, 3),

-- ARIANA GRANDE & THE WEEKND (Album - 3 tracce)
(21, 'Peach Edition', 126, 1), (21, 'Peach Edition', 127, 2), (21, 'Peach Edition', 696, 3),
(24, 'Ruby Edition', 171, 1), (24, 'Ruby Edition', 172, 2), (24, 'Ruby Edition', 698, 3),
(29, 'Gold with Red Splatter Edition', 213, 1), (29, 'Gold with Red Splatter Edition', 221, 2), (29, 'Gold with Red Splatter Edition', 223, 3),
(30, 'Silver Edition', 226, 1), (30, 'Silver Edition', 229, 2), (30, 'Silver Edition', 231, 3),

-- NIRVANA (Disk 119-121)
-- Bleach (Standard & White)
(119, 'Standard Edition', 555, 1), (119, 'Standard Edition', 556, 2), (119, 'Standard Edition', 557, 3),
(119, 'White Edition', 555, 1), (119, 'White Edition', 556, 2), (119, 'White Edition', 557, 3),
-- Nevermind (Anniversary & Standard)
(120, 'Silver Edition (Anniversary)', 558, 1), (120, 'Silver Edition (Anniversary)', 559, 2), (120, 'Silver Edition (Anniversary)', 560, 3),
(120, 'Standard Edition', 558, 1), (120, 'Standard Edition', 559, 2), (120, 'Standard Edition', 560, 3),
-- In Utero (Clear & Standard)
(121, 'Clear Edition', 570, 1), (121, 'Clear Edition', 571, 2), (121, 'Clear Edition', 572, 3),
(121, 'Standard Edition', 570, 1), (121, 'Standard Edition', 571, 2), (121, 'Standard Edition', 572, 3),

-- AC/DC & ROLLING STONES (Album - 3 tracce)
-- Power Up (Red & Standard)
(130, 'Red Edition', 594, 1), (130, 'Red Edition', 595, 2), (130, 'Red Edition', 597, 3),
(130, 'Standard Edition', 594, 1), (130, 'Standard Edition', 595, 2), (130, 'Standard Edition', 597, 3),
-- Hackney Diamonds (Clear & Standard)
(137, 'Clear Edition', 622, 1), (137, 'Clear Edition', 623, 2), (137, 'Clear Edition', 701, 3),
(137, 'Standard Edition', 622, 1), (137, 'Standard Edition', 623, 2), (137, 'Standard Edition', 701, 3),

-- SZA & SINGOLI (SZA 3 tracce, Singoli 1 traccia)
(142, 'Translucent Green Edition', 624, 1), (142, 'Translucent Green Edition', 625, 2), (142, 'Translucent Green Edition', 626, 3),
(143, 'Transparent Blue Edition', 631, 1), (143, 'Transparent Blue Edition', 632, 2), (143, 'Transparent Blue Edition', 633, 3),
(115, 'Standard Single', 550, 1), -- Bellissima
(116, 'Standard Single', 551, 1), -- Mon Amour
(117, 'Standard Single', 552, 1), -- Ragazza Sola
(118, 'Standard Single', 554, 1), -- Sinceramente
(123, 'Standard Single', 558, 1), -- Smells Like Teen Spirit
(124, 'Standard Single', 560, 1), -- Come as You Are
(132, 'Standard Single', 592, 1), -- Thunderstruck
(133, 'Standard Single', 597, 1), -- Shot in the Dark

-- Edizioni Speciali (Beatles, Radiohead, Babymetal, Pink Floyd)
(45, 'Marble Blue Edition', 284, 1), -- Now and Then
(49, 'Opaque White Edition', 317, 1), (49, 'Opaque White Edition', 318, 2), (49, 'Opaque White Edition', 319, 3), -- A Moon Shaped Pool
(62, 'Translucent Red Edition', 364, 1), (62, 'Translucent Red Edition', 365, 2), (62, 'Translucent Red Edition', 366, 3), -- Honeymoon
(69, 'Red Edition', 389, 1), (69, 'Red Edition', 390, 2), (69, 'Red Edition', 391, 3), -- Babymetal
(71, 'Transparent Red Edition', 400, 1), (71, 'Transparent Red Edition', 401, 2), (71, 'Transparent Red Edition', 402, 3), -- Metal Galaxy
(72, 'Clear Edition', 404, 1), (72, 'Clear Edition', 405, 2), (72, 'Clear Edition', 406, 3), -- The Other One
(78, 'Blue Edition', 457, 1), (78, 'Blue Edition', 458, 2), (78, 'Blue Edition', 705, 3), -- The Division Bell (Poles Apart ID: 705)


-- Edizioni Speciali (PTN, Calm, Madonna, Annalisa)
(83, 'Green Edition', 466, 1), (83, 'Green Edition', 467, 2), (83, 'Green Edition', 468, 3), -- Fuori dall'hype
(84, 'Pink Edition', 476, 1), (84, 'Pink Edition', 477, 2), (84, 'Pink Edition', 478, 3), -- Fake News
(86, 'White Edition', 472, 1), (86, 'White Edition', 473, 2), -- Ahia! (EP)
(94, 'Pink Edition', 493, 1), (94, 'Pink Edition', 494, 2), (94, 'Pink Edition', 495, 3), -- Calm
(106, 'Translucent Blue Edition', 533, 1), (106, 'Translucent Blue Edition', 707, 2), (106, 'Translucent Blue Edition', 680, 3), -- Madame X (I Don't Search ID: 707, Dark Ballet ID: 680)
(113, 'Red Edition', 548, 1), (113, 'Red Edition', 549, 2), (113, 'Red Edition', 708, 3), -- Nuda (Graffiti ID: 708)
(114, 'Ruby Red Edition', 550, 1), (114, 'Ruby Red Edition', 551, 2), (114, 'Ruby Red Edition', 552, 3), -- Vortice
(114, 'Standard Edition', 550, 1), (114, 'Standard Edition', 551, 2), (114, 'Standard Edition', 552, 3),

-- Nirvana, AC/DC, Rolling Stones (Album & EP)
(122, 'Standard EP', 709, 1), (122, 'Standard EP', 710, 2), -- Hormoaning (Aneurysm ID: 709, Even in His Youth ID: 710)
(125, 'Standard Single', 562, 1), (126, 'Standard Single', 571, 1), -- Nirvana Singles
(127, 'Standard Edition', 711, 1), (127, 'Standard Edition', 712, 2), (127, 'Standard Edition', 713, 3), -- Stiff Upper Lip (IDs 711-713)
(128, 'Standard Edition', 714, 1), (128, 'Standard Edition', 715, 2), (128, 'Standard Edition', 716, 3), -- Black Ice (IDs 714-716)
(129, 'Standard Edition', 717, 1), (129, 'Standard Edition', 718, 2), (129, 'Standard Edition', 719, 3), -- Rock or Bust (IDs 717-719)
(131, 'Standard EP', 574, 1), (131, 'Standard EP', 575, 2), -- '74 Jailbreak
(134, 'Standard Edition', 720, 1), (134, 'Standard Edition', 721, 2), (134, 'Standard Edition', 722, 3), -- Bridges to Babylon (IDs 720-722)
(135, 'Standard Edition', 723, 1), (135, 'Standard Edition', 724, 2), (135, 'Standard Edition', 725, 3), -- A Bigger Bang (IDs 723-725)
(136, 'Standard Edition', 726, 1), (136, 'Standard Edition', 727, 2), (136, 'Standard Edition', 728, 3), -- Blue & Lonesome (IDs 726-728)
(138, 'Standard EP', 598, 1), (138, 'Standard EP', 729, 2), -- Five by Five (2120 S. Michigan ID: 729)
(139, 'Standard EP', 730, 1), (139, 'Standard EP', 731, 2), -- Got Live (Under My Thumb ID: 730, Cloud ID: 731)
(140, 'Standard Single', 618, 1), (141, 'Standard Single', 622, 1), -- Stones Singles

-- SZA (Album & EP)
(144, 'Standard Edition', 732, 1), (144, 'Standard Edition', 733, 2), (144, 'Standard Edition', 734, 3), -- Lana (IDs 732-734)
(145, 'Standard EP', 735, 1), (145, 'Standard EP', 736, 2), -- See.SZA.Run (IDs 735-736)
(146, 'Standard EP', 737, 1), (146, 'Standard EP', 738, 2), -- S (IDs 737-738)
(147, 'Standard EP', 739, 1), (147, 'Standard EP', 740, 2), -- Z (IDs 739-740)
(148, 'Standard Single', 634, 1), (149, 'Standard Single', 638, 1); -- Kill Bill, Saturn



-- rewiews
INSERT INTO review (user_id, disk_id, edition_name, rating, content) VALUES
-- --- DISCO: The Weeknd - After Hours (Disk 29) ---
(1, 29, 'Standard Edition', 5, 'L''estetica synth-wave di questo album è perfetta. Su vinile, brani come "Blinding Lights" hanno un calore che lo streaming non può replicare.'),
(2, 29, 'Standard Edition', 5, 'Ho confrontato questa stampa con i file hi-res. La separazione dei canali nelle parti vocali è eccellente, specialmente nei riverberi di "Save Your Tears".'),
(3, 29, 'Standard Edition', 4, 'Non è il mio genere solito, ma la produzione è così potente che spacca anche per chi ascolta rock. Un disco notturno fantastico.'),
(4, 29, 'Standard Edition', 5, 'L''album pop dell''anno 2020. Averlo in questa edizione è un obbligo per ogni collezionista di musica moderna.'),

-- --- DISCO: The Beatles - Abbey Road (Disk 39) ---
(1, 39, 'Standard Edition', 5, 'Il lato B di questo disco è probabilmente la sequenza musicale più bella mai incisa. Un pezzo di storia in ogni solco.'),
(2, 39, 'Standard Edition', 5, 'Questa ristampa mantiene un rumore di fondo bassissimo. Il basso di McCartney in "Come Together" è profondo e controllato.'),
(3, 39, 'Standard Edition', 5, 'Il miglior album dei Beatles. Fine della discussione. Gli assoli finali di "The End" sono leggenda.'),
(4, 39, 'Standard Edition', 5, 'La copertina più iconica di sempre per l''album più equilibrato dei Fab Four. Indispensabile.'),

-- --- DISCO: Lana Del Rey - Born to Die (Disk 60) ---
(1, 60, 'Standard Edition', 5, 'L''album che ha cambiato le regole del pop alternativo. La voce di Lana è ipnotica su questo supporto.'),
(4, 60, 'Standard Edition', 5, 'Ho questa edizione da anni e non mi stanco mai di ascoltarla. È il manifesto della malinconia moderna.'),
(2, 60, 'Red Edition', 4, 'Ho preso la Red Edition per l''estetica, ma la qualità della stampa è sorprendentemente alta per un disco colorato. Dinamica ottima.'),

-- --- DISCO: Pinguini Tattici Nucleari - Fake News (Disk 84) ---
(1, 84, 'Standard Edition', 4, 'I PTN sono la dimostrazione che il pop italiano può ancora essere scritto bene. "Ricordi" mi commuove ogni volta.'),
(3, 84, 'Standard Edition', 4, 'Testi intelligenti e arrangiamenti mai banali. Dal vivo sono fortissimi, ma il disco si lascia ascoltare che è un piacere.'),
(4, 84, 'Pink Edition', 5, 'La versione rosa è stupenda da vedere sul piatto. Un acquisto obbligato per supportare la scena italiana.'),

-- --- DISCO: Dua Lipa - Future Nostalgia (Disk 12) ---
(1, 12, 'Standard Edition', 5, 'Puro divertimento dall''inizio alla fine. Il basso in "Levitating" ti costringe a ballare.'),
(2, 12, 'Standard Edition', 5, 'Produzione moderna ma con un cuore funk anni ''70. Tecnicamente è uno dei dischi pop meglio registrati degli ultimi anni.'),
(4, 12, 'Neon Pink Edition', 5, 'Il colore del vinile si abbina perfettamente all''energia del disco. Uno dei miei pezzi preferiti in bacheca.'),

-- --- DISCO: Radiohead - A Moon Shaped Pool (Disk 49) ---
(2, 49, 'Standard Edition', 5, 'Un album intimo e complesso. Gli arrangiamenti d''archi sono riprodotti con una fedeltà incredibile in questa stampa.'),
(4, 49, 'Standard Edition', 5, 'La chiusura con "True Love Waits" è straziante. I Radiohead non sbagliano un colpo, un disco da ascoltare in cuffia al buio.'),
(1, 49, 'Opaque White Edition', 5, 'L''edizione bianca è eterea come la musica che contiene. Un oggetto d''arte prima ancora che un disco.'),

-- --- DISCO: Annalisa - E poi siamo finiti nel vortice (Disk 114) ---
(1, 114, 'Standard Edition', 5, 'Annalisa ha trovato la sua dimensione perfetta. Un disco coerente, potente e pieno di hit.'),
(2, 114, 'Standard Edition', 4, 'I sintetizzatori in "Bellissima" hanno un taglio molto analogico che su vinile guadagna corpo.'),
(4, 114, 'Ruby Red Edition', 5, 'Il rosso rubino di questa edizione è profondo. Musicalmente è il miglior lavoro di Annalisa finora.'),

-- --- DISCO: 5 Seconds of Summer - Youngblood (Disk 93) ---
(1, 93, 'Standard Edition', 4, 'La svolta pop-rock della band. La title track è un martello, impossibile non cantarla.'),
(3, 93, 'Standard Edition', 4, 'Hanno abbandonato il pop-punk adolescenziale per un suono più maturo e vicino ai Police. Promossi a pieni voti.'),

-- --- DISCO: Ariana Grande - thank u, next (Disk 22) ---
(1, 22, 'Standard Edition', 5, 'Un disco onesto, personale e pieno di groove. Ariana qui ha superato se stessa.'),
(4, 22, 'Standard Edition', 4, 'L''estetica rosa e nera dell''era "thank u, next" è ovunque. Il vinile suona caldo e avvolgente.'),

-- --- DISCO: AC/DC - Power Up (Disk 130) ---
(3, 130, 'Standard Edition', 5, 'Rock puro al 100%. Gli AC/DC sono l''unica certezza in un mondo che cambia. Volume a 11!'),
(2, 130, 'Standard Edition', 5, 'Anche a volumi elevati, la stampa non distorce. Il riff di Angus Young è nitido e tagliente come un rasoio.'),

-- --- TAYLOR SWIFT: folklore (Disk 4) ---
(4, 4, 'Standard Edition', 5, 'Il passaggio al folk è stata la mossa migliore di Taylor. "Cardigan" suona divinamente su vinile, molto profondo.'),
(2, 4, 'Meet Me Behind The Mall (Grey Edition)', 5, 'Stampa silenziosissima. Il grigio del disco è molto elegante e si sposa bene con l''artwork monocromatico.'),
(3, 4, 'Standard Edition', 4, 'Non sono un fan del pop, ma questo disco ha una scrittura che ricorda i grandi cantautori rock degli anni 70.'),

-- --- PINK FLOYD: The Wall (Disk 75) ---
(2, 75, 'Standard Edition', 5, 'Un capolavoro tecnico. La dinamica tra i momenti sussurrati e le esplosioni rock è gestita magistralmente in questa edizione.'),
(3, 75, 'Standard Edition', 5, 'Roger Waters e David Gilmour al loro apice. Ascoltare "Comfortably Numb" a tutto volume è un''esperienza religiosa.'),
(1, 75, 'Standard Edition', 5, 'Il miglior concept album della storia. La confezione apribile è un pezzo d''arte da esporre assolutamente.'),

-- --- NIRVANA: Nevermind (Disk 120) ---
(3, 120, 'Standard Edition', 5, 'Il disco che ha cambiato tutto. Il suono della batteria di Dave Grohl in "In Bloom" è potente e secco, perfetto.'),
(2, 120, 'Silver Edition (Anniversary)', 5, 'Questa rimasterizzazione per l''anniversario pulisce bene le medie frequenze senza togliere il carattere sporco del grunge.'),
(4, 120, 'Standard Edition', 4, 'Un classico intramontabile. Nonostante sia un disco "rumoroso", su vinile si percepiscono dettagli della chitarra di Cobain mai sentiti prima.'),

-- --- BABYMETAL: Babymetal (Disk 69) ---
(4, 69, 'Red Edition', 5, 'Kawaii Metal! Il contrasto tra le voci dolci e i riff pesantissimi è geniale. Il vinile rosso è un pezzo da collezione stupendo.'),
(3, 69, 'Standard Edition', 4, 'Ero scettico, ma tecnicamente la band è mostruosa. "Gimme Chocolate!!" è un tormentone che spacca i diffusori.'),

-- --- LINKIN PARK: From Zero (Disk 55) ---
(3, 55, 'Standard Edition', 5, 'Un ritorno incredibile. La nuova cantante ha un''energia pazzesca e il suono è un mix perfetto tra Hybrid Theory e modernità.'),
(1, 55, 'Blue Edition', 4, 'La variante blu è bellissima. Il disco è corto ma intenso, non c''è una traccia riempitiva.'),

-- --- ANNALISA: Nuda (Disk 113) ---
(1, 113, 'Standard Edition', 4, 'Uno dei dischi pop italiani più coerenti degli ultimi anni. "Tsunami" è un pezzo prodotto con standard internazionali.'),
(4, 113, 'Red Edition', 5, 'Ho preso l''edizione rossa autografata. Annalisa è una garanzia e il design del packaging è molto curato.'),

-- --- RADIOHEAD: In Rainbows (Disk 47) ---
(2, 47, 'Standard Edition', 5, 'Probabilmente il disco dei Radiohead che suona meglio su vinile. La caldezza di "Nude" e "Reckoner" è imbattibile.'),
(4, 47, 'Standard Edition', 5, 'Art rock ai massimi livelli. Ogni volta che lo ascolto scopro un nuovo strato sonoro o un dettaglio di elettronica nascosto.'),

-- --- THE BEATLES: White Album (Disk 37) ---
(1, 37, 'White Edition', 5, 'Avere il disco bianco in vinile bianco è un sogno. La varietà di generi in questo album è ancora oggi sconvolgente.'),
(2, 37, 'Standard Edition', 4, 'Alcune tracce sono sperimentali al limite dell''ascoltabile, ma brani come "While My Guitar Gently Weeps" valgono da soli il prezzo.'),

-- --- SZA: CTRL (Disk 142) ---
(4, 142, 'Standard Edition', 5, 'Il manifesto dell''R&B moderno. La voce di SZA è onesta e vulnerabile. Un disco che ogni ragazza dovrebbe avere.'),
(1, 142, 'Translucent Green Edition', 5, 'La stampa verde è magnifica e non ha fruscii. Il groove di questo album è incredibile.'),

-- --- AC/DC: Back in Black (Disk 130 - Traccia Thunderstruck assente ma usiamo Power Up) ---
(4, 130, 'Red Edition', 5, 'Se vuoi testare i bassi del tuo impianto, metti questo. Gli AC/DC non deludono mai, roccia pura.'),
(1, 130, 'Standard Edition', 4, 'Produzione cristallina di Angus Young. Non inventano nulla di nuovo, ma lo fanno meglio di chiunque altro.'),

-- --- ARIANA GRANDE: eternal sunshine (Disk 24) ---
(1, 24, 'Standard Edition', 5, 'Il miglior lavoro di Ariana. Un concept album maturo, con sonorità che ricordano il miglior R&B dei primi anni 2000.'),
(4, 24, 'Ruby Edition', 5, 'L''edizione rossa è semplicemente magnetica. Il vinile suona pulito e mette in risalto le armonie vocali stratificate.'),

-- --- THE ROLLING STONES: Hackney Diamonds (Disk 137) ---
(3, 137, 'Standard Edition', 4, 'Chi avrebbe mai detto che avrebbero tirato fuori un album così fresco a questa età? "Angry" ha un riff pazzesco.'),
(2, 137, 'Clear Edition', 5, 'Stampa di alta qualità. Nonostante sia un vinile trasparente, il rumore di fondo è praticamente inesistente. Ottima dinamica.'),

-- --- MADONNA: Confessions on a Dance Floor (Disk 102) ---
(1, 102, 'Pink Edition', 5, 'Un classico istantaneo del pop. Il vinile rosa è un pezzo da collezione che ogni fan di Madonna dovrebbe avere.'),
(4, 102, 'Pink Edition', 5, 'Il mix continuo tra le tracce è reso benissimo su vinile. Un viaggio senza interruzioni nel mondo della dance.'),

-- --- NIRVANA: In Utero (Disk 121) ---
(3, 121, 'Standard Edition', 5, 'Il suono è molto più grezzo e reale rispetto a Nevermind. La batteria in "Scentless Apprentice" è un pugno nello stomaco.'),
(2, 121, 'Clear Edition', 4, 'La versione trasparente è bellissima. Il suono cattura perfettamente l''estetica lo-fi e abrasiva voluta da Albini.'),

-- --- SZA: SOS (Disk 143) ---
(4, 143, 'Standard Edition', 5, 'Un disco lungo ma che non annoia mai. SZA riesce a passare dal punk al soul con una naturalezza disarmante.'),
(1, 143, 'Transparent Blue Edition', 5, 'Il blu del vinile richiama perfettamente la copertina. "Kill Bill" suonata sul piatto ha tutto un altro fascino.'),

-- --- THE BEATLES: Let It Be (Disk 40) ---
(2, 40, 'Standard Edition', 4, 'Un album sofferto ma con vette altissime. La title track e "Get Back" sono pilastri della musica moderna.'),
(3, 40, 'Standard Edition', 3, 'Si sente che la band stava per sciogliersi. Alcune tracce sembrano incompiute, ma resta comunque un pezzo di storia.'),

-- --- DUA LIPA: Radical Optimism (Disk 13) ---
(1, 13, 'Standard Edition', 4, 'Meno disco del precedente, più psichedelico e curato. "Houdini" è un tormentone prodotto in modo eccellente.'),
(4, 13, 'Red Edition', 4, 'Ho apprezzato molto la virata sonora di Dua Lipa. Il vinile rosso traslucido è uno dei più belli della mia collezione.'),

-- --- PINGUINI TATTICI NUCLEARI: Fuori dall'hype (Disk 83) ---
(4, 83, 'Green Edition', 5, 'L''album della consacrazione. Ogni canzone racconta una storia in cui è facile immedesimarsi.'),
(1, 83, 'Standard Edition', 4, 'Un mix perfetto di indie e pop. Testi mai banali e ritornelli che ti entrano subito in testa.'),

-- --- THE WEEKND: Dawn FM (Disk 30) ---
(2, 30, 'Standard Edition', 5, 'Un concept album radiofonico geniale. La transizione tra le tracce è perfetta, specialmente tra "How Do I Make You Love Me?" e "Take My Breath".'),
(4, 30, 'Silver Edition', 5, 'L''edizione Silver ha un riflesso metallico stupendo. La voce di Jim Carrey come DJ aggiunge un tocco surreale fantastico.'),

-- --- LINKIN PARK: Hybrid Theory EP (Disk 56) ---
(3, 56, 'Standard EP', 5, 'Per chi vuole capire le origini della band. "Carousel" è una gemma nascosta che merita di essere ascoltata su supporto fisico.'),

-- --- AC/DC: Stiff Upper Lip (Disk 127) ---
(3, 127, 'Standard Edition', 4, 'Un ritorno alle radici bluesy della band. Semplice, onesto e con un groove che non ti lascia mai.'),

-- --- TAYLOR SWIFT: Midnights (Disk 5) ---
(1, 5, 'Moonstone Blue Edition', 5, 'Atmosfere sognanti e testi introspettivi. "Anti-Hero" è già un classico del pop moderno.'),
(4, 5, 'Blood Moon Edition', 4, 'La variante Blood Moon ha un colore arancio bruciato spettacolare. La produzione di Jack Antonoff qui è molto curata.');

-- wishlist's users
INSERT INTO wishlist (user_id, disk_id, edition_name, priority_level) VALUES
-- Maria Rossi (User 1 - Admin & Pop Fan)
(1, 5, 'Blood Moon Edition', 3),       -- Midnights (Edizione speciale)
(1, 13, 'Red Edition', 2),             -- Radical Optimism
(1, 24, 'Ruby Edition', 3),             -- eternal sunshine
(1, 30, 'Silver Edition', 1),           -- Dawn FM
(1, 37, 'White Edition', 3),            -- White Album
(1, 78, 'Blue Edition', 2),             -- The Division Bell
(1, 114, 'Ruby Red Edition', 2),        -- E poi siamo finiti nel vortice
(1, 143, 'Transparent Blue Edition', 3), -- SOS

-- Stan Smith (User 2 - Audiophile & Jazz Lover)
(2, 39, 'Standard Edition', 3),         -- Abbey Road (Classico imperdibile)
(2, 49, 'Opaque White Edition', 3),     -- A Moon Shaped Pool (Edizione limitata)
(2, 55, 'Blue Edition', 2),             -- From Zero (Versione colorata)
(2, 61, 'Blue & Violet Edition', 3),    -- Ultraviolence
(2, 75, 'Standard Edition', 3),         -- The Wall (Pezzo fondamentale)
(2, 102, 'Pink Edition', 2),            -- Confessions on a Dance Floor
(2, 120, 'Silver Edition (Anniversary)', 3), -- Nevermind (Ristampa audiofila)
(2, 137, 'Clear Edition', 2),           -- Hackney Diamonds

-- Mike Johnson (User 3 - Rock and Roll Fan)
(3, 46, 'Standard Edition', 1),         -- Hail to the Thief
(3, 53, 'Standard Edition', 2),         -- The Hunting Party
(3, 56, 'Standard EP', 3),              -- Hybrid Theory EP (Rarità)
(3, 119, 'White Edition', 2),           -- Bleach
(3, 121, 'Clear Edition', 3),           -- In Utero
(3, 127, 'Standard Edition', 2),        -- Stiff Upper Lip
(3, 130, 'Red Edition', 3),             -- Power Up
(3, 136, 'Standard Edition', 1),        -- Blue & Lonesome

-- Sarah Williams (User 4 - Alternative & Collector)
(4, 3, 'Pink & Blue Edition', 3),       -- Lover (Edizione colorata)
(4, 4, 'Meet Me Behind The Mall (Grey Edition)', 3), -- folklore
(4, 21, 'Peach Edition', 2),            -- Sweetener
(4, 23, 'Coke Bottle Clear Edition', 3), -- Positions
(4, 28, 'Translucent Red Edition', 3),  -- Starboy
(4, 60, 'Red Edition', 2),              -- Born to Die
(4, 62, 'Translucent Red Edition', 3),  -- Honeymoon
(4, 71, 'Transparent Red Edition', 2),  -- Metal Galaxy
(4, 83, 'Green Edition', 1),            -- Fuori dall'hype
(4, 86, 'White Edition', 2),            -- Ahia!
(4, 106, 'Translucent Blue Edition', 3), -- Madame X
(4, 113, 'Red Edition', 2),             -- Nuda
(4, 142, 'Translucent Green Edition', 3); -- Ctrl


-- Collection's users
INSERT INTO ownership (user_id, disk_id, edition_name, date_acquired, rating) VALUES
-- Maria Rossi (User 1 - La collezionista Pop)
(1, 1, 'Standard Edition', '2023-01-15 10:30:00', 3),    -- 1989
(1, 2, 'Standard Edition', '2023-02-20 14:15:00', 4),    -- reputation
(1, 11, 'Standard Edition', '2023-05-10 18:00:00', 2),   -- Dua Lipa
(1, 12, 'Standard Edition', '2023-06-05 12:00:00', 4),   -- Future Nostalgia
(1, 22, 'Standard Edition', '2023-11-20 09:45:00', 1),   -- thank u, next
(1, 28, 'Standard Edition', '2024-01-12 16:30:00', 4),   -- Starboy
(1, 114, 'Standard Edition', '2024-03-01 11:20:00', NULL),  -- E poi siamo finiti nel vortice
(1, 143, 'Standard Edition', '2024-05-15 14:00:00', 5),  -- SOS
(1, 29, 'Standard Edition', '2024-01-01 10:00:00', NULL),
(1, 39, 'Standard Edition', '2024-01-01 10:00:00', 1),
(1, 60, 'Standard Edition', '2024-01-01 10:00:00', 2),
(1, 84, 'Standard Edition', '2024-01-01 10:00:00', 3),
(1, 49, 'Opaque White Edition', '2024-01-01 10:00:00', 4),
(1, 75, 'Standard Edition', '2024-01-01 10:00:00', 5),
(1, 55, 'Blue Edition', '2024-01-01 10:00:00', NULL),
(1, 113, 'Standard Edition', '2024-01-01 10:00:00', 1),
(1, 37, 'White Edition', '2024-01-01 10:00:00', 2),
(1, 142, 'Translucent Green Edition', '2024-01-01 10:00:00', 3),
(1, 130, 'Standard Edition', '2024-01-01 10:00:00', 4),
(1, 24, 'Standard Edition', '2024-01-01 10:00:00', 5),
(1, 102, 'Pink Edition', '2024-01-01 10:00:00', NULL),
(1, 143, 'Transparent Blue Edition', '2024-01-01 10:00:00', 1),
(1, 13, 'Standard Edition', '2024-01-01 10:00:00', 2),
(1, 83, 'Standard Edition', '2024-01-01 10:00:00', 3),
(1, 5, 'Moonstone Blue Edition', '2024-01-01 10:00:00', 4),

-- Stan Smith (User 2 - L'audiofilo selettivo)
(2, 39, 'Standard Edition', '2022-12-01 08:30:00', 1),   -- Abbey Road
(2, 47, 'Standard Edition', '2023-03-14 15:45:00', 5),   -- In Rainbows
(2, 49, 'Standard Edition', '2023-04-20 10:00:00', NULL),   -- A Moon Shaped Pool
(2, 75, 'Standard Edition', '2023-07-22 17:30:00', 3),   -- The Wall
(2, 78, 'Standard Edition', '2023-08-10 11:00:00', 4),   -- The Division Bell
(2, 102, 'Pink Edition', '2023-10-05 13:15:00', NULL),      -- Confessions on a Dance Floor
(2, 120, 'Standard Edition', '2023-12-24 18:30:00', 2),  -- Nevermind
(2, 137, 'Standard Edition', '2024-02-14 09:00:00', 4),  -- Hackney Diamonds
(2, 29, 'Standard Edition', '2024-01-01 10:00:00', 5),
(2, 60, 'Red Edition', '2024-01-01 10:00:00', NULL),
(2, 12, 'Standard Edition', '2024-01-01 10:00:00', 1),
(2, 114, 'Standard Edition', '2024-01-01 10:00:00', 2),
(2, 130, 'Standard Edition', '2024-01-01 10:00:00', 3),
(2, 4, 'Meet Me Behind The Mall (Grey Edition)', '2024-01-01 10:00:00', 4),
(2, 120, 'Silver Edition (Anniversary)', '2024-01-01 10:00:00', 5),
(2, 37, 'Standard Edition', '2024-01-01 10:00:00', NULL),
(2, 137, 'Clear Edition', '2024-01-01 10:00:00', 1),
(2, 121, 'Clear Edition', '2024-01-01 10:00:00', 2),
(2, 40, 'Standard Edition', '2024-01-01 10:00:00', 3),
(2, 30, 'Standard Edition', '2024-01-01 10:00:00', 4),

-- Mike Johnson (User 3 - Il rocker puro)
(3, 53, 'Standard Edition', '2023-02-10 14:00:00', 4),   -- The Hunting Party
(3, 54, 'Standard Edition', '2023-03-05 16:20:00', 3),   -- One More Light
(3, 55, 'Standard Edition', '2024-01-20 10:30:00', 1),   -- From Zero
(3, 119, 'Standard Edition', '2023-06-15 11:45:00', NULL),  -- Bleach
(3, 120, 'Standard Edition', '2023-07-01 15:00:00', 5),  -- Nevermind
(3, 121, 'Standard Edition', '2023-09-12 18:10:00', 3),  -- In Utero
(3, 127, 'Standard Edition', '2023-11-05 09:30:00', 4),  -- Stiff Upper Lip
(3, 130, 'Standard Edition', '2024-02-28 14:00:00', NULL),  -- Power Up
(3, 29, 'Standard Edition', '2024-01-01 10:00:00', 5),
(3, 39, 'Standard Edition', '2024-01-01 10:00:00', NULL),
(3, 84, 'Standard Edition', '2024-01-01 10:00:00', 1),
(3, 93, 'Standard Edition', '2024-01-01 10:00:00', 2),
(3, 4, 'Standard Edition', '2024-01-01 10:00:00', 3),
(3, 75, 'Standard Edition', '2024-01-01 10:00:00', 4),
(3, 69, 'Standard Edition', '2024-01-01 10:00:00', 5),
(3, 137, 'Standard Edition', '2024-01-01 10:00:00', NULL),
(3, 40, 'Standard Edition', '2024-01-01 10:00:00', 1),
(3, 56, 'Standard EP', '2024-01-01 10:00:00', 2),

-- Sarah Williams (User 4 - L'alternativa e collezionista di edizioni speciali)
(4, 3, 'Pink & Blue Edition', '2023-04-12 12:00:00', 5), -- Lover
(4, 4, 'Standard Edition', '2023-05-20 10:15:00', 3),    -- folklore
(4, 23, 'Coke Bottle Clear Edition', '2023-08-15 14:30:00', 4), -- Positions
(4, 28, 'Translucent Red Edition', '2023-09-30 11:00:00', 5),   -- Starboy
(4, 60, 'Red Edition', '2023-11-12 16:45:00', NULL),        -- Born to Die
(4, 61, 'Standard Edition', '2023-12-05 13:00:00', 4),   -- Ultraviolence
(4, 84, 'Standard Edition', '2024-02-10 09:30:00', 1),   -- Fake News
(4, 142, 'Standard Edition', '2024-04-22 17:00:00', 2),  -- Ctrl
(4, 29, 'Standard Edition', '2024-01-01 10:00:00', 3),
(4, 39, 'Standard Edition', '2024-01-01 10:00:00', 4),
(4, 60, 'Standard Edition', '2024-01-01 10:00:00', 5),
(4, 84, 'Pink Edition', '2024-01-01 10:00:00', NULL),
(4, 12, 'Neon Pink Edition', '2024-01-01 10:00:00', 1),
(4, 49, 'Standard Edition', '2024-01-01 10:00:00', 2),
(4, 114, 'Ruby Red Edition', '2024-01-01 10:00:00', 3),
(4, 93, 'Standard Edition', '2024-01-01 10:00:00', 4),
(4, 22, 'Standard Edition', '2024-01-01 10:00:00', 5),
(4, 120, 'Standard Edition', '2024-01-01 10:00:00', NULL),
(4, 69, 'Red Edition', '2024-01-01 10:00:00', 1),
(4, 113, 'Red Edition', '2024-01-01 10:00:00', 2),
(4, 47, 'Standard Edition', '2024-01-01 10:00:00', 3),
(4, 130, 'Red Edition', '2024-01-01 10:00:00', 4),
(4, 24, 'Ruby Edition', '2024-01-01 10:00:00', 5),
(4, 102, 'Pink Edition', '2024-01-01 10:00:00', NULL),
(4, 143, 'Standard Edition', '2024-01-01 10:00:00', 1),
(4, 13, 'Red Edition', '2024-01-01 10:00:00', 2),
(4, 83, 'Green Edition', '2024-01-01 10:00:00', 3),
(4, 30, 'Silver Edition', '2024-01-01 10:00:00', 4),
(4, 5, 'Blood Moon Edition', '2024-01-01 10:00:00', 5);


-- Aggiunta
INSERT INTO author (author_name, image_path, nationality, bio_author) VALUES
('Gracie Abrams', 'assets/images/artists/gracie_abrams.jpg', 'us', 'Cantautrice indie-pop nota per i suoi testi confessionali e la collaborazione con Aaron Dessner.');

INSERT INTO disk (title, disk_type, label) VALUES
('The Secret of Us', 'Album', 'Interscope Records'),
('Close To You', 'Single', 'Interscope Records');

INSERT INTO disk_author_release (disk_id, author_id) VALUES
(150, 19),
(151, 19);

INSERT INTO disk_genre_classification (disk_id, genre_name) VALUES
(150, 'Pop'),
(151, 'Pop');

INSERT INTO track (title, duration_seconds) VALUES
('Felt Good About You', 164), ('Risk', 191), ('Blowing Smoke', 213), ('Free Now', 219),
('Let It Happen', 260), ('Tough Love', 169), ('I Knew It, I Know You', 252), ('Gave It To You I Did', 141),
('Normal Thing', 242), ('Good Luck Charlie', 236), ('You Learned It', 171), ('I Love You, I’m Sorry', 157),
('us (feat. Taylor Swift)', 242), ('Close To You', 225);

INSERT INTO edition (disk_id, edition_name, release_date, image_path, country) VALUES
(150, 'Standard Edition', '2024-06-21', 'assets/images/covers/the_secret_of_us.jpg', 'US'),
(151, 'Yellow Vinyl Single', '2024-06-07', 'assets/images/covers/close_to_you.jpg', 'US');

INSERT INTO edition_track_part_of (disk_id, edition_name, track_id, track_number) VALUES
(150, 'Standard Edition', 741, 1), (150, 'Standard Edition', 742, 2), (150, 'Standard Edition', 743, 3),
(150, 'Standard Edition', 744, 4), (150, 'Standard Edition', 745, 5), (150, 'Standard Edition', 746, 6),
(150, 'Standard Edition', 747, 7), (150, 'Standard Edition', 748, 8), (150, 'Standard Edition', 749, 9),
(150, 'Standard Edition', 750, 10), (150, 'Standard Edition', 751, 11), (150, 'Standard Edition', 752, 12),
(150, 'Standard Edition', 753, 13), (151, 'Yellow Vinyl Single', 754, 1);


INSERT INTO wishlist (user_id, disk_id, edition_name, priority_level) VALUES
-- Maria Rossi (User 1)
(1, 29, 'Standard Edition', 3),     -- The Dark Side of the Moon
(1, 60, 'Standard Edition', 2),     -- Born to Die
(1, 3, 'Pink & Blue Edition', 3),   -- Lover (Edizione speciale esistente)
(1, 137, 'Clear Edition', 1),       -- Hackney Diamonds (Edizione speciale esistente)
(1, 12, 'Neon Pink Edition', 3),    -- Future Nostalgia (Edizione speciale esistente)
(1, 49, 'Standard Edition', 2),     -- A Moon Shaped Pool
(1, 84, 'Pink Edition', 1),         -- Fake News (Edizione speciale esistente)
(1, 75, 'Standard Edition', 3),     -- The Wall
(1, 130, 'Red Edition', 2),         -- Power Up (Edizione speciale esistente)
(1, 114, 'Standard Edition', 1),    -- E poi siamo finiti nel vortice
(1, 142, 'Standard Edition', 2),    -- Ctrl
(1, 102, 'Pink Edition', 1),        -- Confessions on a Dance Floor

-- Stan Smith (User 2)
(2, 47, 'Standard Edition', 3),     -- In Rainbows
(2, 120, 'Standard Edition', 2),    -- Nevermind
(2, 113, 'Red Edition', 3),         -- Relax (Edizione speciale esistente)
(2, 69, 'Red Edition', 2),          -- The Fame Monster (Edizione speciale esistente)
(2, 121, 'Clear Edition', 1),       -- In Utero (Edizione speciale esistente)
(2, 143, 'Standard Edition', 3),    -- SOS
(2, 13, 'Red Edition', 2),          -- Radical Optimism (Edizione speciale esistente)
(2, 83, 'Green Edition', 1),        -- The Dark Side... (altra variante se esiste o disco simile)
(2, 22, 'Standard Edition', 3),     -- thank u, next
(2, 114, 'Ruby Red Edition', 2),    -- E poi siamo finiti nel vortice
(2, 93, 'Standard Edition', 1),     -- AM
(2, 4, 'Meet Me Behind The Mall (Grey Edition)', 3), -- folklore (Edizione esistente)
(2, 56, 'Standard EP', 2),          -- Club Future Nostalgia

-- Mike Johnson (User 3)
(3, 119, 'Standard Edition', 3),    -- Bleach
(3, 55, 'Standard Edition', 1),     -- From Zero
(3, 40, 'Standard Edition', 2),     -- Let It Be
(3, 130, 'Standard Edition', 1),    -- Power Up
(3, 23, 'Coke Bottle Clear Edition', 3), -- Positions (Edizione speciale esistente)
(3, 28, 'Translucent Red Edition', 2),   -- Starboy (Edizione speciale esistente)
(3, 61, 'Standard Edition', 1),     -- Ultraviolence
(3, 54, 'Standard Edition', 3),     -- One More Light
(3, 37, 'Standard Edition', 2),     -- White Album
(3, 142, 'Translucent Green Edition', 1), -- Ctrl (Edizione speciale esistente)

-- Sarah Williams (User 4)
(4, 30, 'Standard Edition', 3),     -- Dawn FM
(4, 13, 'Standard Edition', 2),     -- Radical Optimism
(4, 83, 'Standard Edition', 1),     -- (Disco ID 83)
(4, 143, 'Transparent Blue Edition', 3), -- SOS (Edizione speciale esistente)
(4, 12, 'Standard Edition', 2),     -- Future Nostalgia
(4, 49, 'Opaque White Edition', 1), -- A Moon Shaped Pool (Edizione speciale esistente)
(4, 120, 'Silver Edition (Anniversary)', 3), -- Nevermind (Edizione speciale esistente)
(4, 4, 'Standard Edition', 2),      -- folklore
(4, 137, 'Standard Edition', 1),    -- Hackney Diamonds
(4, 78, 'Standard Edition', 3),     -- The Division Bell
(4, 29, 'Standard Edition', 1),     -- The Dark Side of the Moon
(4, 93, 'Standard Edition', 3);


-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;