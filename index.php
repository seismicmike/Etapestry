<?php

/**
 * @file
 * An example usage of this library.
 */

// Configure the NuSoap API.
// require_once '/path/to/nusoap.php';
// require_once 'NuSoapClient.php';
// require_once 'Etapestry.php';

require_once "vendor/autoload.php";

use Seismicmike\Etapestry;

$endpoint = 'https://sna.etapetry.com/v2messaging/service?WSDL';
$username = 'SET USERNAME HERE';
$password = 'SET PASSWORD HERE';
$account_ref = 'SET ACCOUNT REFERENCE HERE';

$nu_soap = new NuSoapClient($endpoint);
$etapestry = new Etapestry($nu_soap);
$etapestry->setUsername($username);
$etapestry->setPassword($password);
$etapestry->connect();

$account = $etapestry->getAccount($account_ref);

echo "<pre>";
print_r($account);
echo "</pre>";
