<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About – Dallo Tourism</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ====== GENERAL COLORS ====== */
        :root {
            --primary: #00ff40;      /* Golden yellow */
            --secondary: #1a237e;    /* Dark blue */
            --accent: #283593;       /* Mid blue */
            --light: #e9ebff;        /* Light blue */
            --text: #333;
            --bg: #f5f5f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.7;
        }

        /* ====== BANNER ====== */
        .banner {
            background: linear-gradient(135deg, var(--secondary), var(--accent));
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .banner h1 {
            font-size: 2.5rem;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .gold-text {
            color: var(--primary);
            font-weight: bold;
        }

        /* ====== NAVIGATION ====== */
        nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px 20px;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--secondary);
            display: flex;
            align-items: center;
        }
        .logo i {
            color: var(--primary);
            margin-right: 10px;
            font-size: 1.8rem;
        }
        .nav-links {
            list-style: none;
            display: flex;
        }
        .nav-links li {
            margin-left: 25px;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--secondary);
            font-weight: 500;
            padding: 5px 0;
            transition: color 0.3s;
            position: relative;
        }
        .nav-links a.active,
        .nav-links a:hover {
            color: var(--primary);
        }
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
        }

        /* ====== CONTAINER ====== */
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* ====== GENERAL CARD ====== */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            padding: 35px 30px;
            margin-bottom: 35px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
        }

        /* ====== SECTION TITLES ====== */
        .section-title {
            font-size: 2rem;
            color: var(--secondary);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 12px;
        }
        .section-title i {
            color: var(--primary);
            margin-right: 12px;
            font-size: 2.2rem;
        }

        /* ====== ABOUT TEXT ====== */
        .about-text p {
            margin-bottom: 18px;
            font-size: 1.1rem;
            color: #444;
        }

        /* ====== MISSION & VISION (TWO BOXES) ====== */
        .mission-vision {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin: 25px 0;
        }
        .mv-box {
            background: var(--light);
            padding: 25px;
            border-radius: 12px;
            border-left: 5px solid var(--primary);
            transition: background 0.3s;
        }
        .mv-box:hover {
            background: #f0f0ff;
        }
        .mv-box h3 {
            color: var(--secondary);
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        /* ====== WHY CHOOSE US (FEATURES GRID) ====== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }
        .feature-item {
            text-align: center;
            padding: 30px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            transition: all 0.3s;
        }
        .feature-item:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .feature-item i {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 18px;
            display: inline-block;
        }
        .feature-item h4 {
            color: var(--secondary);
            margin-bottom: 12px;
            font-size: 1.3rem;
        }

        /* ====== TEAM MEMBERS ====== */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin: 25px 0;
        }
        .team-member {
            text-align: center;
            background: var(--light);
            padding: 25px 15px;
            border-radius: 12px;
            transition: 0.3s;
        }
        .team-member:hover {
            background: #f0f0ff;
        }
        .team-member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            margin-bottom: 15px;
        }
        .team-member h4 {
            color: var(--secondary);
        }

        /* ====== CONTACT DETAILS ====== */
        .contact-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
        }
        .contact-item {
            flex: 1 1 280px;
            background: var(--light);
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: background 0.3s;
        }
        .contact-item:hover {
            background: #e0e0ff;
        }
        .contact-item i {
            font-size: 2rem;
            color: var(--secondary);
        }

        /* ====== FOOTER ====== */
        footer {
            background: var(--secondary);
            color: white;
            text-align: center;
            padding: 35px 0;
            margin-top: 60px;
        }
        footer p {
            margin: 5px 0;
        }

        /* ====== MOBILE ====== */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 10px;
            }
            .mission-vision {
                grid-template-columns: 1fr;
            }
            .banner h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- ====== BANNER ====== -->
    <div class="banner">
        <h1>About <span class="gold-text">Dallo Tourism</span></h1>
        <p>Trust your travel adventure – all over Somaliland</p>
    </div>

    <!-- ====== NAVIGATION ====== -->
    <nav>
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-umbrella-beach"></i> Dallo Tourism
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="tourism.php">Tourism</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- ====== MAIN CONTENT ====== -->
    <div class="container">

        <!-- General Overview -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-info-circle"></i> Who is Dallo Tourism?</h2>
            <div class="about-text">
                <p>
                    <strong>Dallo Tourism</strong> is a travel company specialising in nature and historical tours across Somaliland.
                    We believe that travel is a journey of learning, comfort, and lasting memories.
                    Since our founding, we have served thousands of satisfied customers who have placed their trust in us.
                </p>
                <p>
                    Our company boasts an experienced team, knowledgeable guides, and reliable vehicles.
                    Our goal is to become the leading travel operator in Somaliland, providing our clients with unforgettable experiences.
                </p>
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="mission-vision">
            <div class="mv-box">
                <h3><i class="fas fa-bullseye" style="color:var(--primary); margin-right:8px;"></i> Our Mission</h3>
                <p>
                    To showcase the beauty of Somaliland through safe, high‑quality tours that respect our clients’ needs.
                    We aspire to be the most trusted domestic travel company.
                </p>
            </div>
            <div class="mv-box">
                <h3><i class="fas fa-eye" style="color:var(--primary); margin-right:8px;"></i> Our Vision</h3>
                <p>
                    To make Dallo Tourism the first name that comes to mind when talking about Somaliland tourism.
                    We aim to transform Somaliland into an international destination while preserving its environment and culture.
                </p>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-star"></i> Why Choose Us</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Safety &amp; Quality</h4>
                    <p>Our vehicles are all modern and regularly maintained. Our guides are thoroughly trained.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <h4>Custom Tours</h4>
                    <p>We can arrange a trip tailored to your needs: family, friends, or business travel.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h4>Wide Trust</h4>
                    <p>Thousands of customers have enjoyed exciting trips with us. Read our satisfaction reviews.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-leaf"></i>
                    <h4>Environmental Protection</h4>
                    <p>We strive to protect the environment and promote sustainable tourism.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-clock"></i>
                    <h4>Your Time Matters</h4>
                    <p>We adhere to travel schedules and provide travel information in advance.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-tag"></i>
                    <h4>Affordable Prices</h4>
                    <p>Unmatched quality at reasonable prices. Every trip is designed for your enjoyment.</p>
                </div>
            </div>
        </div>

        <!-- Our Team -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-users"></i> Our Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="images/team1.jpg" alt="Ahmed" onerror="this.src='https://via.placeholder.com/100/FFD700/1a237e?text=A'">
                    <h4>Ahmed Cali</h4>
                    <p>General Manager</p>
                </div>
                <div class="team-member">
                    <img src="images/team2.jpg" alt="Fadumo" onerror="this.src='https://via.placeholder.com/100/FFD700/1a237e?text=F'">
                    <h4>Fadumo Xasan</h4>
                    <p>Senior Guide</p>
                </div>
                <div class="team-member">
                    <img src="images/team3.jpg" alt="Khadar" onerror="this.src='https://via.placeholder.com/100/FFD700/1a237e?text=K'">
                    <h4>Khadar Yuusuf</h4>
                    <p>Marketing Manager</p>
                </div>
            </div>
        </div>

        <!-- Contact -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-address-card"></i> Contact Us</h2>
            <div class="contact-details">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Main Office</strong><br>
                        1st Street, Hargeisa, Somaliland
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <strong>Phone</strong><br>
                        +252 63 123 4567
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong><br>
                        info@dallotourism.so
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Working Hours</strong><br>
                        Saturday – Thursday: 8:00 AM – 6:00 PM<br>
                        Friday: Emergencies only
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end container -->

    <!-- ====== FOOTER ====== -->
    <footer>
        <p>&copy; 2023 Dallo Tourism. All rights reserved.</p>
        <p>Trust your travel adventure – all over Somaliland</p>
    </footer>

</body>
</html>
<?php $conn->close(); ?>