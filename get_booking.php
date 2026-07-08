<?php
include('db.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT b.*, t.TourName, t.Destination, t.Duration, t.Price AS UnitPrice FROM Bookings b JOIN Tours t ON b.TourID = t.id WHERE b.id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Booking not found']);
    }
}
$conn->close();
?>