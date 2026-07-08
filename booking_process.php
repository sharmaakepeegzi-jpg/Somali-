<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tour_id = $_POST['tour_id'];
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $num_people = $_POST['number_of_people'];
    $total_price = $_POST['total_price'];
    $booking_date = date('Y-m-d');

    // Hubi in boos bannaan yahay
    $check_sql = "SELECT AvailableSpots FROM Tours WHERE id='$tour_id'";
    $check_result = $conn->query($check_sql);
    $tour = $check_result->fetch_assoc();

    if ($tour['AvailableSpots'] >= $num_people) {
        $insert_sql = "INSERT INTO Bookings (TourID, CustomerName, Phone, Email, NumberOfPeople, BookingDate, TotalPrice)
                       VALUES ('$tour_id', '$customer_name', '$phone', '$email', '$num_people', '$booking_date', '$total_price')";
        
        if ($conn->query($insert_sql)) {
            // Yaraynta tirada boosaska
            $update_sql = "UPDATE Tours SET AvailableSpots = AvailableSpots - $num_people WHERE id='$tour_id'";
            $conn->query($update_sql);
            
            header("Location: tourism.php?booking=success");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Boos kuma filna! Waxaa harsan " . $tour['AvailableSpots'] . " boos.";
    }
}
$conn->close();
?>