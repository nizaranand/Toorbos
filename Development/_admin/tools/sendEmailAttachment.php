<?php

require_once(".citadel.config.conf");

$file = $argv[1];
$emails = $argv[2];
$fromEmail = $argv[3];
$fromName = $argv[4];
$subject = $argv[5];
$emailBody = $argv[6];

if( is_file($file) ){
  $GLOBALS['__APPLICATION_']['utilities']->sendhtmlemailembedded($emails, $fromEmail, $fromName, $subject, $emailBody, $emailBody,array(),$file);
}


?>
