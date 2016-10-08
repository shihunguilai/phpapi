<?php
require_once dirname(__DIR__).'/common.php';
?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>Insert title here</title>
    </head>
    <body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="file">filename:</label>
        <input type="file" name="file" id="file" /><Br/>

        <input type="file" name="file1[]"  /><Br/>
        <input type="file" name="file1[]"  /><Br/>

       可以上传多个文件： <input type="file" name="file2[]"  multiple="multiple"/>
        <Br/>
        <input type="submit" value="上传" />
    </form>
    </body>
    </html>


    <?php
$upload = new \shihunguilai\phpapi\Util\Upload('../../Upload/');
$res = $upload->doUPload();
print_r($res);
?>