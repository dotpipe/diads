<?php

    // insert tax files to database
    $conn = new mysqli('localhost', "root", "", "ADAPT");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    foreach (scandir("tax/") as $file) {
        echo $file . " ";
        if ($file == '.' || $file == '..')
            continue;
        $query = 'LOAD DATA INFILE \'c:/xampp/htdocs/ADAPT/tax/' . $file . '\' INTO TABLE ADAPT.taxes FIELDS TERMINATED BY \',\' ENCLOSED BY \'' . chr(34) . '\' LINES TERMINATED BY \'\n\' IGNORE 1 ROWS';
        $f = $conn->query($query) or die (mysqli_error($conn));
        
    }
?>
        