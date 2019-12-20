<?php
$favicon = "images/openrlg/favicon.png";
header("Content-type: image/png");
echo base64_decode($favicon);
exit();
?>