<?php
namespace app\classes;

use app\classes\Szak;

class Informatikus extends Szak
{

  //kotelezo szak
  protected $kotelezo = 'matematika';

  //kotelezo szint
  protected $szint = ['közép','emelt'];

  //valaszthato szak valamelyk kotelezoen a tetelek kozt kell legyen minimum egy vagy akar tobb is
  protected $kotelezo_valaszthatok = ['biológia','fizika','informatika','kémia'];

}
