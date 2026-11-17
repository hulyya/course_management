<?php
namespace src\public;

use src\app\controller\Course_Controller;
use src\app\controller\Course_Session_Controller;
?>




<?php
/**
 *  Kurseeee ------------------------------------------------->
 */
    $test = new Course_Controller();
    $courses=$test->listAllCourses();
    $test->deleteCourse();
?>
       <?php foreach ($courses as $course): ?>
            <!--tr>
                <th>ID: </th><td><?= htmlspecialchars($course['id']) ?></td>
                <th>Titel: </th><td><?= htmlspecialchars($course['title']) ?></td>
                <th>Beschreibung: </th><td><?= htmlspecialchars($course['description']) ?></td>
                <th>Status:</th><td><?= $course['state'] ? 'Aktiv' : 'Inaktiv' ?></td>
                <button type="submit">Kurs löschen</button>
            </tr><br>
        <?php endforeach; ?>
<?php

    //print_r($test->showCourse(1));
    //$test->createCourse();
?>
    <form method="POST">
        titel : <input type="text" name="title">
        description : <input type="text" name="description">
        <input type="submit">
    </form>
<?php
    //$test->deleteCourse();
?>
    <form method="POST" onsubmit="return condfirm('Kurs wirklich löshcne?)">
        <input type="hiddem" name="delete_id">
        <button type="submit">Kurs löschen</button>
    </form>
<?php
    //$test -> editCourse();
?>
    <!--<form method="POST"> 
        <input type="hidden" name="edit_id" value="1">
        titel : <input type="text" name="title">
        description : <input type="text" name="description">  
        <input type="submit" value="Speichern">  
    </form> -->



<?php    
/**
 *  Session ------------------------------------------------->
 */
    $testSession = new Course_Session_Controller();
    $sessionData = $testSession ->listAllSessions(1);
    $courseData = $test->showCourse(1); 
?>  
    Session zum Kurs auflisten
    <table border="1" cellpadding="8">
        <tr>
            <th>Titel:</th>
            <td><?= htmlspecialchars($courseData['title']) ?></td>
        </tr>
        <tr>
            <th>Beschreibung:</th>
            <td><?= htmlspecialchars($courseData['description']) ?></td>
        </tr>
        <tr>
            <th>Status:</th>
            <td><?= $courseData['state'] ? 'Aktiv' : 'Inaktiv' ?></td>
        </tr>
    </table>
    <?php foreach ($sessionData as $a):?>
    <table>
            <tr>
            <th>Startzeit:</th>
            <td><?= htmlspecialchars($a['start_time']) ?></td>
        </tr>
        <tr>
            <th>Endzeit:</th>
            <td><?= htmlspecialchars($a['end_time']) ?></td>
        </tr>
        <tr>
            <th>Trainer: </th>
            <td><?=  htmlspecialchars($a['trainer']['firstname'] . ' ' . $a['trainer']['lastname']) ?></td>) ?></td>
        </tr>
        <tr>
            <th>Raum: </th>
            <td><?=  htmlspecialchars($a['location']['room']) ?></td>
        </tr>
        <tr>
            <th>Straße: </th>
            <td><?=  htmlspecialchars($a['location']['street']) ?></td>
        </tr>
        <tr>
            <th>Stadt: </th>
            <td><?=  htmlspecialchars($a['location']['city']) ?></td>
        </tr>
        <tr>
            <th>Raumkapazität:</th>
            <td><?=  htmlspecialchars($a['location']['capacity']) ?></td>
        </tr>
    </table>
    <?php endforeach; 
    $createSession = $testSession->createSession()?>
    <h3>Session erstellen</h3>
    <form method="POST">
        <p>Beginn : <input type="datetime-local" name="start_time" required></p>
        <p>Ende : <input type="datetime-local" name="end_time" required></p>
        <p>
        Trainer: 
            <select name="trainer" required>
                <option value="">-- Bitte Trainer wählen --</option>
                <?php foreach ($createSession['trainers'] as $t): ?>
                    <option value="<?= (int) $t['id'] ?>">
                        <?= htmlspecialchars($t['firstname'] . ' ' . $t['lastname']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
        Ort: 
            <select name="location" required>
                <option value="">-- Bitte Ort wählen --</option>
                <?php foreach ($createSession['locations'] as $l): ?>
                    <option value="<?= (int) $l['id'] ?>">
                        <?= htmlspecialchars($l['name'] . ' ' . $l['street']. ' ' . $l['city']. ' ' . $l['room']. ' ' . $l['capacity']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p> 
    </form>