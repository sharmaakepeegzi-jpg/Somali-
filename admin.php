<?php
include('db.php');
session_start();

$admin_password = "123";

// Login
if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = "Password is incorrect!";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// PDF report (HTML-style report)
if ($is_logged_in && isset($_POST['generate_pdf'])) {
    $booking_id = $_POST['booking_id'];
    $booking_sql = "SELECT b.*, t.TourName, t.Destination, t.Duration, t.Price AS UnitPrice
                    FROM Bookings b JOIN Tours t ON b.TourID = t.id WHERE b.id='$booking_id'";
    $booking_result = $conn->query($booking_sql);
    if ($booking_result->num_rows > 0) {
        $b = $booking_result->fetch_assoc();
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #FFD700; padding-bottom: 10px; }
                .gold-text { color: #FFD700; font-weight: bold; }
                .details { margin: 20px 0; background: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 4px solid #FFD700; }
                .detail-row { margin: 10px 0; padding: 5px; }
                .detail-label { font-weight: bold; color: #1a237e; display: inline-block; width: 160px; }
                .footer { margin-top: 50px; text-align: center; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>DALLO <span class="gold-text">TOURISM</span></h1>
                <h2>Booking Confirmation</h2>
            </div>
            <div class="details">
                <div class="detail-row"><span class="detail-label">Booking ID:</span> DT-' . $b['id'] . '</div>
                <div class="detail-row"><span class="detail-label">Tour Name:</span> ' . $b['TourName'] . '</div>
                <div class="detail-row"><span class="detail-label">Destination:</span> ' . $b['Destination'] . '</div>
                <div class="detail-row"><span class="detail-label">Duration:</span> ' . $b['Duration'] . '</div>
                <div class="detail-row"><span class="detail-label">Customer:</span> ' . $b['CustomerName'] . '</div>
                <div class="detail-row"><span class="detail-label">Phone:</span> ' . $b['Phone'] . '</div>
                <div class="detail-row"><span class="detail-label">Number of People:</span> ' . $b['NumberOfPeople'] . '</div>
                <div class="detail-row"><span class="detail-label">Total Price:</span> $' . $b['TotalPrice'] . '</div>
                <div class="detail-row"><span class="detail-label">Booking Date:</span> ' . $b['BookingDate'] . '</div>
            </div>
            <div class="footer">
                <p><strong>Dallo Tourism – Trust Your Travel Adventure</strong></p>
                <p>Email: info@dallotourism.so | Tel: +252 63 123 4567</p>
                <p>Generated automatically. No signature required.</p>
            </div>
        </body>
        </html>';
        header('Content-Type: text/html');
        header('Content-Disposition: inline; filename="booking_DT-' . $b['id'] . '.html"');
        echo $html;
        exit();
    }
}

// Handle CRUD operations for Tours and Bookings
if ($is_logged_in) {
    // Add Tour
    if (isset($_POST['add_tour'])) {
        $tour_name = $_POST['tour_name'];
        $destination = $_POST['destination'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $available = $_POST['available_spots'];
        $tour_date = $_POST['tour_date'];
        $image = $_POST['image'] ?? 'default_tour.jpg';
        $conn->query("INSERT INTO Tours (TourName, Destination, Description, Duration, Price, AvailableSpots, TourDate, Image)
                      VALUES ('$tour_name', '$destination', '$description', '$duration', '$price', '$available', '$tour_date', '$image')");
        $success = "Tour added successfully!";
    }
    // Update Tour
    if (isset($_POST['update_tour'])) {
        $id = $_POST['tour_id'];
        $tour_name = $_POST['tour_name'];
        $destination = $_POST['destination'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $available = $_POST['available_spots'];
        $tour_date = $_POST['tour_date'];
        $conn->query("UPDATE Tours SET TourName='$tour_name', Destination='$destination', Description='$description',
                      Duration='$duration', Price='$price', AvailableSpots='$available', TourDate='$tour_date' WHERE id='$id'");
        $success = "Tour updated successfully!";
    }
    // Delete Tour
    if (isset($_POST['delete_tour'])) {
        $id = $_POST['tour_id'];
        $conn->query("DELETE FROM Tours WHERE id='$id'");
        $success = "Tour deleted successfully!";
    }
    // Update Booking
    if (isset($_POST['update_booking'])) {
        $id = $_POST['booking_id'];
        $name = $_POST['customer_name'];
        $phone = $_POST['phone'];
        $people = $_POST['number_of_people'];
        $old_people = $_POST['old_people'];
        $tour_id = $_POST['tour_id'];
        // Return old spots
        $conn->query("UPDATE Tours SET AvailableSpots = AvailableSpots + $old_people WHERE id='$tour_id'");
        // Update booking and subtract new spots
        $conn->query("UPDATE Bookings SET CustomerName='$name', Phone='$phone', NumberOfPeople='$people' WHERE id='$id'");
        $conn->query("UPDATE Tours SET AvailableSpots = AvailableSpots - $people WHERE id='$tour_id'");
        $success = "Booking updated successfully!";
    }
    // Delete Booking
    if (isset($_POST['delete_booking'])) {
        $id = $_POST['booking_id'];
        $b_sql = $conn->query("SELECT TourID, NumberOfPeople FROM Bookings WHERE id='$id'");
        $b_row = $b_sql->fetch_assoc();
        $conn->query("UPDATE Tours SET AvailableSpots = AvailableSpots + {$b_row['NumberOfPeople']} WHERE id='{$b_row['TourID']}'");
        $conn->query("DELETE FROM Bookings WHERE id='$id'");
        $success = "Booking deleted successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dallo Tourism – Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Admin CSS – unchanged */
        :root {
            --primary: #08a212;
            --secondary: #1a237e;
            --accent: #283593;
            --light: #e9ebff;
            --dark: #121858;
            --success: #4CAF50;
            --danger: #f44336;
            --info: #2196F3;
            --warning: #ff9800;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
        body { background:#f5f5f5; color:#333; }
        .banner { background: linear-gradient(135deg, var(--secondary), var(--accent)); color: white; text-align: center; padding: 20px 0; }
        .banner h1 { font-size: 2.5rem; }
        .gold-text { color: var(--primary); font-weight: bold; }
        nav { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top:0; z-index:100; }
        .nav-container { display: flex; justify-content: space-between; align-items: center; max-width:1200px; margin:0 auto; padding:15px 20px; }
        .logo { font-size:1.5rem; color:var(--secondary); }
        .logo i { color:var(--primary); margin-right:10px; }
        .nav-links { list-style: none; display: flex; }
        .nav-links li { margin-left:25px; }
        .nav-links a { text-decoration:none; color:var(--secondary); font-weight:500; }
        .nav-links a.active, .nav-links a:hover { color:var(--primary); }
        .container { max-width:1200px; margin:30px auto; padding:0 20px; }
        .card { background:white; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.05); padding:25px; margin-bottom:30px; }
        .card h2 { color:var(--secondary); margin-bottom:20px; padding-bottom:10px; border-bottom:2px solid var(--light); }
        .form-group { margin-bottom:20px; }
        .form-group label { display:block; margin-bottom:8px; font-weight:500; }
        .form-control { width:100%; padding:12px; border:1px solid #ddd; border-radius:5px; }
        .form-control:focus { border-color:var(--primary); outline:none; }
        .btn { display:inline-block; border:none; padding:8px 15px; border-radius:5px; cursor:pointer; font-size:0.9rem; text-decoration:none; margin:2px; }
        .btn-primary { background:var(--primary); color:var(--dark); }
        .btn-danger { background:var(--danger); color:white; }
        .btn-info { background:var(--info); color:white; }
        .btn-warning { background:var(--warning); color:white; }
        .btn-success { background:var(--success); color:white; }
        table { width:100%; border-collapse:collapse; margin:20px 0; }
        table th, table td { padding:12px 15px; text-align:left; border-bottom:1px solid #ddd; }
        table th { background:var(--light); color:var(--secondary); }
        .modal { display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); }
        .modal-content { background:white; margin:3% auto; padding:30px; border-radius:10px; width:90%; max-width:600px; }
        .close { float:right; font-size:28px; cursor:pointer; }
        .action-buttons { display:flex; gap:5px; flex-wrap:wrap; }
        .login-container { max-width:400px; margin:100px auto; padding:30px; background:white; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
        .alert { padding:15px; border-radius:5px; margin-bottom:20px; }
        .alert-success { background:#d4edda; color:#155724; }
        footer { background:var(--secondary); color:white; text-align:center; padding:30px 0; margin-top:50px; }
        @media(max-width:768px) { .nav-container { flex-direction:column; } }
    </style>
</head>
<body>
    <div class="banner">
        <h1><span class="gold-text">Dallo Tourism</span> – Admin Panel</h1>
    </div>
    <nav>
        <div class="nav-container">
            <div class="logo"><i class="fas fa-umbrella-beach"></i> Dallo Tourism</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="tourism.php">Tours</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="admin.php" class="active">Admin</a></li>
                <?php if($is_logged_in): ?>
                <li><a href="admin.php?logout=true"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if(!$is_logged_in): ?>
            <div class="login-container">
                <h2><i class="fas fa-lock"></i> Admin Login</h2>
                <?php if(isset($login_error)): ?>
                    <div class="alert alert-danger"><?php echo $login_error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary" style="width:100%">Login</button>
                </form>
            </div>
        <?php else: ?>
            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <!-- ADD TOUR FORM -->
            <div class="card">
                <h2><i class="fas fa-plus-circle"></i> Add New Tourism</h2>
                <form method="POST">
                    <div class="form-group"><label>Tour Name</label><input type="text" name="tour_name" class="form-control" required></div>
                    <div class="form-group"><label>Destination</label><input type="text" name="destination" class="form-control" required></div>
                    <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
                    <div class="form-group"><label>Duration</label><input type="text" name="duration" class="form-control" required></div>
                    <div class="form-group"><label>Price per person ($)</label><input type="number" name="price" step="0.01" class="form-control" required></div>
                    <div class="form-group"><label>Number of available spots</label><input type="number" name="available_spots" value="20" class="form-control" required></div>
                    <div class="form-group"><label>Tour Date</label><input type="date" name="tour_date" class="form-control" required></div>
                    <button type="submit" name="add_tour" class="btn btn-primary" style="width:100%"><i class="fas fa-plus"></i> Add Tour</button>
                </form>
            </div>

            <!-- EXISTING TOURS -->
            <div class="card">
                <h2><i class="fas fa-list"></i> All Tours</h2>
                <?php
                $tours = $conn->query("SELECT * FROM Tours ORDER BY TourDate");
                if($tours->num_rows > 0):
                ?>
                <table>
                    <tr><th>ID</th><th>Name</th><th>Destination</th><th>Duration</th><th>Price</th><th>Available Spots</th><th>Date</th><th>Actions</th></tr>
                    <?php while($t = $tours->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $t['id']; ?></td>
                        <td><?php echo $t['TourName']; ?></td>
                        <td><?php echo $t['Destination']; ?></td>
                        <td><?php echo $t['Duration']; ?></td>
                        <td>$<?php echo $t['Price']; ?></td>
                        <td><?php echo $t['AvailableSpots']; ?></td>
                        <td><?php echo $t['TourDate']; ?></td>
                        <td class="action-buttons">
                            <button class="btn btn-info" onclick="openEditTourModal(<?php echo $t['id']; ?>)"><i class="fas fa-edit"></i></button>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="tour_id" value="<?php echo $t['id']; ?>">
                                <button class="btn btn-danger" name="delete_tour" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <?php else: echo "<p>No tours found.</p>"; endif; ?>
            </div>

            <!-- BOOKINGS -->
            <div class="card">
                <h2><i class="fas fa-users"></i> Bookings</h2>
                <?php
                $bookings = $conn->query("SELECT b.*, t.TourName, t.Destination FROM Bookings b JOIN Tours t ON b.TourID = t.id ORDER BY b.BookingDate DESC");
                if($bookings->num_rows > 0):
                ?>
                <table>
                    <tr><th>ID</th><th>Tour</th><th>Customer</th><th>Phone</th><th>People</th><th>Date</th><th>Total</th><th>Actions</th></tr>
                    <?php while($b = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td>DT-<?php echo $b['id']; ?></td>
                        <td><?php echo $b['TourName']; ?> (<?php echo $b['Destination']; ?>)</td>
                        <td><?php echo $b['CustomerName']; ?></td>
                        <td><?php echo $b['Phone']; ?></td>
                        <td><?php echo $b['NumberOfPeople']; ?></td>
                        <td><?php echo $b['BookingDate']; ?></td>
                        <td>$<?php echo $b['TotalPrice']; ?></td>
                        <td class="action-buttons">
                            <button class="btn btn-info" onclick="openEditBookingModal(<?php echo $b['id']; ?>)"><i class="fas fa-edit"></i></button>
                            <form method="POST" style="display:inline">
                                <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                <button class="btn btn-danger" name="delete_booking" onclick="return confirm('Delete this booking?')"><i class="fas fa-trash"></i></button>
                            </form>
                            <form method="POST" style="display:inline" target="_blank">
                                <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                <button class="btn btn-warning" name="generate_pdf"><i class="fas fa-file-pdf"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <?php else: echo "<p>No bookings found.</p>"; endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- EDIT TOUR MODAL -->
    <div id="editTourModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editTourModal')">&times;</span>
            <h2><i class="fas fa-edit"></i> Edit Tour</h2>
            <form method="POST" id="editTourForm">
                <input type="hidden" name="tour_id" id="edit_tour_id">
                <div class="form-group"><label>Tour Name</label><input type="text" name="tour_name" id="edit_tour_name" class="form-control" required></div>
                <div class="form-group"><label>Destination</label><input type="text" name="destination" id="edit_destination" class="form-control" required></div>
                <div class="form-group"><label>Description</label><textarea name="description" id="edit_description" class="form-control" rows="2"></textarea></div>
                <div class="form-group"><label>Duration</label><input type="text" name="duration" id="edit_duration" class="form-control" required></div>
                <div class="form-group"><label>Price ($)</label><input type="number" name="price" id="edit_price" step="0.01" class="form-control" required></div>
                <div class="form-group"><label>Available Spots</label><input type="number" name="available_spots" id="edit_spots" class="form-control" required></div>
                <div class="form-group"><label>Tour Date</label><input type="date" name="tour_date" id="edit_tour_date" class="form-control" required></div>
                <button type="submit" name="update_tour" class="btn btn-primary" style="width:100%">Update Tour</button>
            </form>
        </div>
    </div>

    <!-- EDIT BOOKING MODAL -->
    <div id="editBookingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editBookingModal')">&times;</span>
            <h2><i class="fas fa-edit"></i> Edit Booking</h2>
            <form method="POST" id="editBookingForm">
                <input type="hidden" name="booking_id" id="edit_booking_id">
                <input type="hidden" name="tour_id" id="edit_booking_tour_id">
                <input type="hidden" name="old_people" id="edit_old_people">
                <div class="form-group"><label>Customer Name</label><input type="text" name="customer_name" id="edit_customer_name" class="form-control" required></div>
                <div class="form-group"><label>Phone</label><input type="text" name="phone" id="edit_phone" class="form-control" required></div>
                <div class="form-group"><label>Number of People</label><input type="number" name="number_of_people" id="edit_people" class="form-control" min="1" required></div>
                <div class="form-group">
                    <label>Tour Info</label>
                    <div style="background:var(--light); padding:10px; border-radius:5px;">
                        <span id="edit_tour_info"></span>
                    </div>
                </div>
                <button type="submit" name="update_booking" class="btn btn-primary" style="width:100%">Update Booking</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Dallo Tourism – Admin Panel</p>
    </footer>

    <script>
        // Tour modal
        function openEditTourModal(id) {
            fetch('get_tour.php?id=' + id)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_tour_id').value = data.id;
                document.getElementById('edit_tour_name').value = data.TourName;
                document.getElementById('edit_destination').value = data.Destination;
                document.getElementById('edit_description').value = data.Description || '';
                document.getElementById('edit_duration').value = data.Duration;
                document.getElementById('edit_price').value = data.Price;
                document.getElementById('edit_spots').value = data.AvailableSpots;
                document.getElementById('edit_tour_date').value = data.TourDate;
                document.getElementById('editTourModal').style.display = 'block';
            });
        }
        // Booking modal
        function openEditBookingModal(id) {
            fetch('get_booking.php?id=' + id)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_booking_id').value = data.id;
                document.getElementById('edit_booking_tour_id').value = data.TourID;
                document.getElementById('edit_old_people').value = data.NumberOfPeople;
                document.getElementById('edit_customer_name').value = data.CustomerName;
                document.getElementById('edit_phone').value = data.Phone;
                document.getElementById('edit_people').value = data.NumberOfPeople;
                document.getElementById('edit_tour_info').innerHTML = 
                    '<strong>' + data.TourName + '</strong> (' + data.Destination + ')<br>' +
                    'Price per person: $' + data.UnitPrice + ' | Duration: ' + data.Duration;
                document.getElementById('editBookingModal').style.display = 'block';
            });
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>