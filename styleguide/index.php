<!-- Include Header -->
<?php include 'system/header.php';
$i = 0; 
$dir = 'uploads/';
if ($handle = opendir($dir)) {
    while (($file = readdir($handle)) !== false){
        if (!in_array($file, array('.', '..')) && !is_dir($dir.$file)) 
            $i++;
    }
}
$a = $i - 1;
if ($a === 0) {
?>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<?php } else { ?>
<?php
foreach (glob("uploads/*.png") as $filename) {
    echo "$filename size " . filesize($filename) . "\n";
}
?>
<?php } include 'system/footer.php'; ?>