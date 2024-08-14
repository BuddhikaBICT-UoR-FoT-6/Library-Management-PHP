<?php
include 'db.php';

function getUsers() {
    global $conn;
    
    $query = "SELECT * FROM users ORDER BY name";
    $result = $conn->query($query);
    
    echo '<div class="users-list">';
    echo '<h2>Library Users</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Registration Date</th></tr>';
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
            echo '<td>' . $row['registration_date'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">No users found</td></tr>';
    }
    
    echo '</table>';
    echo '</div>';
}

getUsers();
?>