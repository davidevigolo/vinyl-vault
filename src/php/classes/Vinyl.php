<?php
class Vinyl {
    // Disk properties
    private $diskId;
    private $title;
    private $diskType; // EP, ALBUM, or SINGLE
    
    // Edition properties
    private $editionName;
    private $releaseDate;
    
    // Related data
    private $authors = [];
    private $genres = [];
    private $tracks = [];
    
    public function __construct($diskId = null, $title = null, $diskType = null, $editionName = null, $releaseDate = null) {
        $this->diskId = $diskId;
        $this->title = $title;
        $this->diskType = $diskType;
        $this->editionName = $editionName;
        $this->releaseDate = $releaseDate;
    }
    
    // Getters
    public function get_disk_id() {
        return $this->diskId;
    }
    
    public function get_title() {
        return $this->title;
    }
    
    public function get_disk_type() {
        return $this->diskType;
    }
    
    public function get_edition_name() {
        return $this->editionName;
    }
    
    public function get_release_date() {
        return $this->releaseDate;
    }
    
    public function get_authors() {
        return $this->authors;
    }
    
    public function get_genres() {
        return $this->genres;
    }
    
    public function get_tracks() {
        return $this->tracks;
    }
    
    // Setters
    public function set_disk_id($diskId) {
        $this->diskId = $diskId;
    }
    
    public function set_title($title) {
        $this->title = $title;
    }
    
    public function set_disk_type($diskType) {
        $this->diskType = $diskType;
    }
    
    public function set_edition_name($editionName) {
        $this->editionName = $editionName;
    }
    
    public function set_release_date($releaseDate) {
        $this->releaseDate = $releaseDate;
    }
    
    public function add_author($author) {
        $this->authors[] = $author;
    }
    
    public function set_authors($authors) {
        $this->authors = $authors;
    }
    
    public function add_genre($genre) {
        $this->genres[] = $genre;
    }
    
    public function set_genres($genres) {
        $this->genres = $genres;
    }
    
    public function add_track($track) {
        $this->tracks[] = $track;
    }
    
    public function set_tracks($tracks) {
        $this->tracks = $tracks;
    }
    
    // Database operations
    public static function get_vinyl_by_id($diskId, $editionName, $db) {
        $query = "SELECT d.id, d.title, d.disk_type, e.edition_name, e.release_date 
                  FROM disk d 
                  JOIN edition e ON d.id = e.disk_id 
                  WHERE d.id = ? AND e.edition_name = ?";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $diskId, $editionName);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $vinyl = new Vinyl($row['id'], $row['title'], $row['disk_type'], $row['edition_name'], $row['release_date']);
            $vinyl->load_authors($db);
            $vinyl->load_genres($db);
            $vinyl->load_tracks($db);
            return $vinyl;
        }
        
        return null;
    }
    
    public static function get_all_vinyls($db) {
        $query = "SELECT d.id, d.title, d.disk_type, e.edition_name, e.release_date 
                  FROM disk d 
                  JOIN edition e ON d.id = e.disk_id 
                  ORDER BY e.release_date DESC";
        
        $result = $db->query($query);
        $vinyls = [];
        
        while ($row = $result->fetch_assoc()) {
            $vinyl = new Vinyl($row['id'], $row['title'], $row['disk_type'], $row['edition_name'], $row['release_date']);
            $vinyl->load_authors($db);
            $vinyl->load_genres($db);
            $vinyls[] = $vinyl;
        }
        
        return $vinyls;
    }
    
    private function load_authors($db) {
        $query = "SELECT a.author_name 
                  FROM author a 
                  JOIN disk_author_release dar ON a.id = dar.author_id 
                  WHERE dar.disk_id = ?";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $this->diskId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $this->authors[] = $row['author_name'];
        }
    }
    
    private function load_genres($db) {
        $query = "SELECT g.genre_name 
                  FROM genre g 
                  JOIN disk_genre_classification dgc ON g.genre_name = dgc.genre_name 
                  WHERE dgc.disk_id = ?";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $this->diskId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $this->genres[] = $row['genre_name'];
        }
    }
    
    private function load_tracks($db) {
        $query = "SELECT t.title, t.duration_seconds, etp.track_number 
                  FROM track t 
                  JOIN edition_track_part_of etp ON t.id = etp.track_id 
                  WHERE etp.disk_id = ? AND etp.ed_name = ? 
                  ORDER BY etp.track_number";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $this->diskId, $this->editionName);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $this->tracks[] = [
                'number' => $row['track_number'],
                'title' => $row['title'],
                'duration' => $row['duration_seconds']
            ];
        }
    }
    
    public function save($db) {
        // Insert disk if it doesn't exist
        $query = "INSERT INTO disk (id, title, disk_type) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $this->diskId, $this->title, $this->diskType);
        $stmt->execute();
        
        // Insert edition
        $query = "INSERT INTO edition (disk_id, edition_name, release_date) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $this->diskId, $this->editionName, $this->releaseDate);
        $stmt->execute();
    }
    
    public function to_array() {
        return [
            'diskId' => $this->diskId,
            'title' => $this->title,
            'diskType' => $this->diskType,
            'editionName' => $this->editionName,
            'releaseDate' => $this->releaseDate,
            'authors' => $this->authors,
            'genres' => $this->genres,
            'tracks' => $this->tracks
        ];
    }
}