<?php
namespace src\public;
use src\app\controller\User_Controller;

$test= new User_Controller();
$formData=$test->createUser();
?>
<pre><?php var_dump($formData['companies']); ?></pre>
<form method="POST" action="">
    <input type="text" name="firstname" placeholder="Vorname" value="<?= htmlspecialchars($formData['firstname']) ?>" required>
    <input type="text" name="lastname" placeholder="Nachname" value="<?= htmlspecialchars($formData['lastname']) ?>" required>
    <input type="email" name="email" placeholder="E-Mail" value="<?= htmlspecialchars($formData['email']) ?>" required>
    <input type="password" name="password_hash" placeholder="Passwort" required>

    <select name="role" required>
    <option value="">-- Rolle wählen --</option>
    <?php foreach ($formData['roles'] as $r): ?>
        <option value="<?= htmlspecialchars($r['id']) ?>" <?= $formData['role'] == $r['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($r['name']) ?>
        </option>
    <?php endforeach; ?>
    </select>

    <select name="company" required>
        <option value="0">-- Firma wählen --</option>
        <?php foreach ($formData['companies'] as $comp): ?>
            <option value="<?= htmlspecialchars($comp['id']) ?>" <?= $formData['company'] == $comp['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($comp['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Benutzer erstellen</button>
</form>