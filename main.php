<?php

function remove_value(&$array, $value) {
  $i = array_search($value, $array, true);
  if($i) array_splice($array, $i, 1);
}


$CHECK_ORA = '';
$Orari = array();
$Servizi = array();

$rimanenti = array();
$dafare = array();

$csv = file("data_copy.txt");

$CHECK_ORA = (explode(';' ,$csv[0]))[0];

foreach( $csv as $key=>$value) {
  $line = explode(';', $value);

  $ora = $line[0];
  $nome_servizio = $line[1];
  $valore = intval($line[2]);

  if( !array_key_exists($nome_servizio, $Servizi) ) {
    $Servizi[$nome_servizio] = array_fill(0, count($Orari), '-');
  }

  array_push( $Servizi[$nome_servizio], $valore );

  /*if( $valore >= 30 && !in_array($nome_servizio, $dafare) ) {
    $dafare[] = $nome_servizio;
  }*/

  
  if( $ora !== $CHECK_ORA ) {
    $CHECK_ORA = $ora;
    $Orari[] = $ora;
  }
}
print_r($Servizi);