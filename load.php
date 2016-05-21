<?php

include "includes/functions.php";
$ids = array(1416466, 3113383);
foreach($ids as $id ){
    echo load_first_photos($mysqli, $id);
}
echo "#";
echo load_points($mysqli);
?>