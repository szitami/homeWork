<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use app\factories\SzakFactory;

final class szakTest extends TestCase
{

  //teszt elott a metodusokat publicra irni
  public function testInformatikusTeszt()
  {
    require_once (__DIR__ . '/homework_input.php');
    require_once (__DIR__ . '/../app/config/config.php');
    $inf = SzakFactory::create();
    $inf -> ErettsegiEredmeny($exampleData);
    $this->assertFalse($inf -> kotelezok_ellenorzes(['matematika','biológia']));
    $this->assertTrue($inf -> kotelezok_ellenorzes(['biológia','fizika','informatika','kémia','matematika','magyar nyelv és irodalom','történelem']));
  }

  //teszt elott a metodusokat publicra irni
  public function testAnglisztikaTeszt()
  {
    require_once (__DIR__ . '/homework_input.php');
    require_once (__DIR__ . '/../app/config/config.php');
    $ang = SzakFactory::create();
    $exampleData['valasztott-szak']['szak'] = 'Anglisztika';
    $ang -> ErettsegiEredmeny($exampleData);
    $this->assertFalse($ang -> kotelezok_ellenorzes(['matematika','biológia']));
    $this->assertTrue($ang -> kotelezok_ellenorzes(['matematika','magyar nyelv és irodalom','francia','német','olasz','orosz','spanyol','történelem','angol']));
  }

  //teszt elott a metodusokat publicra irni
  public function testTobbletPontokTeszt()
  {
    require_once (__DIR__ . '/homework_input.php');
    require_once (__DIR__ . '/../app/config/config.php');

    $inf = SzakFactory::create();
    $inf -> ErettsegiEredmeny($exampleData2);
    $this->assertSame((int)$inf -> tobblet_pontok_szamitas(68),68);
  }

}
