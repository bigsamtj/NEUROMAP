<?php
$pageTitle = "NEUROMAP - Buat Investigasi Baru";
ob_start();
?>
<h2>🧠 NEUROMAP - Input Parameter Target OSINT</h2>
<p><a href="/dashboard">&larr; Kembali ke Dashboard</a></p>

<form method="POST" action="/investigation/store">
    <label>Judul Kasus / Referensi:</label>
    <input type="text" name="title" placeholder="Contoh: Investigasi Target Alpha" required>

    <label>Nama Lengkap Target:</label>
    <input type="text" name="full_name" placeholder="John Doe">

    <label>Alamat Email:</label>
    <input type="email" name="email" placeholder="target@domain.com">

    <label>Pekerjaan / Spesialisasi:</label>
    <input type="text" name="occupation" placeholder="Software Engineer / Security Analyst">

    <label>Username / Handle Media Sosial:</label>
    <input type="text" name="username_handle" placeholder="johndoe_sec">

    <label>Domain Terkait:</label>
    <input type="text" name="known_domains" placeholder="example.com">

    <button type="submit" class="btn">🚀 Generasi Query & Dorks</button>
</form>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
