<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../db_connection.php';

// Fetch current user info
$stmt = $pdo->prepare("SELECT username, email, profile_image FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $new_password = $_POST['password'];
    $profile_pic = $user['profile_image'];

    // Handle profile picture upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = uniqid() . "_" . basename($_FILES["profile_image"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_pic = $target_file;
        }
    }

    // Update username, email, and profile picture
    $update_sql = "UPDATE users SET username = ?, email = ?, profile_image = ? WHERE user_id = ?";
    $pdo->prepare($update_sql)->execute([
        $new_username,
        $new_email,
        $profile_pic,
        $_SESSION['user_id']
    ]);
    
    $_SESSION['username'] = $new_username;
    $message = "Username, email and profile picture updated!";

    // Update password if provided
    if (!empty($new_password)) {
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password_hash = ? WHERE user_id = ?";
        $pdo->prepare($update_sql)->execute([$password_hash, $_SESSION['user_id']]);
        $message .= " Password updated!";
    }

    // Refresh user info
    $stmt = $pdo->prepare("SELECT username, email, profile_image FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - ChefAI</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        :root {
            --primary-green: #4CAF50;
            --secondary-green: #2E8B57;
            --accent-green: #6EE7B7;
            --light: #ffffff;
            --dark: #1a1a1a;
            --glass-bg: rgba(255, 255, 255, 0.15);
            --border: rgba(255, 255, 255, 0.25);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4CAF50, #2E8B57, #3ECF8E);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            color: var(--dark);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--light);
            margin-bottom: 1.5rem;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid var(--accent-green);
            box-shadow: 0 0 25px rgba(110, 231, 183, 0.6);
            margin-bottom: 2rem;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .profile-pic:hover {
            transform: scale(1.08);
            box-shadow: 0 0 40px rgba(110, 231, 183, 0.9);
        }

        .message {
            color: var(--accent-green);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: var(--light);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: var(--light);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        input:focus {
            outline: none;
            border-color: var(--accent-green);
            box-shadow: 0 0 12px rgba(110, 231, 183, 0.6);
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            background: linear-gradient(135deg, #4CAF50, #2E8B57);
            color: var(--light);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 6px 18px rgba(0,0,0,0.2);
            width: 100%;
            margin-top: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .btn-link {
            background: transparent;
            border: 2px solid var(--light);
            color: var(--light);
        }

        .btn-link:hover {
            background: rgba(255,255,255,0.2);
        }

        .link-group {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if (!empty($user['profile_image'])): ?>
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Picture" class="profile-pic">
        <?php else: ?>
            <img src="../default-avatar.png" alt="Profile Picture" class="profile-pic">
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current">
            
            <label for="profile_image">Profile Picture</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">
            
            <button type="submit" class="btn">💾 Save Changes</button>
        </form>
        <div class="link-group">
            <a href="profile.php" class="btn btn-link">⬅ Back to Profile</a>
        </div>
    </div>
</body>
</html>



