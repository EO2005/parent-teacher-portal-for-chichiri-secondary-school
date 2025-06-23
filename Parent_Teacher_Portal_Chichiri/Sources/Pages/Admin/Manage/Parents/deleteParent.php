<?php
    include '../../../../../Classes/Admin.php';
    $delete = new Admin;

    if (isset($_GET["parent_id"])) {
        $parent_id = $_GET["parent_id"];
        $location = 'viewParents.php';

        $delete->deleteParent($parent_id, $location);
    }
?>