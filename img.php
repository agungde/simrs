<?php
    $name = $_GET['name'];
	$dirpat = $_GET['dirpat'];
    $mimes = array
    (
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpg',
        'gif' => 'image/gif',
        'png' => 'image/png'
    );

    $ext = strtolower(end(explode('.', $name)));

    $file = "$dirpat/".$name;
    header('content-type: '. $mimes[$ext]);
    header('content-disposition: inline; filename="'.$name.'";');
    readfile($file);
?>