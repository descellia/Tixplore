<?php
// views/event_details.php
require_once 'db.php';

// Ambil event_name dari URL, misalnya dari router
$event_name = isset($event_name) ? $event_name : null;

if ($event_name) {
    // Query untuk mendapatkan detail event berdasarkan nama event
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_slug = :event_name");
    $stmt->execute(['event_name' => $event_name]);
    $event = $stmt->fetch();

    if ($event) {
        // Tampilkan detail event
        echo "<h1>" . htmlspecialchars($event['event_name']) . "</h1>";
        echo "<p>" . htmlspecialchars($event['description']) . "</p>";
        echo "<p>Date: " . htmlspecialchars($event['event_date']) . "</p>";
    } else {
        // Event tidak ditemukan
        echo "<p>Event not found</p>";
    }
} else {
    // Jika event_name tidak ada di URL
    echo "<p>Invalid event</p>";
}
?>
