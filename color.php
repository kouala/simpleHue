<?php
/* ===================================================
====== Color Converter (Hex, RGB, XYZ, xyY)
====== By MILA Yannick - http://www.kouala.org
=================================================== */

# ----------------------------------------------------
# Convert hexadecimal to RGB
# ----------------------------------------------------	
function HextoRgb($color){
	if(!is_array($color) && preg_match("/^[#]([0-9a-fA-F]{6})$/",$color)){
		$hex_R = substr($color,1,2);
		$hex_G = substr($color,3,2);
		$hex_B = substr($color,5,2);
		return array(hexdec($hex_R),hexdec($hex_G),hexdec($hex_B));	
	}
}

# ----------------------------------------------------
# convert RGB to XYZ
# ----------------------------------------------------
function RgbtoXYZ($color){
	$var_R = ( $color[0] / 255 );        
	$var_G = ( $color[1] / 255 );       
	$var_B = ( $color[2] / 255 );       	
	if ( $var_R > 0.04045 ) { $var_R = pow( ( $var_R + 0.055 ) / 1.055 , 2.4); }else{ $var_R = $var_R / 12.92; }
	if ( $var_G > 0.04045 ) { $var_G = pow( ( $var_G + 0.055 ) / 1.055 , 2.4); }else{ $var_G = $var_G / 12.92; }
	if ( $var_B > 0.04045 ) { $var_B = pow( ( $var_B + 0.055 ) / 1.055 , 2.4); }else{ $var_B = $var_B / 12.92; }	
	$var_R = $var_R * 100;
	$var_G = $var_G * 100;
	$var_B = $var_B * 100;	
	$X1 = $var_R * 0.4124 + $var_G * 0.3576 + $var_B * 0.1805;
	$Y1 = $var_R * 0.2126 + $var_G * 0.7152 + $var_B * 0.0722;
	$Z1 = $var_R * 0.0193 + $var_G * 0.1192 + $var_B * 0.9505;	
	return array($X1,$Y1,$Z1);
}

# ----------------------------------------------------
# convert XYZ to xyY
# ----------------------------------------------------
function XYZtoxyY($color) {
	$X1 = ( $color[0] );        
	$Y1 = ( $color[1] );        
	$Z1 = ( $color[2] );
	$X = $X1 ;
	$Y = $Y1 ;
	$Z = $Z1 ;
	$x = $X / ($X + $Y + $Z);
	$y = $Y / ($X + $Y + $Z);
	return array($x,$y,$Y);	
}

# ----------------------------------------------------
# convert xyY to XYZ
# ----------------------------------------------------
function xyYtoXYZ($color) {
	$x = ( $color[0] );        
	$y = ( $color[1] );        
	$Y = ( $color[2] );
	$X = $x * ( $Y / $y );
	$Y = $Y;
	$Z = ( 1 - $x - $y ) * ( $Y / $y );	
	return array($X,$Y,$Z);	
}

# ----------------------------------------------------
# Convert XYZ to RGB
# ----------------------------------------------------
function XYZtoRgb($color){	
	$X = ( $color[0] / 100 );        
	$Y = ( $color[1] / 100 );        
	$Z = ( $color[2] / 100 );	
	$r = $X * 3.2406 	+ $Y * -1.5372 	+ $Z * -0.4986;
	$g = $X * -0.9689 	+ $Y * 1.8758 	+ $Z * 0.0415;
	$b = $X * 0.0557 	+ $Y * -0.2040 	+ $Z * 1.0570;	
	
	if ($r > $b && $r > $g && $r > 1) {
        // red is too big
        $g = $g / $r;
        $b = $b / $r;
        $r = 1;
    }elseif ($g > $b && $g > $r && $g > 1) {
        // green is too big
        $r = $r / $g;
        $b = $b / $g;
        $g = 1;
    }elseif ($b > $r && $b > $g && $b > 1) {
        // blue is too big
        $r = $r / $b;
        $g = $g / $b;
        $b = 1;
    }
	
	$r = $r <= 0.0031308 ? 12.92 * $r : (1.0 + 0.055) * pow($r, (1.0 / 2.4)) - 0.055;
	$g = $g <= 0.0031308 ? 12.92 * $g : (1.0 + 0.055) * pow($g, (1.0 / 2.4)) - 0.055;
	$b = $b <= 0.0031308 ? 12.92 * $b : (1.0 + 0.055) * pow($b, (1.0 / 2.4)) - 0.055;
	
	if ($r > $b && $r > $g) {
		if ($r > 1) {
        // red is too big
        $g = $g / $r;
        $b = $b / $r;
        $r = 1;
        }
    }elseif ($g > $b && $g > $r) {
		if ($g > 1) {
        // green is too big
        $r = $r / $g;
        $b = $b / $g;
        $g = 1;
        }
    }elseif ($b > $r && $b > $g) {
		if ($b > 1) {
        // blue is too big
        $r = $r / $b;
        $g = $g / $b;
        $b = 1;
        }
    }
    	
	$r = abs(intval($r*255));
	$g = abs(intval($g*255));
	$b = abs(intval($b*255));	
	
	return array($r,$g,$b);	
}

# ----------------------------------------------------
# convert RGB to hexadecimal
# ----------------------------------------------------
function RgbtoHex($color){
	if(!is_array($color)){$color = explode(",",$color);}	
	foreach($color as $value){
	$hex_value = dechex($value); 
	if(strlen($hex_value)<2){$hex_value="0".$hex_value;}
	$hex_RGB.=$hex_value;
	}	
	return "#".$hex_RGB;	
}
?>
