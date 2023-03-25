<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/tests//homework_input.php';
require_once  __DIR__ . '/app/config/config.php';

use app\factories\SzakFactory;

$info = SzakFactory::create();

$example1 = $info -> ErettsegiEredmeny($exampleData);
echo $info -> tobblet_pontok_szamitas(0);
$example2 = $info -> ErettsegiEredmeny($exampleData1);
$example3 = $info -> ErettsegiEredmeny($exampleData2);
$example4 = $info -> ErettsegiEredmeny($exampleData3);

?>
<b>Pelda 1</b><br><br>
<?php if($example1['sikeresseg']) : ?>
<b>Sikeres! Szak: <?=$example1['szak']?></b><br>
<span><?=$example1['uzenet']?></span>
<?php else : ?>
<b>Sikertelen! Szak: <?=$example1['szak']?></b><br>
<span><?=$example1['uzenet']?></span>
<?php endif ?>

<hr>

<b>Pelda 2</b><br><br>
<?php if($example2['sikeresseg']) : ?>
<b>Sikeres! Szak: <?=$example2['szak']?></b><br>
<span><?=$example2['uzenet']?></span>
<?php else : ?>
<b>Sikertelen! Szak: <?=$example2['szak']?></b><br>
<span><?=$example2['uzenet']?></span>
<?php endif ?>

<hr>

<b>Pelda 3</b><br><br>
<?php if($example3['sikeresseg']) : ?>
<b>Sikeres! Szak: <?=$example3['szak']?></b><br>
<span><?=$example3['uzenet']?></span>
<?php else : ?>
<b>Sikertelen! Szak: <?=$example3['szak']?></b><br>
<span><?=$example3['uzenet']?></span>
<?php endif ?>

<hr>

<b>Pelda 4</b><br><br>
<?php if($example4['sikeresseg']) : ?>
<b>Sikeres! Szak: <?=$example4['szak']?></b><br>
<span><?=$example4['uzenet']?></span>
<?php else : ?>
<b>Sikertelen! Szak: <?=$example4['szak']?></b><br>
<span><?=$example4['uzenet']?></span>
<?php endif ?>
