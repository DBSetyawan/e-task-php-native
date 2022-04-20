<?php
  $file = 'manual-e-logbook.pdf';
  $filename = 'tmp_manual-e-logbook.pdf';
  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $filename . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file);
?>