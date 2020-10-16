<?php

function add_unique_value(&$array, $value) {
  $i = array_search($value, $array, true);
  if( !$i ) $array[] = $value;
}

$CHECK_ORA = '';
$Orari = array();
$Servizi = array();

$valorizzati = array();
$dafare = array();

$csv = file("data.txt");

$STARTORA = $CHECK_ORA = substr( (explode(';' ,$csv[0]))[0], -5 );

$Orari[] = $STARTORA;

foreach( $csv as $key=>$value) {
  $line = explode(';', $value);

  $ora = substr( $line[0], -5);
  $nome_servizio = $line[1];
  $valore = intval($line[2]);
  
  if( $ora !== $CHECK_ORA ) {
    $CHECK_ORA = $ora;
    $Orari[] = $ora;
    $nonvalorizzati = array_diff( array_keys($Servizi), $valorizzati );

    foreach($nonvalorizzati as $n) {
      $Servizi[$n][] = '-';
    }

    $valorizzati = array();
  }

  if( !array_key_exists($nome_servizio, $Servizi) ) {
    $Servizi[$nome_servizio] = array_fill(0, count($Orari)-1, '-');
  }
  array_push( $Servizi[$nome_servizio], $valore );
  add_unique_value($valorizzati, $nome_servizio);

  if( $valore >= 30 && !in_array($nome_servizio, $dafare) ) {
    $dafare[] = $nome_servizio;
  }

}

$nonvalorizzati = array_diff( array_keys($Servizi), $valorizzati );
foreach($nonvalorizzati as $n) {
  $Servizi[$n][] = '-';
}

//$Orari = array_merge(array($STARTORA), $Orari);

print_r($Servizi);