<?php
/* ===================================================
====== Simple Hue
====== By MILA Yannick - http://dev.kouala.org
=================================================== */

# ----------------------------------------------------
# Get All Groups
# Method GET, Return an array
# ----------------------------------------------------
function GetAllGroups() {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/groups";
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Create Group
# Method POST, Specify Array, Return an array
# ----------------------------------------------------
function CreateGroup($arraypost) {
	global $server;
	global $user;
	global $device;
	$url = "http://".$server."/api/".$user."/groups";
	
	$arrayattr = array();
	
	// Lights ---------------------------------
	if (!empty($arraypost["lights"])) {
		foreach($arraypost["lights"] as $keylight => $valuelight) {
			$templight[] = $valuelight;
		}
		$arrayattr[] = "\"lights\":[\"".implode("\",\"", $templight)."\"]";
	}
	
	// Name -------------------------------------
	$arrayattr[] = "\"name\":\"".$arraypost["name"]."\"";
	
	$attr  = "{";
	$attr .= implode($arrayattr, ",");
	$attr .= "}";
	
	return LaunchCurl($url,"post",$attr);
}

# ----------------------------------------------------
# Get Group Attributes
# Method GET, Specify ID of the Group, Return an array
# ----------------------------------------------------
function GetGroupAttributes($id) {
	global $server;
	global $user;
	$url = "http://".$server."/api/".$user."/groups/".$id;
	$array = LaunchCurl($url);
	return $array;
}

# ----------------------------------------------------
# Update Group
# Method POST, Specify Array, Return an array
# ----------------------------------------------------
function UpdateGroup($arraypost) {
	global $server;
	global $user;
	global $device;
	$url = "http://".$server."/api/".$user."/groups/".$arraypost["id"];
	
	$arrayattr = array();
	
	// Lights ---------------------------------
	if (!empty($arraypost["lights"])) {
		foreach($arraypost["lights"] as $keylight => $valuelight) {
			$templight[] = $valuelight;
		}
		$arrayattr[] = "\"lights\":[\"".implode("\",\"", $templight)."\"]";
	}
	
	// Name -------------------------------------
	$arrayattr[] = "\"name\":\"".$arraypost["name"]."\"";
	
	$attr  = "{";
	$attr .= implode($arrayattr, ",");
	$attr .= "}";
	
	return LaunchCurl($url,"put",$attr);
}

# ----------------------------------------------------
# Delete Group
# Method DELETE, Specify Array, Return an array
# ----------------------------------------------------
function DeleteGroup($array) {
	global $server;
	global $user;
	$group 		= $array["group"];	
	$url = "http://".$server."/api/".$user."/groups/".$group;	
	return LaunchCurl($url,"delete");
}

# ----------------------------------------------------
# Set Group
# Method PUT, Specify Array, Return an array
# ----------------------------------------------------
function SetGroup($arrayget) {
	
	print_r($arrayget);
	
	$group 		= $arrayget["group"];
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
	
		
	$url = "http://".$server."/api/".$user."/groups/".$group."/action";
	
	$arrayattr = array();
	
	// State On ----------------------------------
	$arrayattr[] = "\"on\":".($on==1 ? "true" : "false")."";
	
	// Color hex ---------------------------------
	if (!empty($colorhex)) {
		$tabcolor = convertColorHextoxyY($colorhex);
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

}
?>