<?php
$id = session_id();
$menu = "";

    
// Sidebar for Menu options
setcookie("time",time());

	if (isset($_COOKIE) && isset($_COOKIE['login']) && $_COOKIE['login'] == "true") {
		$menu = '<h3 onclick=menuList(\'sidebar/menu.php\')>Menu</h3><li>';
		$menu .= '<b style="font-size:18px;color:lightgray" onclick=mapView()>';
		$menu .= 'Click to Toggle Map</b><ul onclick=menuList(\'sidebar/linkclient.php\');>Link Account!</ul>';
		$menu .= '<ul onclick=menuList(\'sidebar/storechat.php\');>Cheri</ul>';
		$menu .= '<ul onclick=menuList(\'sidebar/preorder.php\');>Preorder</ul>';
		$menu .= '<ul onclick=menuList(\'sidebar/inbox.php\');>Inbox</ul>';
		$menu .= '<ul onclick=menuList(\'sidebar/myorders.php\');>My Orders</ul>';
		if (isset($_COOKIE) && $_COOKIE['store_cnt'] > 0) {
			$menu .= '<ul onclick="menuList(\'sidebar/mystores.php\');">My Stores</ul>';
		    $menu .= '<ul onclick="menuList(\'sidebar/adsheet.php\');">My Ads</ul>';
		}
		$menu .= '<ul><a href=\'nologin.php\' style=\'color:white;text-decoration:none;font-size:18px;\'>Logout</a></ul>';
		$menu .= '<ul>Logged in as ' . $_COOKIE['myemail'] . '</ul></li>';
	}
	else {
		$menu = '<h3 onclick="menuList(\'sidebar/menu.php\');">Menu</h3><li>';
		$menu .= '<b style="font-size:18px;color:lightgray" onclick=mapView()>';
		$menu .= 'Click to Toggle Map</b><ul onclick=menuList(\'sidebar/newclient.php\');>Create Account!</ul>';
		$menu .= '<ul onclick=menuList(\'sidebar/login.php\');>Login</ul></li>';
	}
$f = str_replace("\'",'"',$menu);
//echo json_encode($f);
echo $menu;
?>