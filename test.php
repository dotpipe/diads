<?php

include_once('crud.php');


$crud = new CRUD('./config.json');

$crud->db->create(
    [
        "ID" => NULL,
        "KEYWORD" => "TIGER",
        "DEFINIITION" => "ANIMAL WITH STRIPES KNOWN FOR BEING IN SOUTHERN ASIA"
    ], "keywords"
);

?>