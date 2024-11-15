<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Login</h1>
        <form method="POST" action="../login.php">
            <label for="registration_id">Registration ID:</label>
            <input type="text" id="registration_id" name="registration_id" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="*****" required><br><br>
            
            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="">-- Select Role --</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select><br><br>

            <div id="allButton">
                <button type="submit">Login</button>
                <div>
                    <a href="../index.php">Create account?</a>
                </div>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
