<?php
define("ROOT", str_replace("\\", "/", dirname(__FILE__)) . "/");

// return the application directory name.
define("ROOT_DIR_NAME", basename(ROOT));
$cekurl="".ROOT_DIR_NAME;
echo $cekurl;
?>