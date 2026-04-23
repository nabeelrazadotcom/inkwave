<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inkwave - Welcome Back</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

    <div class="background"></div>

    <main class="container">

        <!-- Welcome Zone -->
        <section class="welcome">
            <h1>Your words are waiting.</h1>
            <p class="brand">Inkwave</p>
        </section>

        <!-- Login Flow -->
        <form class="login-flow" method="post" action="./login.php">
            <div class="input-group">
                <input name="username" type="text" required>
                <label>Username</label>
            </div>

            <div class="input-group">
                <input name="password" type="password" required>
                <label>Password</label>
            </div>

            <button class="primary-btn">Continue Writing</button>

            <p class="secondary">
                New to Inkwave? <a href="./register_form.php">Begin here</a>
            </p>
        </form>

    </main>

</body>
<script src="../assets/js/script.js"></script>

</html>