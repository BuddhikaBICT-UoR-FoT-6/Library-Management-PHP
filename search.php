<?php
include 'db.php';

function search($q) {
    global $conn;
    
    if (empty($q)) {
        return array();
    }
    
    $query = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?";
    $param = "%" . $q . "%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $param, $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $books = array();
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    return $books;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['q'])) {
    $results = search($_GET['q']);
    
    echo '<div class="search-results">';
    echo '<h3>Search Results for: ' . htmlspecialchars($_GET['q']) . '</h3>';
    
    if (count($results) > 0) {
        foreach ($results as $book) {
            echo '<div class="book-result">';
            echo '<h4>' . htmlspecialchars($book['title']) . '</h4>';
            echo '<p>Author: ' . htmlspecialchars($book['author']) . '</p>';
            echo '<p>ISBN: ' . htmlspecialchars($book['isbn']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No results found</p>';
    }
    echo '</div>';
}
?>