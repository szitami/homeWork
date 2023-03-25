<?php

namespace app\classes;

use app\classes\Szak;

class Anglisztika extends Szak
{
  //kotelezo szak
  protected $kotelezo = 'angol';

  //kotelezo szint
  protected $szint = ['emelt'];

  //valaszthato szak valamelyk kotelezoen a tetelek kozt kell legyen minimum egy vagy akar tobb is
  protected $kotelezo_valaszthatok = ['francia','német','olasz','orosz','spanyol','történelem'];

}
