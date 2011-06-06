<?
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$filename = $POST['filename'];
if ($filename == null)
{
    $js = array('success' => false);
    echo json_encode($js);
    return;
}

unlink('pics/' + $GET['filename']);

$js = array('success' => true);
echo json_encode($js);
return;
?>