<?
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$picDir = opendir("pics");
while ($entryName = readdir($picDir)) {
  if ($entryName[0] === '.') continue;
  $pic[] = $entryName;
}
closedir($picDir);

$js = array('baseUrl' => 'http://bittwiddlers.org/ryan/pics/', 'files' => $pic);
echo json_encode($js);
?>
