<?php
/* ===================================================
====== Simple Hue
====== By MILA Yannick - http://www.kouala.org
=================================================== */

# ----------------------------------------------------
# Get All Lights
# Method GET, Return an array
# ----------------------------------------------------
function GetAllLights() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/lights";
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Get New Lights
# Method GET, Return an array
# ----------------------------------------------------
function GetNewLights() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/lights/new";
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Search New Lights
# Method POST, Return an array
# ----------------------------------------------------
function SearchNewLights() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/lights";
	$array = LaunchCurl($url,"post");
	return $array;
}

# ----------------------------------------------------
# Get Light Attributes
# Method GET, Specify ID of the Light, Return an array
# ----------------------------------------------------
function GetLightAttributes($id='') {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/lights/".$id;
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Get Light Attributes
# Method PUT, Specify ID and new name of the Light, Return an array
# ----------------------------------------------------
function SetLightAttributes($light,$name) {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/lights/".$light."";
	$arrayattr = array();
	// Name -------------------------------------
	$arrayattr[] = "\"name\":\"".$name."\"";
	$attr  = "{";
	$attr .= implode($arrayattr, ",");
	$attr .= "}";
	return LaunchCurl($url,"put",$attr);
}

# ----------------------------------------------------
# Get Light State
# Method PUT, Specify Array, Return an array
# ----------------------------------------------------
function SetLightState($arrayget) {
	
	$light 		= $arrayget["lamp"];
	$on 		= (empty($arrayget["on"]) ? 0 : $arrayget["on"]);
	$colorhex 	= (empty($arrayget["colorhex"]) ? "#fead59" : "#".$arrayget["colorhex"]);
	$alert 		= (empty($arrayget["alert"]) ? "none" : $arrayget["alert"]);
	$bri 		= (empty($arrayget["bri"]) ? "254" : $arrayget["bri"]);
	$ct 		= (empty($arrayget["ct"]) ? "369" : $arrayget["ct"]);
	$hue 		= (empty($arrayget["hue"]) ? "14910" : $arrayget["hue"]);
	$sat 		= (empty($arrayget["sat"]) ? "144" : $arrayget["sat"]);
	$transition = (empty($arrayget["transition"]) ? "0" : $arrayget["transition"]);
	$effect	 	= (empty($arrayget["effect"]) ? "none" : $arrayget["effect"]);

	global $server;
	global $user;	
	echo $light;
	if (IsLightReacheable($light)) {
		
	$url = "http://".$server."/api/".$user."/lights/".$light."/state";
	
	$arrayattr = array();
	
	// State On ----------------------------------
	$arrayattr[] = "\"on\":".($on==1 ? "true" : "false")."";
	
	// Color hex ---------------------------------
	if (!empty($colorhex)) {
		$tabcolor = convertColorHextoxyY($colorhex);
		print_r($tabcolor);
		$x = $tabcolor["x"];
		$y = $tabcolor["y"];
		$bri = intval($tabcolor['Y']);
		$arrayattr[] = "\"xy\":[".$x.",".$y."]";
	}
	if ($colorhex="#fead59") {
		$bri = "254";
	}
	// Alert -------------------------------------
	$arrayattr[] = "\"alert\":\"".$alert."\"";
	
	// Brightness --------------------------------
	$arrayattr[] = "\"bri\":".$bri;
	
	// Colour Temperature ------------------------
	$arrayattr[] = "\"ct\":".$ct;
	
	// Hue ---------------------------------------
	$arrayattr[] = "\"hue\":".$hue;
	
	// Saturation --------------------------------
	$arrayattr[] = "\"sat\":".$sat;
	
	// Transition --------------------------------
	$arrayattr[] = "\"transitiontime\":".$transition;
	
	// Effect ------------------------------------
	$arrayattr[] = "\"effect\":\"".$effect."\"";
	
	$attr  = "{";
	$attr .= implode($arrayattr, ",");
	$attr .= "}";
	//echo $attr;
	return LaunchCurl($url,"put",$attr);
	
	}else{
		
	return "Error";	
		
	}

}

# ----------------------------------------------------
# Is Light Reacheable
# Method GET, Specifiy ID of the Light, Return 1/0
# ----------------------------------------------------
function IsLightReacheable($light) {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/lights/".$light."";
	$array = LaunchCurl($url);
	return $array['state']['reachable'];
}

?>
