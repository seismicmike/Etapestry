<?php

/**
 * @file
 * Provides an abstract Base SoapClientInterface class.
 */

namespace SeismicMike\Etapestry;

// use SeismicMike\Etapestry\SoapClientInterface;

/**
 * SoapClient Base is a base class for Soap Client Interfaces.
 */
abstract class SoapClientBase implements SoapClientInterface {
  /**
   * The API Connection Object.
   *
   * @var mixed
   */
  public $apiConnection;

  /**
   * The last method that was called.
   *
   * @var string
   */
  public $lastMethod;

  /**
   * The last arguments that were passed.
   *
   * @var array
   */
  public $lastArguments;

  /**
   * The last response from the api.
   *
   * @var mixed
   */
  public $lastResult;

  /**
   * Whether the connection is active.
   *
   * @var bool
   */
  public $connected = FALSE;

  /**
   * Close out the connection before going out of scope.
   */
  public function __destruct() {
    $this->disconnect();
    $this->apiConnection = NULL;
    return $this;
  }

  /**
   * Use the __call() magic method.
   *
   * This method allows for direct calling of API methods.
   *
   * @param string $method
   *   The method being called.
   * @param array $arguments
   *   The arguments to be passed to the method.
   *
   * @return mixed
   *   The response returned by the method.
   *
   * @throws Exception
   *   Any API Error throws an Exception.
   */
  public function __call($method, array $arguments = array()) {
    $this->call($method, $arguments);
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
   *
   * @throws Exception
   *   Any API Error throws an Exception.
   */
  public function call($method, array $arguments = array()) {
    $this->lastMethod = $method;
    $this->lastArguments = $arguments;
    // Have the implementation actually call the method.
    $this->lastResponse = $this->callMethod($method, $arguments);
    return $this->lastResponse;
  }

  /**
   * Get the last method that was called.
   *
   * @return string
   *   The name of the last method called.
   */
  public function getLastMethod() {
    return $this->lastMethod;
  }

  /**
   * Get the last arguments that were passed.
   *
   * @return array
   *   The last arguments passed.
   */
  public function getLastArguments() {
    return $this->lastArguments;
  }

  /**
   * Get the last response that was returned.
   *
   * @return mixed
   *   The last response.
   */
  public function getLastResult() {
    return $this->lastResult;
  }

  /**
   * Return whether the connection is active.
   *
   * @return bool
   *   Whether the connection is active.
   */
  public function isConnected() {
    return $this->connected;
  }

  /**
   * Call an API Method.
   *
   * @param string $method
   *   The method to call.
   * @param array $arguments
   *   The arguments to pass.
   *
   * @return mixed
   *   The API Response.
   *
   * @throws Exception
   *   Throw an Exception for any API Error.
   */
  abstract public function callMethod($method, array $arguments = array());

}
