<?php
/*
	This is PHP file that generates CAPTCHA image for the How to Create CAPTCHA Protection using PHP and AJAX Tutorial

	You may use this code in your own projects as long as this 
	copyright is left in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	For the rest of the code visit http://www.WebCheatSheet.com
	
	Copyright 2006 WebCheatSheet.com	

*/
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//Start the session so we can store what the security code actually is
session_start();

//Send a generated image to the browser 
create_image(); 
exit(); 

function create_image() 
{ 
    //Let's generate a totally random string using md5 
    $md5_hash = md5(rand(0,999)); 
    //We don't need a 32 character long string so we trim it down to 5 
    $string = substr($md5_hash, 15, 4); 
	$image = imagecreatefromjpeg("images/1.jpg");
    //Set the session to store the security code
    $_SESSION["security_code"] = $string;

    //We are making three colors, white, black and gray 
    $white = ImageColorAllocate($image, 255, 255, 255); 
    $black = ImageColorAllocate($image, 0, 0, 0); 
    $grey = ImageColorAllocate($image, 140, 140, 140);
    //random dark colors
	$line = imagecolorallocate($image, rand(0,70), rand(0, 70), rand(0, 70));
	$line2 = imagecolorallocate($image, rand(0,70), rand(0, 70), rand(0, 70));

	//draw askew random lines
	imagesetthickness($image, rand(1, 1));
	imageline($image, 10, 1, rand(30,200), rand(25,58), $line2);
	imagesetthickness($image, rand(1, 1));
	imageline($image, 1, 60, rand(40, 200), rand(10, 60), $line);
	imagesetthickness($image, rand(1, 1));
	imageline($image, 5 ,8 , rand(120, 200), rand(20, 60),$line2);
	imagesetthickness($image, rand(1, 1));
	imageline($image, rand(6, 60), rand(40, 60), rand(20, 200) , rand(15, 60), $line);
    //Make the background black 
//    ImageFill($image, 0, 0, $black); 

    //Add randomly generated string in white to the image
//    ImageString($image, 4, 8, 6, $security_code, $black); 

	//set random pixels with random color
	for ($i = 0; $i <= 256; $i++)
	{
		$point_color = imagecolorallocate ($image, rand(0,255), rand(0,255), rand(0,255));
		imagesetpixel($image, rand(6,200), rand(2,58), $point_color);
	}
	
// Write the string on to the image using TTF fonts 
//	  imagettftext($image, 14, 4, 15, 25, $grey, 'SerpentisBlack.ttf', $string);  

	  	//Write text to the image using TrueType fonts

	$y1 = rand(22, 28);
	imagettftext($image, 15,  rand(-30, 30), 12, $y1, $black, dirname(__file__).'/Verdana.ttf', substr($string,  0, 1));
	$y2 = rand(15, 20);
	imagettftext ($image, 15, rand(0, 30), rand(30, 40), $y2, $line2,dirname(__file__).'/trebuc.ttf', substr($string,  1, 1));
	$y3 = rand(22, 28);
	ImageTTFText ($image, 15, rand(-20, 0), rand(40, 50), $y3, $black,dirname(__file__).'/trebuc.ttf', substr($string,  2, 1));
	$y4 = rand(15, 20);
	ImageTTFText ($image, 15, rand(0, 30), rand(60, 70), $y4, $black, dirname(__file__).'/Verdana.ttf', substr($string,  3, 1));
//	$x = rand(0, 50);
//	$y = rand(0, 50);
	
    //Throw in some lines to make it a little bit harder for any bots to break 
//    ImageRectangle($image,0,0,$width-1,$height-1,$white); 
//    imageline($image, 0, $height/2, $width, $height/2, $white); 
//    imageline($image, $width/2, 0, $width/2, $height, $white); 
 
    //Tell the browser what kind of file is come in 
    header("Content-Type: image/jpeg"); 

    //Output the newly created image in jpeg format 
    ImageJpeg($image); 
    
    //Free up resources
    ImageDestroy($image); 
} 
?>