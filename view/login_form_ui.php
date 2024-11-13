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
        <form method="POST">
            <label for="registration_id">Registration ID:</label>
            <input  type="text" id="registration_id" name="registration_id"  required><br><br>
            
            <label for="password">Password:</label>
            <input  type="password" id="password" name="password" placeholder="*****" required><br><br>

        
            <div id="allButton">
            <button type="submit">Login</button>
                <div>
                    <a>Create account?</a>
                    <a href="../index.php"><button type="button">Register</button></a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
