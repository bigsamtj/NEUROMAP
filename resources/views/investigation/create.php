<?php
$title = 'New Investigation';
?>

<h1>New Investigation</h1>
<p class="subtitle">Create a new case and add known subject details</p>

<?php if (!empty($error)): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="/investigation/store" class="card">

    <h2>Case Information</h2>

    <div class="field">
        <label>Investigation Title *</label>
        <input type="text" name="title" required 
               value="<?= htmlspecialchars($old['title'] ?? '') ?>"
               placeholder="e.g. Subject Investigation - John Doe">
    </div>

    <div class="field">
        <label>Internal Notes</label>
        <textarea name="notes" placeholder="Any notes about this investigation..."><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>
    </div>

    <h2 style="margin-top: 28px;">Subject / Target Details</h2>

    <div class="field">
        <label>Full Name</label>
        <input type="text" name="full_name" 
               value="<?= htmlspecialchars($old['full_name'] ?? '') ?>"
               placeholder="e.g. John Michael Doe">
    </div>

    <div class="field">
        <label>Aliases / Nicknames</label>
        <input type="text" name="aliases" 
               value="<?= htmlspecialchars($old['aliases'] ?? '') ?>"
               placeholder="Comma separated (e.g. Johnny, J.Doe)">
    </div>

    <div class="grid-2">
        <div class="field">
            <label>Email Addresses</label>
            <input type="text" name="emails" 
                   value="<?= htmlspecialchars($old['emails'] ?? '') ?>"
                   placeholder="email1@example.com, email2@...">
        </div>

        <div class="field">
            <label>Phone Numbers</label>
            <input type="text" name="phones" 
                   value="<?= htmlspecialchars($old['phones'] ?? '') ?>"
                   placeholder="+234..., 080...">
        </div>
    </div>

    <div class="field">
        <label>Usernames / Handles</label>
        <input type="text" name="usernames" 
               value="<?= htmlspecialchars($old['usernames'] ?? '') ?>"
               placeholder="Comma separated usernames">
    </div>

    <div class="grid-2">
        <div class="field">
            <label>Locations</label>
            <input type="text" name="locations" 
                   value="<?= htmlspecialchars($old['locations'] ?? '') ?>"
                   placeholder="City, State, Country">
        </div>

        <div class="field">
            <label>Organizations / Companies</label>
            <input type="text" name="organizations" 
                   value="<?= htmlspecialchars($old['organizations'] ?? '') ?>"
                   placeholder="Company names">
        </div>
    </div>

    <div class="field">
        <label>Websites / Domains</label>
        <input type="text" name="websites" 
               value="<?= htmlspecialchars($old['websites'] ?? '') ?>"
               placeholder="example.com, linkedin.com/in/...">
    </div>

    <button type="submit" class="btn btn-primary">Create Investigation</button>
    <a href="/dashboard" class="btn btn-secondary" style="margin-left: 10px;">Cancel</a>
</form>
