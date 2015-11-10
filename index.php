<?php

/**
 * @file
 * An example usage of this library.
 */

require_once "vendor/autoload.php";

use SeismicMike\Etapestry\NuSoapClient;
use SeismicMike\Etapestry\Etapestry;

// A more adavanced/robust implementation will have ways of configuring these.
$endpoint = 'https://sna.etapestry.com/v2messaging/service?WSDL';
$username = 'ETAPESTRY USERNAME';
$password = 'ETAPESTRY PASSWORD';
$account_ref = 'ACCOUNT REFERENCE';

$nu_soap = new NuSoapClient($endpoint);
$etapestry = new Etapestry($nu_soap);
$etapestry->setUsername($username);
$etapestry->setPassword($password);
$etapestry->connect();

$account = $etapestry->getAccount($account_ref);

echo "<pre>";
print_r($account);
echo "</pre>";
