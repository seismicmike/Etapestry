<?php

/**
 * @file
 * An example usage of this library.
 */

require_once "vendor/autoload.php";

use SeismicMike\Etapestry\NuSoapClient;
use SeismicMike\Etapestry\Etapestry;

$endpoint = 'https://sna.etapestry.com/v2messaging/service?WSDL';
$username = 'mike.lewis';
$password = 'amandajoy';
$account_ref = '1232.0.8998928';

$nu_soap = new NuSoapClient($endpoint);
$etapestry = new Etapestry($nu_soap);
$etapestry->setUsername($username);
$etapestry->setPassword($password);
$etapestry->connect();

$account = $etapestry->getAccount($account_ref);

echo "<pre>";
print_r($account);
echo "</pre>";
