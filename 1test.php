<?php 
//    if(isset($_POST["BookletSayfaAdedi"])) {
    print_r($_FILES);
    print_r($_POST);

    foreach ($_FILES['TopluPDF']['name'] as $key => $value) {
        move_uploaded_file($_FILES['TopluPDF']['tmp_name'][$key], "upload/" . $_FILES['TopluPDF']['name'][$key]);
    }
    
//    }

