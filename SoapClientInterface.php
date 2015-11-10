<?php

/**
 * @file
 * Defines an interface for creating new Soap handlers for communication.
 *
 * This allows for dependency injection in case the system needs to be swapped
 * from NuSoap to PHP Soap or to some other soap method.
 */

/**
 * Defines the interface for Etapestry Soap Clients.
 */
interface SoapClientInterface {
  /**
   * Set up the connection.
   *
   * @param string $endpoint
   *   The URI of the API WSDL.
   */
  public function __construct($endpoint);

  /**
   * Close out the connection before going out of scope.
   */
  public function __destruct();

  /**
   * Handle calls to API methods.
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
   *   Throw an Exception for API Errors.
   */
  public function call($method, array $arguments = array());

  /**
   * Establish API Connection.
   *
   * @param string $username
   *   The username to use for authentication.
   * @param string $password
   *   The password to use for authentication.
   */
  public function connect($username, $password);

  /**
   * Close the API connection.
   */
  public function disconnect();

  /**
   * Check the status of the connection for errors.
   */
  public function checkStatus();

  /**
   * Get the last method that was called.
   *
   * @return string
   *   The name of the last method called.
   */
  public function getLastMethod();

  /**
   * Get the last arguments that were passed.
   *
   * @return array
   *   The last arguments passed.
   */
  public function getLastArguments();

  /**
   * Get the last response that was returned.
   *
   * @return mixed
   *   The last response.
   */
  public function getLastResult();

  /**
   * Return whether the connection is active.
   *
   * @return bool
   *   Whether the connection is active.
   */
  public function isConnected();

}
