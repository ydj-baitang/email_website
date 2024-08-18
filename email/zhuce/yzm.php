<?php
session_start();
header('Content-type: image/png');
$num=range(0,9);
$char=range("A","Z");
$yzm_array=array_merge($num,$char);

#从合并的数组里面随机取四个字符拼接在一起组成验证码
$yzm="";
$len=count($yzm_array);
for($i=0;$i<4;$i++){
    $yzm=$yzm.$yzm_array[rand(0,$len-1)];
}

// echo $yzm;
$imge_w=100;
$imge_h=25;

$img1=imagecreatetruecolor($imge_w,$imge_h);
$white=imagecolorallocate($img1,255,255,255);
$black=imagecolorallocate($img1,0,0,0);

imagefill($img1,0,0,$white);
$fontfile=realpath("times.ttf");

for($i=0;$i<100;$i++){
    imagesetpixel($img1,rand(0,$imge_w-1),rand(0,$imge_h-1),$black);
}

for($i=0;$i<2;$i++){
    imageline($img1,rand(0,$imge_w-1),rand(0,$imge_h-1),rand(0,$imge_w-1),rand(0,$imge_h-1),$black);#使用调出的黑色额料画线
}

for($i=0;$i<4;$i++){
    $x=$i*($imge_w/4)+8; #写字x轴的起始位置
    $y=rand(16,19);#写字y轴的起始位置
    $color=imagecolorallocate($img1,rand(0,180),rand(0,180),rand(0,180));#调出随机颜色的颜料
    $fontfile = realpath("times.ttf");
    imagettftext($img1,14,rand(-45,45),$x,$y,$color,$fontfile,$yzm[$i]);
}
imagepng($img1);
imagedestroy($img1);
$_SESSION['yzm'] = $yzm;