<?php
namespace src\public;

use src\app\controller\Course_Controller;

/**
*  Kurs
*/
    $test = new Course_Controller();
    $courses=$test->listAllCourses();
    $test->deleteCourse();
?>
        <?php foreach ($courses as $course): ?>
            <tr>
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
    <!--<form method="POST">
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
 *  Session
 */
?>