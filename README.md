# Etapestry
A Generic PHP library that can be used to communicate with Etapestry

This code snippet is not intended to be a fully robust library, though it will
function in a basic sense. Neither is it intended to be integrated with any
particular framework, though the code it is based on was written as part of a
Drupal 7 module.

The purpose of this snippet is to demonstrate my understanding of certain PHP
Principles, namely interfaces, abstract classes and magic methods.

This library is an abstraction of the SOAP API for Etapestry so as to allow
other modules to interact with Etapestry without having to know all the
details of how that works. Some knowledge of the basic data structures of
Etapestry would still be required, but the mechanics of how to communicate
with Etapestry are not.

The Beauty of this class is that I wanted a way to abstract the basic
mechanics of communicating with Etapestry without having to re-create the
connection logic every time, and without having to write fully formed classes
for each different object or scenario. I wanted flexibility that I could use ad
-hoc if I needed to, or could extend more robustly as needed.

So the key component here is the use of magic methods. I used __call() mainly
to pass any method calls to the Etapestry class that were not specifically
defined by the Etapestry class on to the SoapClient as an API call to
Etapestry.

Dependencies:
- PHP cURL
- An Etapestry Database
- PHP 5.3+
- Composer

Example Usage:

// Define and configure the credentials how you wish.
    $username = 'myusername';
    $password = 'mypassword';

// Also define the URL of the Etapestry WSDL file.
    $endpoint = 'https://sna.etapestry.com/v2messaging/service?WSDL';

// Instantiate a SoapClientInterface as defined in this library.
// The Etapestry class is agnostic of the specific SOAP library used. I use
// NuSoap as per Etapetsry's recommendations. If you also use NuSoap, make
// sure to use version 0.9.5). You could also use the PHP built-in SOAP
// library if you wish, though I have not written a SoapClientInterface that
// uses it.
    $client = new NuSoapClient($endpoint);

// This class
    $etapestry = new Etapestry($client);
    $etapestry->setUsername($username);
    $etapestry->setPassword($password);
    $etapestry->connect();

// Download an Account:
    $account = $etapestry->getAccount('123.1.123124');

// You'll notice that the Etapestry class does not define a getAccount method,
but this still downloads the account (provided that reference is a valid one.)

Any API method may be used this way. I do have other classes that were coded
to abstract the construction of new records that are being added to Etapestry,
such as a User Defined Field wrapper that makes it easier to actually set UDFs
and an Account class that abstracts the duplicate checking so that it is more
automatic. Those and others have not been included in this snippet for the
sake of time and simplicity, but I may be able to make them available as
needed.
