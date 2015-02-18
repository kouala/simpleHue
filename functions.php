<?php
/* ===================================================
====== Simple Hue
====== By MILA Yannick - http://www.kouala.org
=================================================== */

# ----------------------------------------------------
# Convert hexadecimal to xyY
# ----------------------------------------------------
function convertColorHextoxyY($color='#fead59') {
	$rgb = HextoRgb($color);
	$xyz = RgbtoXYZ($rgb);
	$xyY = XYZtoxyY($xyz) ;
	$newcolor['x'] = $xyY[0];
	$newcolor['y'] = $xyY[1];
	$newcolor['Y'] = $xyY[2];
	return $newcolor;
}

# ----------------------------------------------------
# Convert xyY to hexadecimal
# ----------------------------------------------------
function convertColorxyYtoHex($color) {
	$xyz = xyYtoXYZ($color) ;
	$rgb = XYZtoRgb($xyz);
	$hex = RgbtoHex($rgb);
	return $hex;
}

# ----------------------------------------------------
# Convert object to Array
# ----------------------------------------------------
function objectToArray($d) {
    if (is_object($d)) { $d = get_object_vars($d); }
	if (is_array($d)) { return array_map(__FUNCTION__, $d); }else{ return $d; }
}

# ----------------------------------------------------
# Launch Curl function
# ----------------------------------------------------
function LaunchCurl($url,$method="",$attr="") {
	$headers = array(
	    'Accept: application/json',
	    'Content-Type: application/json',
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $url);
	if ($method=="put") {
		curl_setopt($ch, CURLOPT_PUT, true);
		if (!empty($attr)) {
			$putData = tmpfile();
			fwrite($putData, $attr);
			fseek($putData, 0);
			curl_setopt($ch, CURLOPT_INFILE, $putData);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen($attr));
		}
	}
	if ($method=="post") {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attr);
	}
	if ($method=="delete") {
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	}
	$output = curl_exec($ch);
	$array = objectToArray(json_decode($output));
	return $array;
}
?>
