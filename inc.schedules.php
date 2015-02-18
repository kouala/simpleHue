<?php
/* ===================================================
====== Simple Hue
====== By MILA Yannick - http://dev.kouala.org
=================================================== */

# ----------------------------------------------------
# Get All Schedules
# Method GET, Return an array
# ----------------------------------------------------
function GetAllSchedules() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/schedules";
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Create Schedule
# Method POST, Specify Array, Return an array
# ----------------------------------------------------
function CreateSchedule($arraypost) {
	global $server;
	global $user;
	global $device;
	$url = "http://".$server."/api/".$user."/schedules";
	
	$status 	= (empty($arraypost["status"]) ? "enabled" : $arraypost["status"]);
	
	$on 		= (empty($arraypost["on"]) ? 0 : $arraypost["on"]);
	$colorhex 	= (empty($arraypost["colorhex"]) ? "#fead59" : "#".$arraypost["colorhex"]);
	$alert 		= (empty($arraypost["alert"]) ? "none" : $arraypost["alert"]);
	$bri 		= (empty($arraypost["bri"]) ? "254" : $arraypost["bri"]);
	$ct 		= (empty($arraypost["ct"]) ? "369" : $arraypost["ct"]);
	$hue 		= (empty($arraypost["hue"]) ? "14910" : $arraypost["hue"]);
	$sat 		= (empty($arraypost["sat"]) ? "144" : $arraypost["sat"]);
	$transition = (empty($arraypost["transition"]) ? "0" : $arraypost["transition"]);
	$effect	 	= (empty($arraypost["effect"]) ? "none" : $arraypost["effect"]);
	
	$arrayattr = array();
	
	// Name -------------------------------------
	$arrayattr[] = "\"name\":\"".$arraypost["name"]."\"";
	
	// Description -------------------------------------
	$arrayattr[] = "\"description\":\"".$arraypost["description"]."\"";
	
	// Command -------------------------------------
	
	// State On ----------------------------------
	$arrayattr1[] = "\"on\":".($on==1 ? "true" : "false")."";
	
	// Color hex ---------------------------------
	if (!empty($colorhex)) {
		$tabcolor = convertColorHextoxyY($colorhex);
		$x = $tabcolor["x"];
		$y = $tabcolor["y"];
		$bri = intval($tabcolor['Y']);
		$arrayattr1[] = "\"xy\":[".$x.",".$y."]";
	}
	if ($colorhex="#fead59") {
		$bri = "254";
	}
	/*
	// Alert -------------------------------------
	$arrayattr1[] = "\"alert\":\"".$alert."\"";
	
	// Brightness --------------------------------
	$arrayattr1[] = "\"bri\":".$bri;
	
	// Colour Temperature ------------------------
	$arrayattr1[] = "\"ct\":".$ct;
	
	// Hue ---------------------------------------
	$arrayattr1[] = "\"hue\":".$hue;
	
	// Saturation --------------------------------
	$arrayattr1[] = "\"sat\":".$sat;
	
	// Transition --------------------------------
	$arrayattr1[] = "\"transitiontime\":".$transition;
	
	// Effect ------------------------------------
	$arrayattr1[] = "\"effect\":\"".$effect."\"";
	*/
	
	$arrayattr[] = "\"command\":{
		\"address\": \"/api/".$user."/groups/".$arraypost["group"]."/action\",
		\"method\": \"PUT\",
		\"body\": { ".implode(",", $arrayattr1)." }}";
	
	// LocalTime -------------------------------------
	$arrayattr[] = "\"localtime\":\"".$arraypost["localtime"]."\"";
	
	// Status -------------------------------------
	$arrayattr[] = "\"status\":\"".$status."\"";
	
	$attr  = "{";
	$attr .= implode($arrayattr, ",");
	$attr .= "}";
	echo $attr;
	return LaunchCurl($url,"post",$attr);
}

# ----------------------------------------------------
# Get Schedule Attributes
# Method GET, Return an array
# ----------------------------------------------------
function GetScheduleAttributes($id) {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/schedules/".$id;
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Set Schedule Attributes
# Method POST, Specify Array, Return an array
# ----------------------------------------------------
function SetScheduleAttributes($arraypost) {
	global $server;
	global $user;
	global $device;
	$url = "http://".$server."/api/".$user."/schedules/".$id;
	
	$status 	= (empty($arraypost["status"]) ? "enabled" : $arraypost["status"]);
	
	$on 		= (empty($arraypost["on"]) ? 0 : $arraypost["on"]);
	$colorhex 	= (empty($arraypost["colorhex"]) ? "#fead59" : "#".$arraypost["colorhex"]);
	$alert 		= (empty($arraypost["alert"]) ? "none" : $arraypost["alert"]);
	$bri 		= (empty($arraypost["bri"]) ? "254" : $arraypost["bri"]);
	$ct 		= (empty($arraypost["ct"]) ? "369" : $arraypost["ct"]);
	$hue 		= (empty($arraypost["hue"]) ? "14910" : $arraypost["hue"]);
	$sat 		= (empty($arraypost["sat"]) ? "144" : $arraypost["sat"]);
	$transition = (empty($arraypost["transition"]) ? "0" : $arraypost["transition"]);
	$effect	 	= (empty($arraypost["effect"]) ? "none" : $arraypost["effect"]);
	
	$arrayattr = array();
	
	// Name -------------------------------------
	$arrayattr[] = "\"name\":\"".$arraypost["name"]."\"";
	
	// Description -------------------------------------
	$arrayattr[] = "\"description\":\"".$arraypost["description"]."\"";
	
	// Command -------------------------------------
	
	// State On ----------------------------------
	$arrayattr1[] = "\"on\":".($on==1 ? "true" : "false")."";
	
	// Color hex ---------------------------------
	if (!empty($colorhex)) {
		$tabcolor = convertColorHextoxyY($colorhex);
		$x = $tabcolor["x"];
		$y = $tabcolor["y"];
		$bri = intval($tabcolor['Y']);
		$arrayattr1[] = "\"xy\":[".$x.",".$y."]";
	}
	if ($colorhex="#fead59") {
		$bri = "254";
	}
	/*
	// Alert -------------------------------------
	$arrayattr1[] = "\"alert\":\"".$alert."\"";
	
	// Brightness --------------------------------
	$arrayattr1[] = "\"bri\":".$bri;
	
	// Colour Temperature ------------------------
	$arrayattr1[] = "\"ct\":".$ct;
	
	// Hue ---------------------------------------
	$arrayattr1[] = "\"hue\":".$hue;
	
	// Saturation --------------------------------
	$arrayattr1[] = "\"sat\":".$sat;
	
	// Transition --------------------------------
	$arrayattr1[] = "\"transitiontime\":".$transition;
	
	// Effect ------------------------------------
	$arrayattr1[] = "\"effect\":\"".$effect."\"";
	*/
	
	$arrayattr[] = "\"command\":{
		\"address\": \"/api/".$user."/groups/".$arraypost["group"]."/action\",
		\"method\": \"PUT\",
		\"body\": { ".implode(",", $arrayattr1)." }}";
	
	// LocalTime -------------------------------------
	$arrayattr[] = "\"localtime\":\"".$arraypost["name"]."\"";
	
	// Status -------------------------------------
	$arrayattr[] = "\"status\":\"".$status."\"";
	
	$attr  = "{";
	$attr .= implode($arrayattr, ",");
	$attr .= "}";
	
	return LaunchCurl($url,"put",$attr);
}

# ----------------------------------------------------
# Delete Schedule
# Method GET, Return an array
# ----------------------------------------------------
function DeleteSchedule($id) {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/schedules/".$id;
	$array = LaunchCurl($url,"delete");
	return $array;
}

?>