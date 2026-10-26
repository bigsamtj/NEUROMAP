<?php
$pageTitle = "NEUROMAP - Administrator Login";
ob_start();
?>
<div style="max-width: 400px; margin: 60px auto; text-align: center;">
    <h2>🔐 NEUROMAP ACCESS</h2>
    <p style="color: var(--text-muted); font-size: 13px;">Restricted Intelligence Reconnaissance Station</p>
    
    <form method="POST" action="/login/authenticate" style="text-align: left; margin-top: 20px;">
        <label>Username:</label>
        <input type="text" name="username" required autocomplete="off">

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">Masuk Sistem</button>
    </form>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
