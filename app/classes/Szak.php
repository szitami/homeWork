<?php
namespace app\classes;

use App\Interfaces\Kalkulator;

class Szak implements Kalkulator
{
  //szak
  protected $szak;

  //kotelezo szak
  protected $kotelezo;

  //kotelezo szint
  protected $szint;

  //valaszthato szak valamelyk kotelezoen a tetelek kozt kell legyen minimum egy vagy akar tobb is
  protected $kotelezo_valaszthatok;

  //kotelezo erettsegi tetelek
  protected $kotelezo_tetelek = ['magyar nyelv és irodalom','történelem','matematika'];

  //erettsegi eredmenyek
  protected $erettsegi_eredmenyek;
  protected $tobblet_pontok;


  public function ErettsegiEredmeny($data)
  {
    $this -> szak = $data['valasztott-szak']['szak'];
    $this -> kotelezo = config[$this -> szak]['kotelezo'];
    $this -> szint = config[$this -> szak]['tipus'];
    $this -> kotelezo_valaszthatok = config[$this -> szak]['valaszthato_kotelezo'];
    $this -> erettsegi_eredmenyek = $data['erettsegi-eredmenyek'];
    $this -> tobblet_pontok = $data['tobbletpontok'];
    return $this -> kotelezokEllenorzeseSzamitas();
  }

  //ellenorizzuk a ketelezo tantargyak megletet pontok szamitasa
  protected function kotelezokEllenorzeseSzamitas()
  {
    //alappont erteke
    $alap_pont = 0;
    //tobbletpontok erteke
    $tobblet_pontszamok = 0;
    //legnagyobb kotelezoen valasztott erteke
    $legnagyobb_valasztott = 0;
    //felvett tantargyak listaja az osszehasonlitashoz
    $felvett_tantargyak = [];

    foreach($this -> erettsegi_eredmenyek as $eredmeny)
    {
      //hozzaadas a felvett tantargyakhoz
      array_push($felvett_tantargyak,$eredmeny['nev']);
      $pontszam = (int) str_replace('%','',$eredmeny['eredmeny']);
      //emelt szint eseten tobbletpontok novelese
      if($eredmeny['tipus']=='emelt') $tobblet_pontszamok += 50;

      if(in_array($eredmeny['nev'],$this->kotelezo_tetelek))
      {
        //eredmeny ellenorzese
        if($pontszam<20){
          return $this -> nem_megfelelo_pontszam($eredmeny['nev'],$eredmeny['eredmeny']);
        }

      }

      if($eredmeny['nev'] == $this -> kotelezo)
      {
        //szint ellenorzese
        if(!in_array($eredmeny['tipus'],$this -> szint)){
          return [
            'sikeresseg' => false,
            'szak' => $this -> szak,
            'uzenet' => "hiba, nem lehetséges a pontszámítás a kotelezo tantargy nem megfelelo {$eredmeny['szint']}, {$this -> szint} helyett"
          ];
        }

        //eredmeny ellenorzese
        if($pontszam<20){
          return $this -> nem_megfelelo_pontszam($eredmeny['nev'],$eredmeny['eredmeny']);
        }

        $alap_pont = $pontszam;
      }

      if(in_array($eredmeny['nev'],$this->kotelezo_valaszthatok))
      {
        //eredmeny ellenorzese
        if($pontszam<20){
          return $this -> nem_megfelelo_pontszam($eredmeny['nev'],$eredmeny['eredmeny']);
        }

        if($pontszam > $legnagyobb_valasztott) $legnagyobb_valasztott = $pontszam;
      }
    }

    //teljesitett tantargyak ellenorzese megfelel-e a kriteriumoknak
    if(!$this -> kotelezok_ellenorzes($felvett_tantargyak))
    {
      return [
        'sikeresseg' => false,
        'szak' => $this -> szak,
        'uzenet' => "hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak hiánya miatt"
      ];
    }

    //osszalapszamitas
    $alappontokosszes = ($alap_pont + $legnagyobb_valasztott) * 2;

    //tobbletmeghatarozasa
    $tobblet_pontszamok = $this -> tobblet_pontok_szamitas($tobblet_pontszamok);

    if($tobblet_pontszamok>100) $tobblet_pontszamok = 100;

    //osszpontszamok
    $osszpontszam = $alappontokosszes + $tobblet_pontszamok;

    //sikeres vizsga eredmeny visszaterites
    return [
      'sikeresseg' => true,
      'szak' => $this -> szak,
      'uzenet' => "{$osszpontszam} ({$alappontokosszes} alappont + {$tobblet_pontszamok} többletpont)"
    ];
  }


  //nem megfelelo pontszam hibauzenet
  private function nem_megfelelo_pontszam($nev, $elert)
  {
    return [
      'sikeresseg' => false,
      'szak' => $this -> szak,
      'uzenet' => "hiba, nem lehetséges a pontszámítás a {$nev} tárgyból elért 20% alatti eredmény miatt"
    ];
  }


  //nyelv tobblet pontok szamitasa
  public function tobblet_pontok_szamitas($tobblet_pontszamok)
  {
    $tobblet = [];

    foreach($this -> tobblet_pontok as $tobblet_pont)
    {
      if($tobblet_pont['kategoria']=='Nyelvvizsga')
      {
        $ertek = ($tobblet_pont['tipus'] == 'B2' ? 28 : 40);
        if(array_key_exists($tobblet_pont['nyelv'],$tobblet) && $tobblet[$tobblet_pont['nyelv']]<$ertek) $tobblet[$tobblet_pont['nyelv']] = $ertek;
        else $tobblet[$tobblet_pont['nyelv']] = $ertek;
      }
    }

    foreach ($tobblet as $t)
    {
      $tobblet_pontszamok += (int)$t;
    }

    return $tobblet_pontszamok;
  }


  //kotelezo targyak megletenek ellenorzese
  public function kotelezok_ellenorzes($felvett_tantargyak)
  {
    if(!in_array($this->kotelezo,$felvett_tantargyak)) return false;
    if(!empty(array_diff($this -> kotelezo_tetelek,$felvett_tantargyak))) return false;
    if(empty(array_intersect($this -> kotelezo_valaszthatok,$felvett_tantargyak))) return false;
    return true;
  }

}
