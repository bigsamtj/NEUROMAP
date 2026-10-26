<?php
$pageTitle = "NEUROMAP - New Nigerian Target Investigation";
ob_start();
?>
<h2>🇳🇬 NEUROMAP - Target Reconnaissance (Nigeria Context)</h2>
<p style="color: var(--text-muted);">Configure target identifiers including Nigerian specific parameters (NIN, Phone, Handles).</p>
<p><a href="/dashboard">&larr; Kembali ke Dashboard</a></p>

<form method="POST" action="/investigation/store">
    <label>Case Reference / Title:</label>
    <input type="text" name="title" placeholder="e.g. Operation Target Alpha - Lagos" required>

    <div style="display: flex; gap: 15px;">
        <div style="flex: 1;">
            <label>Surname (Nama Keluarga):</label>
            <input type="text" name="surname" placeholder="e.g. Adebayo / Okafor">
        </div>
        <div style="flex: 1;">
            <label>First / Other Names:</label>
            <input type="text" name="first_name" placeholder="e.g. Chidi / Oluwaseun">
        </div>
    </div>

    <div style="display: flex; gap: 15px;">
        <div style="flex: 1;">
            <label>Phone Number (e.g. +234...):</label>
            <input type="text" name="phone" placeholder="+2348012345678">
        </div>
        <div style="flex: 1;">
            <label>NIN / BVN (National ID / Bank ID if known):</label>
            <input type="text" name="nin" placeholder="National Identification Number">
        </div>
    </div>

    <div style="display: flex; gap: 15px;">
        <div style="flex: 1;">
            <label>Instagram Handle:</label>
            <input type="text" name="instagram" placeholder="@username">
        </div>
        <div style="flex: 1;">
            <label>Twitter / X Handle:</label>
            <input type="text" name="twitter" placeholder="@username">
        </div>
    </div>

    <div style="display: flex; gap: 15px;">
        <div style="flex: 1;">
            <label>Facebook Name / Profile:</label>
            <input type="text" name="facebook" placeholder="Full name on FB">
        </div>
        <div style="flex: 1;">
            <label>LinkedIn / Professional:</label>
            <input type="text" name="linkedin" placeholder="Profile name or slug">
        </div>
    </div>

    <label>Email Address:</label>
    <input type="email" name="email" placeholder="target@domain.com">

    <label>Known Organization / Business / School:</label>
    <input type="text" name="organization" placeholder="e.g. Unilag / GTBank / Business name">

    <label>Known Domain / Website:</label>
    <input type="text" name="known_domains" placeholder="targetdomain.ng">

    <button type="submit" class="btn" style="margin-top: 20px;">🚀 Execute Automated OSINT Dorking Matrix</button>
</form>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
