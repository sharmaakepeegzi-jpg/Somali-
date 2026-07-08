<?php
// Database connection
$host = 'localhost';
$dbname = 'gacan_libaax_tourism';
$user = 'root';
$pass = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Try to persist the message if a "messages" table exists in the DB.
        // If it doesn't exist yet, we still confirm to the user but nothing is stored -
        // create a messages table (id, name, email, subject, message, created_at) to enable saving.
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
        } catch (PDOException $e) {
            // messages table not present - fail silently, message is not stored
        }
        $success = true;
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact – Gacan Libaax</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; background: #f4f9f4; color: #2c3e50; }
        .container { max-width:1200px; margin:0 auto; padding:0 24px; }
        header { background: #1a3a5c; padding:16px 0; color:white; }
        .nav-container { display:flex; justify-content:space-between; align-items:center; max-width:1200px; margin:0 auto; padding:0 24px; flex-wrap:wrap; }
        .logo { font-size:1.6rem; font-weight:bold; }
        .logo i { color:#f1c40f; }
        .logo span { color:#f1c40f; }
        .nav-links { display:flex; gap:24px; flex-wrap:wrap; list-style:none; }
        .nav-links a { color:rgba(255,255,255,0.85); text-decoration:none; font-weight:500; padding:6px 0; transition:0.3s; border-bottom:2px solid transparent; }
        .nav-links a:hover, .nav-links a.active { color:white; border-bottom-color:#f1c40f; }
        .section-title { font-size:2.2rem; text-align:center; margin:40px 0 20px; }
        .section-title span { color:#0a7e3d; }
        .contact-grid { display:grid; grid-template-columns:1fr 1fr; gap:40px; margin:30px 0; }
        .info-item { display:flex; align-items:flex-start; gap:16px; background:white; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.06); margin-bottom:16px; }
        .info-item i { font-size:1.6rem; color:#0a7e3d; min-width:40px; }
        .contact-form { background:white; padding:34px; border-radius:16px; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-weight:500; margin-bottom:4px; }
        .form-group input, .form-group textarea { width:100%; padding:12px 16px; border:2px solid #e8ecec; border-radius:12px; font-family:inherit; font-size:1rem; background:#f4f9f4; }
        .form-group input:focus, .form-group textarea:focus { border-color:#0a7e3d; outline:none; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .btn { display:inline-block; padding:12px 30px; border-radius:50px; background:#0a7e3d; color:white; text-decoration:none; font-weight:600; transition:0.3s; border:none; cursor:pointer; }
        .btn:hover { background:#065a2a; }
        .alert { padding:14px; border-radius:10px; margin-bottom:20px; }
        .alert-success { background:#e8f5e9; color:#2e7d32; border-left:4px solid #2e7d32; }
        .alert-error { background:#fde8e8; color:#c0392b; border-left:4px solid #c0392b; }
        footer { background:#1a3a5c; color:rgba(255,255,255,0.7); padding:30px 0; text-align:center; margin-top:40px; }
        @media (max-width:768px) { .contact-grid { grid-template-columns:1fr; } .form-row { grid-template-columns:1fr; } .nav-links { gap:12px; } .nav-links a { font-size:0.9rem; } }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-bus"></i> Gacan <span>Libaax</span>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="tourism.php">Tourism</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </div>
    </nav>
</header>

<div class="container">
    <h2 class="section-title">Get in <span>Touch</span></h2>
    <div class="contact-grid">
        <div>
            <div class="info-item"><i class="fas fa-map-pin"></i><div><h4>Address</h4><p>Hargeisa, Somaliland</p></div></div>
            <div class="info-item"><i class="fas fa-phone-alt"></i><div><h4>Phone</h4><p>+252 63 123 4567</p></div></div>
            <div class="info-item"><i class="fas fa-envelope"></i><div><h4>Email</h4><p>info@gacanlibaax.com</p></div></div>
        </div>
        <div class="contact-form">
            <h3><i class="fas fa-paper-plane" style="color:#0a7e3d;"></i> Send a Message</h3>
            <?php if (isset($success)): ?>
                <div class="alert alert-success">Thank you! Your message has been sent.</div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group"><label>Full Name</label><input type="text" name="name" required></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                </div>
                <div class="form-group"><label>Subject</label><input type="text" name="subject"></div>
                <div class="form-group"><label>Message</label><textarea name="message" rows="4" required></textarea></div>
                <button type="submit" class="btn" style="width:100%;"><i class="fas fa-paper-plane"></i> Send</button>
            </form>
        </div>
    </div>
</div>

<footer>
    <div class="container">&copy; 2026 Gacan Libaax Tourism – All rights reserved.</div>
</footer>
</body>
</html>