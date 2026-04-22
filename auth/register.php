<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>Inkwave — Register</title>

<!-- Bootstrap (only grid/utilities, not form styling dependency) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link href="../assets/css/register.css" rel="stylesheet">
</head>

<body>

<!-- BACKGROUND -->
<div class="background-flow" id="bg"></div>

<!-- MAIN -->
<div class="main container">

    <div>

        <!-- BRAND -->
        <div class="brand">
            <h1>Inkwave</h1>
            <p>Begin your flow of writing.</p>
        </div>

        <!-- FORM -->
        <div class="form-wrap">

            <div class="field">
                <input type="text" placeholder=" " id="name">
                <label>Full Name</label>
            </div>

            <div class="field">
                <input type="text" placeholder=" " id="username">
                <label>Username</label>
            </div>

            <div class="field">
                <input type="email" placeholder=" " id="email">
                <label>Email</label>
            </div>

            <div class="field">
                <input type="password" placeholder=" " id="password">
                <label>Password</label>
            </div>

            <button class="cta">Enter Inkwave</button>

        </div>
    </div>

</div>

<!-- Custom JS -->
<script src="../assets/js/script.js"></script>

</body>
</html>