<?php

/**
 * @file
 * Provides the NuSoapClient class.
 */

namespace SeismicMike\Etapestry;

use SeismicMike\Etapestry\SoapClientBase;

/**
 * Implementation of the SoapClientInterface that uses the NuSoap library.
 */
class NuSoapClient extends SoapClientBase {
  public $apiConnection;
  public $lastMethod;
  public $lastArguments;
  public $lastResult;
  public $connected = FALSE;

  /**
   * Establish the connection object.
   *
   * @param string $endpoint
   *   The WSDL Endpoint to connect to.
   */
  public function __construct($endpoint) {
    $this->apiConnection = new \nusoap_client($endpoint, TRUE, FALSE, FALSE, FALSE, FALSE, 12000000, 12000000);
    return $this;
  }

  /**
   * Establish the connection to the remote API.
   *
   * @param string $username
   *   The username to use for authentication.
   * @param string $password
   *   The password to use for authentication.
   */
  public function connect($username, $password) {
    if ($this->isConnected()) {
      return TRUE;
    }

    try {
      $new_endpoint = $this->apiConnection->call('login', array($username, $password));
      $this->checkStatus();
    }
    catch (\Exception $e) {
      // @todo Handle the exception.
      throw $e;
    }

    if ("" != $new_endpoint) {
      $this->apiConnection->setEndpoint($new_endpoint);
      $this->connect($username, $password);
    }

    $this->connected = TRUE;
    return TRUE;
  }

  /**
   * Log out of the API and free up the memory from the soap client.
   */
  public function disconnect() {
    $this->logout();
    $this->connected = FALSE;
    return $this;
  }

  /**
   * Expose API functions for direct call.
   *
   * @param string $method
   *   The method being called.
   * @param array $arguments
   *   The arguments to be passed to the method.
   *
   * @return mixed
   *   The response returned by the method.
   */
  public function callMethod($method, array $arguments = array()) {
    $response = NULL;

    // Call the method.
    if (count($arguments) > 0) {
      $response = $this->apiConnection->call($method, $arguments);
    }
    else {
      $response = $this->apiConnection->call($method);
    }

    // Check for errors and throw an exception if there are any.
    $this->checkStatus();

    return $response;
  }

  /**
   * Check the status of the connection for errors.
   */
  public function checkStatus() {
    if (is_null($this->apiConnection) || !is_object($this->apiConnection) || 'nusoap_client' != get_class($this->apiConnection)) {
      return FALSE;
    }

    if ($this->apiConnection->fault || $this->apiConnection->getError()) {
      $debug = array(
        'message' => 'Unidentified Error.',
        // 'client' => $this->apiConnection,
        'lastMethod' => $this->getLastMethod(),
        'lastArguments' => $this->getLastArguments(),
        'lastResult' => $this->getLastResult(),
      );

      if (!$this->apiConnection->fault) {
        $debug['message'] = $this->apiConnection->getError();
        $debug['error'] = $this->apiConnection->getError();
        // $debug['debug'] = $this->apiConnection->getDebug();
      }
      else {
        $debug['message'] = $this->apiConnection->faultstring;
        $debug['fault_code'] = $this->apiConnection->faultcode;
        $debug['fault_string'] = $this->apiConnection->faultstring;
        // $debug['debug'] = $this->apiConnection->getDebug();
      }

      throw new \Exception("Etapestry Communication Error: " . $debug['message']);
    }

    return TRUE;
  }

}
