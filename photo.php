<?php

include "includes/functions.php";

echo load_photos($mysqli, $_POST["user"], $_POST["record"]);

?>