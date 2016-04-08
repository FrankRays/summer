<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>uploadindex</title>
</head>
<body>
<form action="<?php echo site_url('d=admin&c=upload_file&m=upload') ?>" method="post" enctype="multipart/form-data">
<input type="file" name="imgfile" />
<input type="submit" value="submit" />
</form>
</body>
</html>