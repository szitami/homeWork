<?php

$conf = [
  'Programtervező informatikus' => [
    'kotelezo' => 'matematika',
    'tipus' => ['közép','emelt'],
    'valaszthato_kotelezo' => ['biológia','fizika','informatika','kémia']
  ],
  'Anglisztika' => [
    'kotelezo' => 'angol',
    'tipus' => ['emelt'],
    'valaszthato_kotelezo' => ['francia','német','olasz','orosz','spanyol','történelem']
  ]
];

define('config',$conf);
