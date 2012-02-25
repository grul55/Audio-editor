<?php
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=output.ogg');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$samples = json_decode($_POST['samples']);
$args = array();
foreach($samples as $index => $sample) {
    $sample->volume /= count($samples);
    $arg = "-v {$sample->volume} {$sample->src} -p pad {$sample->offset}";
    if($index > 0) { $arg = "-m - $arg"; }
    $args[] = "sox $arg";
}
$args[] = "sox - -t ogg -";

chdir('samples');
$cmd = implode('|', $args);
passthru($cmd);