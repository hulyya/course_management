<?php
namespace src\public;
use src\app\controller\User_Controller;

$test = new User_Controller();

$formData  = $test->createUser();
$deletuser = $test->deleteUser();
$editUser  = $test->editUser();
$users     = $test->listAllUsers();

$selectedUser = [
    'id'        => $_POST['edit_id'] ?? '',
    'firstname' => '',
    'lastname'  => '',
    'email'     => '',
    'role'      => 1,
    'company'   => ['id' => 0]
];

if (isset($_POST['select_edit_id'])) {
    foreach ($users as $u) {
        if ((int)$u['id'] === (int)$_POST['select_edit_id']) {
            $selectedUser = $u;
            break;
        }
    }
}
?>

<h2>Benutzer erstellen</h2>
<form method="POST" action="">
    <input type="text" name="firstname" placeholder="Vorname" value="<?= htmlspecialchars($formData['firstname']) ?>" required>
    <input type="text" name="lastname" placeholder="Nachname" value="<?= htmlspecialchars($formData['lastname']) ?>" required>
    <input type="email" name="email" placeholder="E-Mail" value="<?= htmlspecialchars($formData['email']) ?>" required>
    <input type="password" name="password_hash" placeholder="Passwort" required>

    <select name="role" required>
        <option value="">-- Rolle wählen --</option>
        <?php foreach ($formData['roles'] as $r): ?>
            <option value="<?= htmlspecialchars((string)$r['id']) ?>" <?= $formData['role'] == $r['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars((string)$r['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="company" required>
        <option value="0">-- Firma wählen --</option>
        <?php foreach ($formData['companies'] as $comp): ?>
            <option value="<?= htmlspecialchars((string)$comp['id']) ?>" <?= $formData['company'] == $comp['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars((string)$comp['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="create_submit">Benutzer erstellen</button>
</form>

<hr>

<h2>Benutzerliste</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>E-Mail</th>
            <th>Rolle</th>
            <th>Firma</th>
            <th>Aktionen</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars((string)$user['id']) ?></td>
                <td><?= $user['state'] ? 'Aktiv' : 'Inaktiv' ?></td>
                <td><?= htmlspecialchars((string)$user['firstname']) ?></td>
                <td><?= htmlspecialchars((string)$user['lastname']) ?></td>
                <td><?= htmlspecialchars((string)$user['email']) ?></td>
                <td>
                    <?= match ((int)$user['role']) {
                        1 => 'Admin',
                        2 => 'Trainer',
                        default => 'Employee',
                    } ?>
                </td>
                <td><?= htmlspecialchars((string)($user['company']['name'] ?? '')) ?></td>
                <td>
                    <!-- Lädt den Benutzer unten ins Bearbeiten-Formular -->
                    <form method="POST" style="display:inline;">
                        <button type="submit" name="select_edit_id" value="<?= $user['id'] ?>">
                            Bearbeiten
                        </button>
                    </form>

                    <!-- Löscht den Benutzer -->
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Benutzer wirklich löschen?')">
                        <button type="submit" name="delete_id" value="<?= $user['id'] ?>">
                            Löschen
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr>

<h2>Benutzer bearbeiten <?= $selectedUser['id'] ? '(ID: ' . htmlspecialchars((string)$selectedUser['id']) . ')' : '' ?></h2>

<form method="POST">
    <label>User-ID:</label>
    <input type="number" name="edit_id" value="<?= htmlspecialchars((string)$selectedUser['id']) ?>" required>

    <label>Vorname:</label>
    <input type="text" name="firstname" value="<?= htmlspecialchars((string)$selectedUser['firstname']) ?>" required>

    <label>Nachname:</label>
    <input type="text" name="lastname" value="<?= htmlspecialchars((string)$selectedUser['lastname']) ?>" required>

    <label>E-Mail:</label>
    <input type="email" name="email" value="<?= htmlspecialchars((string)$selectedUser['email']) ?>" required>

    <label>Passwort:</label>
    <input type="password" name="password_hash" required>

    <label>Rolle:</label>
    <select name="role">
        <option value="1" <?= $selectedUser['role'] == 1 ? 'selected' : '' ?>>Admin</option>
        <option value="2" <?= $selectedUser['role'] == 2 ? 'selected' : '' ?>>Trainer</option>
        <option value="3" <?= $selectedUser['role'] == 3 ? 'selected' : '' ?>>Employee</option>
    </select>

    <label>Firma:</label>
    <select name="company">
        <option value="0">-- Firma wählen --</option>
        <?php foreach ($editUser['companies'] as $comp): ?>
            <option value="<?= htmlspecialchars((string)$comp['id']) ?>" <?= ($selectedUser['company']['id'] ?? 0) == $comp['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars((string)$comp['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="save_edit">Speichern</button>
</form>
