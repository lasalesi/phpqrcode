<?php

$font = "FreeSansBold.ttf";

function ean_checkdigit($code){
  $code = str_pad($code, 12, "0", STR_PAD_LEFT);
  $sum = 0;
  for($i=(strlen($code)-1);$i>=0;$i--){
    $sum += (($i % 2) * 2 + 1 ) * $code[$i];
  }
  return (10 - ($sum % 10));
}

function encode_ean13($ean){
  $digits=array(3211,2221,2122,1411,1132,1231,1114,1312,1213,3112);
  $mirror=array("000000","001011","001101","001110","010011","011001","011100","010101","010110","011010");
  $guards=array("9a1a","1a1a1","a1a");

  $ean=trim($ean);
  if (preg_match("#[^0-9]#i",$ean)){
    die("Invalid EAN-Code");
  }

  if (strlen($ean)<12 || strlen($ean)>13){
    die("Invalid EAN13 Code (must have 12/13 numbers)");
  }

  $ean=substr($ean,0,12);
  $eansum=ean_checkdigit($ean);
  $ean.=$eansum;
  $line=$guards[0];
  for ($i=1;$i<13;$i++){
    $str=$digits[$ean[$i]];
    if ($i<7 && $mirror[$ean[0]][$i-1]==1) $line.=strrev($str); else $line.=$str;
    if ($i==6) $line.=$guards[1];
  }
  $line.=$guards[2];

  /* create text */
  $pos=0;
  $text="";
  for ($a=0;$a<13;$a++){
    if ($a>0) $text.=" ";
    $text.="$pos:12:{$ean[$a]}";
    if ($a==0) $pos+=12;
    else if ($a==6) $pos+=12;
    else $pos+=7;
  }

   return array("bars" => $line,	"text" => $text);
}

function ean13_barcode($code, $scale = 1, $height = 0){
  
  $ean=encode_ean13($code);
  $bars=$ean['bars'];
  $text=$ean['text'];

  global $font;
  
  $bar_color=Array(0,0,0);
  $bg_color=Array(255,255,255);
  $text_color=Array(0,0,0);

  /* set defaults */
  if ($scale<1) $scale=2;
  $height=(int)($height);
  if ($height<1) $height=(int)$scale * 60;

  $space=array('top'=>2*$scale,'bottom'=>2*$scale,'left'=>2*$scale,'right'=>2*$scale);
  
  /* count total width */
  $xpos=0;
  $width=true;
  for ($i=0;$i<strlen($bars);$i++){
    $val=strtolower($bars[$i]);
    if ($width){
        $xpos+=$val*$scale;
        $width=false;
        continue;
    }
    if (preg_match("#[a-z]#", $val)){
        /* tall bar */
        $val=ord($val)-ord('a')+1;
    } 
    $xpos+=$val*$scale;
    $width=true;
  }

  /* allocate the image */
  $total_x=( $xpos )+$space['right']+$space['right'];
  $xpos=$space['left'];
  if (!function_exists("imagecreate")){
    return "Please ask your site admin to install php_gd2 extention";
  }
  $im=imagecreate($total_x, $height);
  /* create two images */
  $col_bg=ImageColorAllocate($im,$bg_color[0],$bg_color[1],$bg_color[2]);
  $col_bar=ImageColorAllocate($im,$bar_color[0],$bar_color[1],$bar_color[2]);
  $col_text=ImageColorAllocate($im,$text_color[0],$text_color[1],$text_color[2]);
  $height1=round($height-($scale*10));
  $height12=round($height-$space['bottom']);


  /* paint the bars */
  $width=true;
  for ($i=0;$i<strlen($bars);$i++){
    $val=strtolower($bars[$i]);
    if ($width){
      $xpos+=$val*$scale;
      $width=false;
      continue;
    }
    if (preg_match("#[a-z]#", $val)){
      /* tall bar */
      $val=ord($val)-ord('a')+1;
      $h=$height12;
    } else $h=$height1;
    imagefilledrectangle($im, $xpos, $space['top'], $xpos+($val*$scale)-1, $h, $col_bar);
    $xpos+=$val*$scale;
    $width=true;
  }
  /* write out the text */
  global $_SERVER;
  $chars=explode(" ", $text);
  reset($chars);
  while (list($n, $v)=each($chars)){
    if (trim($v)){
        $inf=explode(":", $v);
        $fontsize=$scale*($inf[1]/1.8);
        $fontheight1=$height-($fontsize/2.7)+2;
        @imagettftext($im, $fontsize, 0, $space['left']+($scale*$inf[0])+2,
        $fontheight1, $col_text, $font, $inf[2]);
    }
  }

    /* output the image */
	header("Content-Type: image/png; name=\"barcode.png\"");
	imagepng($im);

}

 
ean13_barcode($_GET['code'],2); 


?>
