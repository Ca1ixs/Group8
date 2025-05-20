<?php
require_once 'db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirm_password']));
    $agreedTerms = isset($_POST['agree_terms']);

    function isValidPassword($password) {
        return strlen($password) >= 8 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[\W_]/', $password);
    }

    function isCommonEmailTypo($email) {
        $commonTypos = ['gmial.com', 'gamil.com', 'gmal.com', 'gnail.com', 'gmil.com'];
        foreach ($commonTypos as $typo) {
            if (substr(strtolower($email), -strlen($typo)) === $typo) {
                return true;
            }
        }
        return false;
    }

    if (!$agreedTerms) {
        $error = "You must agree to the Terms and Conditions.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (isCommonEmailTypo($email)) {
        $error = "It looks like your email domain may be misspelled (e.g., 'gmil.com'). Please correct it.";
    } elseif (!isValidPassword($password)) {
        $error = "Password must be at least 8 characters long, contain at least one uppercase letter, and one special character.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('LogAccount/Assets/SignUp.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            z-index: 0;
        }

        .split-screen {
            display: flex;
            width: 90%;
            max-width: 950px;
            height: 85vh;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .left-side {
            flex: 1;
            background-color: skyblue;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        .left-side h1 {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .brand-logo .brand {
            font-size: 2.3rem;
            color: #fcd835;
            font-family: 'Georgia', serif;
        }

        .brand-logo img {
            max-height: 40px;
            height: auto;
            width: auto;
            object-fit: contain;
        }

        .right-side {
            flex: 1;
            background: url('LogAccount/Assets/right-bg.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
            padding: 60px 50px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .right-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 0;
        }

        .right-side > * {
            position: relative;
            z-index: 1;
            color: black;
        }

        .right-side h2 {
            font-size: 2rem;
            color: #c69400;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #f0b400;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            margin-bottom: 20px;
        }

        form button:hover {
            background-color: #d19900;
        }

        .right-side label {
            font-size: 0.9rem;
            margin-bottom: 16px;
            color: #555;
            display: flex;
            align-items: center;
        }

        .right-side label input[type="checkbox"] {
            margin-right: 8px;
        }

        .right-side label a {
            color: #007bff;
            text-decoration: none;
        }

        .right-side label a:hover {
            text-decoration: underline;
        }

        p.error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        small a {
            color: white !important;
            text-decoration: none;
        }

        small a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .split-screen {
                flex-direction: column;
                height: auto;
                width: 95%;
                margin: 20px;
            }

            .left-side,
            .right-side {
                width: 100%;
                padding: 30px;
                text-align: center;
            }

            .left-side h1 {
                font-size: 2rem;
            }

            .brand-logo .brand {
                font-size: 1.8rem;
            }

            .right-side h2 {
                font-size: 1.5rem;
            }

            form input[type="text"],
            form input[type="email"],
            form input[type="password"],
            form button {
                font-size: 0.95rem;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .left-side h1 {
                font-size: 1.5rem;
            }

            .brand-logo .brand {
                font-size: 1.5rem;
            }

            .right-side h2 {
                font-size: 1.3rem;
            }

            form button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<div class="split-screen">
    <div class="left-side">
        <h1>Find<br>your way with</h1>
        <div class="brand-logo">
            <div class="brand">Compass</div>
            <img src="LogAccount/Assets/LogoTransparent.png" alt="Compass Logo">
        </div>
    </div>
    <div class="right-side">
        <h2>Create Account</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Enter your username" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

            <label style="margin-bottom: 10px;">
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </label>

            <label>
                <input type="checkbox" name="agree_terms" required>
                I agree to the&nbsp;<a href="terms.php">Terms and Conditions</a>&nbsp;and&nbsp;<a href="privacy.php">Privacy Policy</a>.
            </label>

            <button type="submit">Sign Up</button>
        </form>
        <small>Already have an account? <a href="login.php">Sign-in.</a></small>
    </div>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const isText = password.type === 'text';
        password.type = isText ? 'password' : 'text';
        confirmPassword.type = isText ? 'password' : 'text';
    }
</script>
</body>
</html>
