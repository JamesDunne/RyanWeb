<?
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$filename = $_POST['filename'];
if (!isset($filename))
{
    $js = array('success' => false);
    echo json_encode($js);
    return;
}

error_log('/var/www/ryan/pics/' . $filename);
unlink('/var/www/ryan/pics/' . $filename);

$js = array('success' => true);
echo json_encode($js);
return;
?>