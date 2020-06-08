<?php

require 'Helyszin.php';

function beolvas(){
    $tomb=array();
    try {
        $fajl= file_get_contents('kerekpar.csv');
        $sorok= explode("\n", $fajl);
        for ($i = 0; $i < count($sorok); $i++) {
            if(strlen($sorok[$i])>3){
                $split= explode(";", $sorok[$i]);
                $o=new Helyszin($split[0],$split[1],$split[2],$split[3]);
                $tomb[]=$o;
            }
        }
    } catch (Exception $exc) {
            die('Hiba a fájl beolvasásakor. '+$exc);
        }
//        array_shift($tomb);//első sor miatt
        return $tomb;
}

function beolvasElsoSor(){
    $elsosor="";
    try {
        $fajl= file_get_contents('kerekpar.csv');
        $sorok= explode("\n", $fajl);
        $elsosor=$sorok[0];
    } catch (Exception $exc) {
            die('Hiba a fájl beolvasásakor. '+$exc);
    }
    return $elsosor;
}

$a= beolvas();
$elso= beolvasElsoSor();

echo '1. feladat: Teljesítve, a fájl beolvasva. <br>';
echo '2. feladat: A helyszínek száma: '.count($a).' db<br>';

$sum=0;
foreach ($a as $item) {
    $sum+=$item->getElso()+$item->getMasodik()+$item->getHarmadik();
}
echo '3. feladat: A versenysorozat teljes hossza: '.$sum.' km<br>';

echo '4. feladat: <br>';
$valasz="Ez a város nem szerepel a verseny állomásai között! <br>";
echo 'Adjon meg egy (balatoni) városnevet: ';
echo     '<form method="post" action="#">'
            . '<input type="text" name="varos">'
            . '<input type="submit" value="Küldés">'
        .'</form>';
if(isset($_POST['varos'])&&!empty($_POST['varos'])){
    $beker=$_POST['varos'];
    foreach ($a as $item) {
        if(strcmp(strtoupper($beker), strtoupper($item->getTelepules()))==0){
            $valasz=
                    "Az adott város versenyszakaszai: ".
                    $item->getElso()." km, ".
                    $item->getMasodik()." km és ".
                    $item->getHarmadik()." km.<br>";
        }
    }
}else{
    die();
}
echo $valasz;

echo '5. feladat: <br>';
$legh=0;
$leghT="";
foreach ($a as $item) {
    if(($item->getElso()+$item->getMasodik()+$item->getHarmadik())>$legh){
        $legh=$item->getElso()+$item->getMasodik()+$item->getHarmadik();
        $leghT=$item->getTelepules();
    }
}
echo 'A leghosszabb versenytávot adó település: '.$leghT.'<br>';
//6. feladat: 
$sum=0;
foreach ($a as $item) {
    $sum+=$item->getElso();
}
$atl=$sum/(double)count($a);
echo '6. feladat: Az első szakaszok átlagos hossza: '. number_format($atl,1,",","").' km<br>';
//7. feladat: 
$fajlba="";

$osszTav=0;
$dbTelepules=count($a);

foreach ($a as $item) {
    $osszTav+=$item->getElso()+$item->getMasodik()+$item->getHarmadik();
}
$akttav=0;
foreach ($a as $item) {
       $akttav=$item->getElso()+$item->getMasodik()+$item->getHarmadik();
       $szazalek=($akttav/(double)$osszTav)*100;
       $fajlba.=$item->getTelepules()."-".(number_format($szazalek,0,"",""))."%\n";
}

$myFile= fopen("statisztika.txt", "w");
fwrite($myFile, $fajlba);
echo '7. feladat: A fájl létrehozva. <br>';

//8. feladat: 
$osszv= beolvasElsoSor();
$atlv=$osszv/(double)count($a);

echo '8. feladat: Az átlagos versenyzőszám: '. number_format($atlv,0);
