<?php
    putenv("GNUPGHOME=/home/xiv/.gnupg");

    $decrypt_len = 512;
    $time = $timed = time();
    $decryptkey = "";
    srand($timed);

    for ($i = 0 ; $i < $decrypt_len ; $i++)
    {
        $next = rand(0,64);
        $enum_sleep[] = $next;
    }

    for ($i = 0 ; strlen($decryptkey) < $decrypt_len ; $i++)
    {
        $in = rand(hexdec("45"),hexdec("79"));
        $decryptkey .= decbin($in);
        //time_nanosleep(0,$enum_sleep[$i]);
        $in = srand($enum_sleep[$i]);
    }

    $first_key = $decryptkey;
    $decryptkey = "";
    $timed = $time;
    srand($timed);
    for ($i = 0 ; strlen($decryptkey) < $decrypt_len ; $i++)
    {
        $in = rand(hexdec("45"),hexdec("79"));
        $decryptkey .= decbin($in);
        //time_nanosleep(0,$enum_sleep[$i]);
        $in = srand($enum_sleep[$i]);
    }

    while ($decryptkey != $first_key)
    {
        $decryptkey = substr($decryptkey,1);
        $first_key = substr($first_key,1);
    }

    $bytestring = "";
    $i = 0;
    $dictionary = "0987654321abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+";
    while (strlen($decryptkey) > $i)
    {
        $bytestring .= $dictionary[bindec(substr($decryptkey,$i,6))-1];
        $i+=6;
    }

    echo $bytestring . " ";// . ($decryptkey == $first_key) . "<br> " . $first_key;
    echo "<br>";
    echo $decryptkey . " " . ($decryptkey == $first_key) . "<br> " . $first_key;

    $res = gnupg_init(["file_name" => "/usr/bin/gpg-agent", "home_dir" => "/home/xiv/.gnupg"]);
    gnupg_addencryptkey($res,'4D9A14863066ADBC53A7A3FC34B8078EA4A5C0C9');
    gnupg_adddecryptkey($res,"$bytestring",'UserEnteredKey');
    $example = gnupg_encrypt($res,'TESTING!!');
    echo $example;

?>