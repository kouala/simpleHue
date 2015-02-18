<?php
/* ===================================================
====== Simple Hue
====== By MILA Yannick - http://www.kouala.org
=================================================== */

# ----------------------------------------------------
# Create User
# Method POST, Return an array
# ----------------------------------------------------
function CreateUser() {
	global $server;
	global $user;
	global $device;
	$url = "http://".$server."/api";
	$attr = "{\"username\":\"".$user."\",\"devicetype\":\"".$device."\"}";
	return LaunchCurl($url,"post",$attr);
}

# ----------------------------------------------------
# Get Configuration
# Method GET, Return an array
# ----------------------------------------------------
function GetConfiguration() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/config";
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Modify Configuration
# Method PUT, Return an array
# ----------------------------------------------------
function ModifyConfiguration() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/config";
	$attr = "{\"username\":\"".$user."\",\"devicetype\":\"".$device."\"}";
	$array = LaunchCurl($url,"put",$attr);
	return $array;
}

# ----------------------------------------------------
# Delete User
# Method DELETE, Return an array
# ----------------------------------------------------
function DeleteUser() {
	global $server;
	global $user;
	global $device;
	$url = "http://".$server."/api/".$user."/config/whitelist/".$user;
	return LaunchCurl($url,"delete");
}

# ----------------------------------------------------
# Get Full State
# Method GET, Return an array
# ----------------------------------------------------
function GetFullState() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user;
	$array = LaunchCurl($url);
	return $array;
}

?>
