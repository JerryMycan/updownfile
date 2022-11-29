<?php include 'filesLogic.php'; ?> <!-- Import der PHP-Logik-->
<!DOCTYPE html>
<html>
    <head>
        <title> Upload und Download von Dateien!</title>
        <link rel="stylesheet" href="style.css"/><!-- Auf CSS-Datei verweisen-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <h3>Upload Files</h3>
                    <input type="file" name="myfile"><br>
                    <button type="submit" name="save">Upload</button>
                </form>
            </div>
            <div class="row">
                <table>
                    <thead>
                        <th>ID</th>
                        <th>FileName</th>
                        <th>Size (in MB)</th>
                        <th>Downloads</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach($files as $file): ?>
                        <tr>
                            <td><?php echo $file['id'];?></td>
                            <td><?php echo $file['name'];?></td>
                            <td><?php echo $file['size'] / 1000 . "KB";?></td>
                            <td><?php echo $file['downloads'];?></td>
                            <td>
                                <a href="index.php?file_id=<?php echo
                                $file['id']?>">Downloads</a>
                            </td>
                        </tr>
                        <?php endforeach ; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>