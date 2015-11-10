<?php

/**
 * @file
 * The Etapestry Class that abstracts interactions with the API.
 */

namespace SeismicMike\Etapestry;

/**
 * Establishes a connection to Etapestry.
 */
class Etapestry {
  /**
   * The username used for authentication.
   *
   * @var string
   */
  public $username;

  /**
   * The password used for authentication.
   *
   * @var string
   */
  public $password;

  /**
   * The URI of the WSDL file that defines this API connection.
   *
   * @var string
   */
  public $endpoint;

  /**
   * The Soap connection object.
   *
   * @var SoapClientInterface
   */
  public $soapClient;

  /**
   * Implements magic method __construct().
   *
   * @param SoapClientInterface $soap_client
   *   The SoapClient Interface that brokers the connection to Etapestry.
   */
  public function __construct(SoapClientInterface $soap_client) {
    $this->soapClient = $soap_client;
    return $this;
  }

  /**
   * Connect to Etapestry.
   *
   * @param string $username
   *   The Etapestry API Username.
   * @param string $password
   *   The Etapestry API Password.
   * @param string $endpoint
   *   The URI of the Etapestry API WSDL.
   *
   * @return bool
   *   Returns True if the connection succeeded.
   *
   * @throws Exception
   *   Any API Errors will be thrown as an Exception.
   */
  public function connect($username = 'mike.lewis', $password = 'amandajoy', $endpoint = 'https://sna.etapestry.com/v2messaging/service?WSDL') {

    $this->soapClient->connect($this->username, $this->password, $this->endpoint);
    $this->soapClient->checkStatus();

    return $this;
  }

  /**
   * Disconnect from Etapestry.
   */
  public function stopSession() {
    $this->soapClient->disconnect();
    return $this;
  }

  /**
   * Call an Etapestry API Method.
   *
   * @param string $method
   *   The method to call. Refer to the Etapestry API Documentation for what
   *   methods are available.
   * @param array $arguments
   *   Parameters to pass to the method. Refer to the Etapestry API
   *   Documentation for what parameters need to be included when calling
   *   methods.
   *
   * @return mixed
   *   The result of the method call. Varies depending on the method called.
   *   Refer to the Etapestry API Documentation for more details.
   *
   * @see https://www.blackbaudhq.com/files/etapestry/api/methods.html
   *
   * @throws Exception
   *   Any API Errors will be thrown as an Exception.
   */
  public function __call($method, array $arguments = array()) {
    return $this->soapClient->call($method, $arguments);
  }

  /**
   * Determine whether any API Errors have occurred.
   *
   * @throws Exception
   *   Any API Errors will be thrown as an Exception.
   *
   * @return bool
   *   Returns TRUE if no errors have occurred.
   */
  public function checkStatus() {
    // Call the SoapClientInterface's checkStatus method which will throw an
    // Exception if there is an error.
    $this->soapClient->checkStatus();

    // If no exception has been thrown, return TRUE.
    return TRUE;
  }

  /**
   * Determine whether a connection has been made.
   *
   * @return bool
   *   Returns TRUE if a connection has been established.
   */
  public function isConnected() {
    return $this->soapClient->isConnected();
  }

  /*
   * The obligatory Getter and Setter functions.
   */

  /**
   * Get the last called API method.
   *
   * @return string
   *   The name of the last method to be called.
   */
  public function getLastMethod() {
    return $this->soapClient->getLastMethod();
  }

  /**
   * Get the last parameters passed to an API method.
   *
   * @return array
   *   The last parameters passed to a method call.
   */
  public function getlastArguments() {
    return $this->soapClient->getLastArguments();

  }

  /**
   * Get the result of the last API method call.
   *
   * @return mixed
   *   The result of the last API method call. Specifics will vary depending
   *   on the method called.
   */
  public function getLastResult() {
    return $this->soapClient->getLastResult();

  }

  /**
   * Set the authentication credentials.
   *
   * @param string $username
   *   The username.
   * @param string $password
   *   The password.
   */
  public function setCredentials($username, $password) {
    $this->username = $username;
    $this->password = $password;
    return $this;
  }

  /**
   * Set the username.
   *
   * @param string $username
   *   The username.
   */
  public function setUsername($username) {
    $this->username = $username;
    return $this;
  }

  /**
   * Set the password.
   *
   * @param string $password
   *   The password.
   */
  public function setPassword($password) {
    $this->password = $password;
    return $this;
  }

  /**
   * Get the authentication credentials.
   *
   * @return array
   *   The credentials as an array in the format of:
   *   - username: The username
   *   - password: The password
   */
  public function getCredentials() {
    return array(
      'username' => $this->username,
      'password' => $this->password,
    );
  }

  /**
   * Get the username.
   *
   * @return string
   *   The username.
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * Get the password.
   *
   * @return string
   *   The password.
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * Retrieve an Account by Reference ID.
   *
   * Alias of getAccount()
   *
   * @param string $reference
   *   The Reference ID of the Account to Retrieve.
   *
   * @return array
   *   The requested Account Object.
   */
  public function getAccountByReference($reference) {
    return $this->getAccount($reference);
  }

  /**
   * Format a Date for Etapestry Compatability.
   *
   * @param string $date
   *   [Optional] Date to format. If omitted, the current timestamp will be
   *   used.
   *
   * @return string
   *   Etap compatible date.
   */
  public static function formatDate($date = NULL) {
    if (is_null($date) || empty($date)) {
      $date = REQUEST_TIME;
    }

    if (is_numeric($date)) {
      return date('c', $date);
    }

    return date('c', strtotime($date));
  }

}
