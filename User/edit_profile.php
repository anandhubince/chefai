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
            --card-bg: #f0fff4;
            --light-green: #e6f7ee;
            --dark: #222;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-green);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

       /* Add this margin to push the container below the navbar */
.container {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
    max-width: 450px;
    width: 100%;
    margin-top: 7rem; /* <-- Add this line */
}
// ...existing code...
        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-green);
            margin-bottom: 1.5rem;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-green);
            margin-bottom: 1.5rem;
            box-shadow: 0 0 12px rgba(76, 175, 80, 0.3);
        }

        .message {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: var(--secondary-green);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 1.2rem;
            border-radius: 12px;
            border: 2px solid #d9d9d9;
            font-size: 1rem;
            transition: 0.3s ease;
        }

        input:focus {
            border-color: var(--primary-green);
            outline: none;
            box-shadow: 0 0 6px rgba(76, 175, 80, 0.2);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: 0.3s ease;
            background: var(--primary-green);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn:hover {
            background: var(--secondary-green);
            transform: translateY(-2px);
        }

        .btn-link {
            background: #fff;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
        }

        .btn-link:hover {
            background: var(--primary-green);
            color: #fff;
        }

        .link-group {
            margin-top: 1.2rem;
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



