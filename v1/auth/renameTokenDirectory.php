<?php
function renameTokenDirectory(, ) {
     = "../uploads/";
     = "../uploads/";
    if (file_exists()) {
        rename(, );
        updateFilePathsInDatabase(, );
    }
}

function updateFilePathsInDatabase(, ) {
    global ;
     = ->prepare("UPDATE user_files SET token = ?, file_path = REPLACE(file_path, ?, ?) WHERE token = ?");
    ->bind_param("ssss", , , , );
    ->execute();
}
