<?php
//Datenbankverbindung
$conn = mysqli_connect("localhost", "root", "123456789", "my_hvk");
$sql = "SELECT * FROM files";
$result = mysqli_query($conn,$sql);
$files = mysqli_fetch_all($result,MYSQLI_ASSOC);

if(isset($_POST['save'])){
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    $filename = $_FILES['myfile']['name'];
    $destination = 'uploads/' . $filename;
    $extension = pathinfo($filename,PATHINFO_EXTENSION);

    if(!in_array($extension,['zip', 'pdf', 'jpg'])){
        echo "BITTE ausschließlich Dateien mit der Endung: .zip, .pdf .jpg hochladen!";
    }
    elseif($_FILES['myfile']['size'] > 1000000){
        "Die Datei ist zu groß!";
    }
    else{
        if(move_uploaded_file($file, $destination)){
            $sql = "INSERT INTO files (name, size, downloads)
            VALUES('$filename', '$size', 0)";
            if(mysqli_query($conn, $sql)){
                echo "Datei wurde erfolgreich hochgeladen!";
            }
            else{
                echo "Fehler beim Hochladen!";
            }
        }
    }
}

if(isset($_GET['file_id'])){
    $id = $_GET['file_id'];
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn,$sql);
    $file = mysqli_fetch_assoc($result);
    $filepath = 'uploads/' . $file['filename'];
    
    if(file_exists($filepath)){
        header('Content-type: application/octet-stream');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='
        . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma:public');
        header('Content-Length:'. filesize('uploads/'.$file['name']));

        readfile('uploads/'.$file['filename']);
        $newCount = $file['downloads'] + 1;
        $updatQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn,$updatQuery);
        exit;
    }
}
?>