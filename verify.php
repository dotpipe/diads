<?php
$x = urldecode($_POST['password']);
$y = urldecode($_POST['email']);

$conn = mysqli_connect("localhost", "root", "", "ADAPT", "3306") or die("Error: Cannot create connection");

if (!isset($_SESSION))
    session_start();

setcookie("login","false",time()+60*60*($_COOKIE['vartime']+1));
$z = [];
if (mysqli_connect_errno()) {
    echo "";
    exit();
}
$results = "";

$results = $conn->query('SELECT store_uniq, store_creditor, username, password, alias FROM ad_revs WHERE username = "' . $y . '"') or die(mysqli_error($conn));

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        if (!password_verify($x, $rows['password'])) {
            unset($_COOKIE);
            //setcookie("login","false",time()+60*60*($_COOKIE['vartime']+1));
            echo "FALSE1";
            header("Location: ./");
            exit();
        }
        
        if ($_POST['remember'] == "checked")
            setcookie("vartime",24*60);
        else
            setcookie("vartime",1);
            
        setcookie("myemail", $rows['username'],time()+60*60*($_COOKIE['vartime']+1));
        setcookie("myid",$rows['store_uniq'],time()+60*60*($_COOKIE['vartime']+1));
        setcookie("myname",$rows['store_creditor'],time()+60*60*($_COOKIE['vartime']+1));
        setcookie("myalias",$rows['alias'],time()+60*60*($_COOKIE['vartime']+1));
        setcookie("login","true",time()+60*60*($_COOKIE['vartime']+1));
        echo "TRUE";
        if (!isset($_COOKIE['count']) || isset($_COOKIE['count']))
            setcookie("count", 0);
        setcookie("lock", time()+1000);

        $sql = 'SELECT COUNT(*) FROM franchise WHERE (franchise.email = "' . $_COOKIE['myemail'] . '" || franchise.owner_id  = "' . $_COOKIE['myemail'] . '")';
        $stores = $conn->query($sql) or die (mysqli_error($conn));
        
        header("Location: ./");
    }
    else {
        if (!isset($_COOKIE['count']))
            setcookie("count", 0);
        if (isset($_COOKIE['count']))
            $_COOKIE['count']++;
        if ($_COOKIE['count'] >= 3)
            setcookie("lock", time()+60*60*24);
        setcookie("login","false",time()+60*60*($_COOKIE['vartime']+1));
        header("Location: ./");
    }
    
?>