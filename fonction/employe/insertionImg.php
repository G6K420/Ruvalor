<?php

function is_valid_file_extension($filename) {
  $allowed_extensions = array('jpg', 'jpeg', 'png');
  $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
  return in_array(strtolower($file_extension), $allowed_extensions);
}

if (isset($_FILES['monImage']) && is_valid_file_extension($_FILES['monImage']['name'])) {
  	$id = $_GET['numId'];

    $imgname = $_FILES['monImage']['name'];

    $extension = pathinfo($imgname, PATHINFO_EXTENSION);
    echo $extension;
    $rename = $id;
    $newName = $rename.'.'.$extension;
    $fileName = $_FILES['monImage']['tmp_name'];

    $deplacer = move_uploaded_file($fileName, '../../img/photo/'.$newName);

    header("location:" . $_SERVER['HTTP_REFERER']); 

} 
else {

    echo ' <script>alert("Merci de rentrer uniquement des fichiers .png, .jpg ou .jpeg");window.history.back() ;</script>';

}
	

?>