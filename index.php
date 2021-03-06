<html>
<head>
    <link href="/ryan/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/ryan/uploadify/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="/ryan/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="/ryan/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    <style>
th { text-align: left; }
body { font: tahoma; }
    </style>
    <script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
    'uploader'  : '/ryan/uploadify/uploadify.swf',
    'script'    : '/ryan/uploadify/uploadify.php',
    'cancelImg' : '/ryan/uploadify/cancel.png',
    'folder'    : '/pics',
    'auto'      : true,
    'multi'     : true,
	'onAllComplete' : function(event,data) {
        window.location.reload();
    },
    'onSWFReady': function() {
        //$('#nay-flash').css('display', 'none');
        //$('#yay-flash').css('display', 'block');
    }
  });
});
    </script>
</head>
<body>
    <div>
        Click here to upload pictures/video:
        <div id="yay-flash">
            <span>Flash-friendly:</span><br/>
            <input id="file_upload" name="file_upload" type="file" />
        </div>
        <br/>
        <div id="nay-flash">
            <span>Mobile-friendly:</span><br/>
            <form action="/ryan/uploadify/uploadify.php?folder=%2Fpics&redirect=%2Fryan%2F" method="post" enctype="multipart/form-data">
                <input type="file" name="Filedata" />
                <input type="submit" value="Upload" />
            </form>
        </div>
        <br/>
    </div>
    <div>
<?
    function calc($size)
    {
        $kb=1024;
        $mb=1048576;
        $gb=1073741824;
        $tb=1099511627776;
        if(!$size)
            return '0 B';
        elseif($size<$kb)
            return $size.' B';
        elseif($size<$mb)
            return round($size/$kb, 2).' KB';
        elseif($size<$gb)
            return round($size/$mb, 2).' MB';
        elseif($size<$tb)
            return round($size/$gb, 2).' GB';
        else
            return round($size/$tb, 2).' TB';
    }

    function cmp_lastmod($a, $b)
    {
        if ($a["lastmod"] == $b["lastmod"])
        {
            return 0;
        }
        return $a["lastmod"] > $b["lastmod"] ? -1 : 1;
    }

    $root = "http://bittwiddlers.org/ryan";
    $dir = "pics/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while (false !== ($entry = $d->read()))
    {
        // skip hidden files
        if ($entry[0] == ".") continue;

        // skip subdirs:
        if (is_dir("$dir$entry")) continue;
        if (!is_readable("$dir$entry")) continue;

        $retval[] = array(
            "name" => substr("$dir$entry", strlen($dir)),
            "type" => mime_content_type("$dir$entry"),
            "size" => filesize("$dir$entry"),
            "lastmod" => filemtime("$dir$entry")
        );
    }
    $d->close();

    // Sort by lastmod descending:
    usort($retval, 'cmp_lastmod');
?>
        <h3>Uploaded files:</h3>
        <table border="0" cellspacing="2">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Last Modified</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
<?
    foreach ($retval as $file)
    {
?>
                <tr>
                    <td><? echo "<a href=\"{$root}/{$dir}/{$file["name"]}\" title=\"{$file["name"]}\"><img src=\"phpThumb.php?src=pics/{$file["name"]}&w=96\" /></a>"; ?></td>
                    <td style="text-align: right"><? echo calc($file["size"]); ?></td>
                    <td><? echo "{$file["type"]}"; ?></td>
                    <td><? echo date('r', $file["lastmod"]); ?></td>
                    <td><a class="delete_link" href="delete.php" data-filename="<? echo $file["name"]; ?>">Delete</a></td>
                </tr>
<?
    }
?>
            </tbody>
        </table>
    </div>
    <script>
    <!--
        $(function() {
            $('a.delete_link').click(function() {
                try
                {
                    var link = $(this);
                    var filename = link.attr('data-filename');
                    if (!confirm('Confirm deletion of \'' + filename + '\''))
                        return false;

                    $.ajax({
                        type: 'POST',
                        url: link.attr('href'),
                        data: { filename: filename },
                        success: function(data) {
                            window.location.reload();
                        }
                    });
                }
                finally
                {
                    return false;
                }
            });
        });
    //-->
    </script>
</body>
</html>
