<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Fetch user info from database (only username, email, profile_pic)
require_once '../db_connection.php';
$stmt = $pdo->prepare("SELECT username, email, profile_image FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Profile - ChefAI</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    /* --- Background same as homepage but more vivid --- */
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #dfffe9, #f9fff3);
      margin: 0;
      padding-top: 6rem;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #222;
      position: relative;
      overflow: hidden;
    }

    /* Animated gradient blobs */
    body::before,
    body::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      filter: blur(150px);
      opacity: 0.3;
      z-index: -1;
      animation: pulse 12s infinite alternate ease-in-out;
    }
    body::before {
      width: 450px; height: 450px;
      top: -120px; left: -120px;
      background: radial-gradient(circle at center, #4CAF50, transparent 70%);
    }
    body::after {
      width: 550px; height: 550px;
      bottom: -150px; right: -150px;
      background: radial-gradient(circle at center, #2E8B57, transparent 70%);
    }
    @keyframes pulse {
      from { transform: scale(1); opacity: 0.3; }
      to   { transform: scale(1.2); opacity: 0.5; }
    }

    /* Floating food icons */
    .floating-icons span {
      position: absolute;
      font-size: 2.2rem;
      opacity: 0.12;
      animation: float 18s infinite ease-in-out;
    }
    .floating-icons span:nth-child(1) { top: 20%; left: 15%; animation-duration: 20s; }
    .floating-icons span:nth-child(2) { top: 55%; left: 75%; animation-duration: 24s; }
    .floating-icons span:nth-child(3) { top: 80%; left: 25%; animation-duration: 22s; }
    .floating-icons span:nth-child(4) { top: 40%; left: 60%; animation-duration: 26s; }
    .floating-icons span:nth-child(5) { top: 10%; left: 85%; animation-duration: 28s; }
    @keyframes float {
      0% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-25px) rotate(20deg); }
      100% { transform: translateY(0) rotate(0deg); }
    }

    /* Profile card - premium glass effect */
    .profile-card {
      background: rgba(255, 255, 255, 0.65);
      backdrop-filter: blur(18px) saturate(150%);
      border-radius: 25px;
      padding: 3rem 2.5rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
      max-width: 460px;
      width: 90%;
      text-align: center;
      animation: fadeUp 1s ease-in-out;
      border: 2px solid rgba(255,255,255,0.6);
      position: relative;
      overflow: hidden;
    }
    .profile-card::before {
      content: "";
      position: absolute;
      top: -50%; left: -50%;
      width: 200%; height: 200%;
      background: conic-gradient(from 180deg, #4CAF50, #2E8B57, #4CAF50);
      animation: rotateBorder 6s linear infinite;
      z-index: -1;
      opacity: 0.15;
    }
    @keyframes rotateBorder {
      100% { transform: rotate(360deg); }
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .profile-pic {
      width: 130px; height: 130px;
      border-radius: 50%;
      border: 6px solid #4CAF50;
      object-fit: cover;
      margin-bottom: 1.5rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      transition: transform 0.4s ease;
    }
    .profile-pic:hover {
      transform: scale(1.1) rotate(3deg);
    }

    h1 {
      font-size: 2.2rem;
      color: #2E8B57;
      margin-bottom: 0.8rem;
      font-weight: 700;
    }

    p {
      font-size: 1.1rem;
      margin: 0.4rem 0;
      font-weight: 400;
    }
    strong { color: #2E8B57; }

    /* Buttons */
    .btn {
      display: inline-block;
      padding: 0.8rem 1.6rem;
      margin: 1.2rem 0.6rem 0 0.6rem;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 600;
      letter-spacing: 0.5px;
      color: #fff;
      background: linear-gradient(135deg, #4CAF50, #2E8B57);
      box-shadow: 0 5px 20px rgba(46,139,87,0.3);
      transition: all 0.35s ease;
    }
    .btn:hover {
      transform: translateY(-4px) scale(1.05);
      box-shadow: 0 8px 28px rgba(46,139,87,0.45);
      background: linear-gradient(135deg, #2E8B57, #4CAF50);
    }

    /* Small glow on hover */
    .btn:active {
      transform: scale(0.97);
    }
  </style>
</head>
<body>
  <?php include 'navigation.php'; ?>

  <!-- Floating Icons -->
  <div class="floating-icons">
    <span>🥗</span>
    <span>🍲</span>
    <span>🍴</span>
    <span>🍕</span>
    <span>🥘</span>
  </div>

  <!-- Profile Card -->
  <div class="profile-card">
    <h1>Your Profile</h1>

    <?php if (!empty($user['profile_image'])): ?>
      <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture" class="profile-pic">
    <?php else: ?>
      <img src="../default-avatar.png" alt="Profile Picture" class="profile-pic">
    <?php endif; ?>

    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

    <a href="edit_profile.php" class="btn">✏️ Edit Profile</a>
    <a href="../logout.php" class="btn">🚪 Logout</a>
  </div>
</body>
</html>



