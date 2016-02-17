<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>

<link rel="stylesheet" type="text/css" href="uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<h1>Uploadify Demo</h1>
	<form action="music.php"  method="POST"  enctype="multipart/form-data">
		<div id="queue"></div>
 <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
        <input  type="file" name="file_upload" />
        <input  type="submit"  value="上传" />
	</form>


</body>
</html>