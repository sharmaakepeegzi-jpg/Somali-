<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dallo Tourism – Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00ff4c;
            --secondary: #1a237e;
            --accent: #283593;
            --light: #e9ebff;
            --dark: #121858;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', sans-serif; }
        body { background:#f5f5f5; color:#333; }
        .banner {
            background: linear-gradient(135deg, var(--secondary), var(--accent));
            color: white; text-align: center; padding: 30px 0;
        }
        .banner h1 { font-size: 2.8rem; }
        .gold-text { color: var(--primary); font-weight: bold; }
        nav { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top:0; z-index:100; }
        .nav-container {
            display: flex; justify-content: space-between; align-items: center;
            max-width:1200px; margin:0 auto; padding:15px 20px;
        }
        .logo { font-size:1.7rem; color:var(--secondary); }
        .logo i { color:var(--primary); margin-right:10px; }
        .nav-links { list-style: none; display: flex; }
        .nav-links li { margin-left:25px; }
        .nav-links a { text-decoration:none; color:var(--secondary); font-weight:500; }
        .nav-links a.active, .nav-links a:hover { color:var(--primary); }
        .container { max-width:1200px; margin:30px auto; padding:0 20px; }
        .card { background:white; border-radius:10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); padding:25px; margin-bottom:30px; }
        .section-title { text-align:center; color:var(--secondary); margin:40px 0 20px; font-size:2rem; }
        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap:25px;
            margin:30px 0;
        }
        .dest-card {
            background:white;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            border-top:4px solid var(--primary);
        }
        .dest-card:hover { transform: translateY(-5px); }
        .dest-img { height:350px; background-size:cover; background-position:center; }
        .dest-info { padding:20px; }
        .dest-info h3 { color:var(--secondary); margin-bottom:10px; }
        .cta-button {
            display:inline-block; background:var(--primary); color:var(--dark);
            padding:12px 30px; border-radius:30px; text-decoration:none;
            font-weight:bold; margin-top:20px; font-size:1.1rem;
        }
        .cta-button:hover { background:#ffc400; }
        footer { background:var(--secondary); color:white; text-align:center; padding:30px 0; margin-top:50px; }
        @media(max-width:768px) { .nav-container { flex-direction:column; } }
    </style>
</head>
<body>
    <div class="banner">
        <h1><span class="gold-text">Dallo</span> Tourism</h1>
        <p>Trust your travel adventure – all over Somaliland</p>
    </div>
    <nav>
        <div class="nav-container">
            <div class="logo"><i class="fas fa-umbrella-beach"></i> Dallo Tourism</div>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="tourism.php">Tours</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2 class="section-title">Tourist Destinations in Somaliland</h2>
        <p style="text-align:center; max-width:700px; margin:0 auto 20px;">
            Somaliland has many beautiful tourist sites – beaches, mountains, and rich history.
            Dallo Tourism has prepared exciting tours to visit all these places.
        </p>

        <div class="destinations-grid">
            <div class="dest-card">
                <div class="dest-img" style="background-image: url('Laas_Geel.jpg');"></div>
                <div class="dest-info">
                    <h3>Laas Geel</h3>
                    <p>Rock paintings dating back 5,000 years.</p>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img" style="background-image: url('peegzi.JPEG');"></div>
                <div class="dest-info">
                    <h3>Berbera Beach</h3>
                    <p>A perfect spot for tourism and relaxation.</p>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img" style="background-image: url('borama.JPEG');"></div>
                <div class="dest-info">
                    <h3>Borama</h3>
                    <p>The famous "Safari" hotel in Borama.</p>
                </div>
            </div>
            <div class="dest-card">
                <div class="dest-img" style="background-image: url('gacan.JPEG');"></div>
                <div class="dest-info">
                    <h3>Ga'an Libaah</h3>
                    <p>A high natural area with amazing views.</p>
                </div>
            </div>
        </div>

        <div style="text-align:center;">
            <a href="tourism.php" class="cta-button">
                <i class="fas fa-ticket-alt"></i> View available tours
            </a>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Dallo Tourism. All rights reserved.</p>
        <p>Trust your travel adventure – Somaliland</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>