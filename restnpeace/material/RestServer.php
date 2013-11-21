<?php

/**
 * This is an extensible class that allows you to create a RestServer using
 * PhpBURN.
 * 
 * It controls all requisitions and data handle for more information about its
 * usage please check it out on docs.phpburn.com
 * 
 * This RestServer was built thanks to some very interesting readings about:
 * 
 * http://restpatterns.org/RFC_2616_-_Hypertext_Transfer_Protocol_--_HTTP%2F%2F1.1
 * http://www.gen-x-design.com/archives/create-a-rest-api-with-php/
 * 
 * Thaks to them all.
 * 
 * @author Klederson Bueno
 * @version 1.0
 * @package PhpBURN
 * @subpackage RestServer
 */
abstract class RestServer extends Controller {

  private $body;
  private $contentType;
  private $inputFormat;
  private $method;
  public $defaultContentType = "application/json";
  public $defaultFormat = "json";
  public $allowedContentTypes = array(
      'application/json' => 'json',
      'multipart/form-data' => 'formdata',
      'application/x-www-form-urlencoded' => 'formdata',
      'text/plain' => 'formdata'
  );
  private $responseHeaders = [];

  public function __construct() {
    if (!$this->validateContentType()) {
      foreach($this->allowedContentTypes as $cType => $translator) {
        $accept .= $accept == NULL ? $cType : ", " . $cType;
      }
      $this->sendResponse(406, ['error' => "The given Content-type in your header is not allowed/supported please check-out this api documentation"], ['Accept', $accept]);
    }
    $this->setMethod($_SERVER['REQUEST_METHOD']);

    //the body data content will ALWAYS be outputed as a stdObject
    switch ($this->getMethod()) {
      case 'get':
        $this->body = RestTools::parseBody($_GET, 'array');
        break;
      default:
        $raw = empty(file_get_contents('php://input')) ? $_REQUEST : file_get_contents('php://input'); //now support strict form-data and x-www-form-urlencoded
        $this->body = RestTools::parseBody(file_get_contents('php://input'), $this->getInputFormat());
        break;
    }

    //Calls Controller
    parent::__construct();
  }

  /**
   * In order to have better dynamic funciton based on the method now we define the function
   * by putting their methods before the function's name, ex.: get_user, post_user, delete_user
   * and than we can call the different functions just by changing it's methods types.
   */
  public function __call($name, $arguments) {
    $methodName = sprintf("%s_%s",$name,$this->getMethod());
    $generic = sprintf("%s_generic",$name);

    if($this->getMethod() == "options") {
      $this->sendResponse(201,["message" => "PhpBURN"]);
    }

    if(method_exists($this, $methodName)) {
      return call_user_func_array([$this,$methodName], $arguments);
    }

    if(method_exists($this, $generic)) {
      return call_user_func_array([$this,$generic], $arguments);
    }

    $response['status'] = self::ERROR;
    $response['messages']['error'] = PhpBURN_Views::lazyTranslate('[!This method does not exists or cannot accept the given method!]: ' . $name . " : " . $this->getMethod());
    $httpStatus = 404;

    $this->sendResponse($httpStatus, $response, []);
  }

  /**
   * This retreives authentication data sent
   * 
   * @param Array $params
   * @param String $type
   * @return Array
   */
  public function getAuthData(array $params = array(), $type = 'basic') {
    //For now we support only BASIC AUTHENTICATION
    $data['username'] = $_SERVER['PHP_AUTH_USER'];
    $data['password'] = $_SERVER['PHP_AUTH_PW'];

    return $data;
  }

  public function sendResponse($status, array $content = array(), array $headers = array(), $contentType = "application/json") {
    $headers = array_merge($this->responseHeaders, $headers);

    $headers['X-Powered-by'] = "PhpBURN Framework";
    $headers['Access-Control-Allow-Origin'] = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "*";
    $headers['Access-Control-Allow-Headers'] = "origin, contenttype, content-type, accept, x-requested-with";
    $headers['Access-Control-Allow-Credentials'] = "true";
    //$headers['Content-Encoding'] ='gzip';
    
    $body = count($content) > 0 ? $content : [];

    $format = $this->allowedContentTypes[$contentType];

    RestTools::sendResponse($status, $body, $contentType, $format, $headers);
  }

  /**
   * This method verifies if client setted up a compatible content type for this
   * RestServer.
   * 
   * @return boolean 
   */
  protected function validateContentType() {
    //hook to accept all content types
    if (count($this->allowedContentTypes) == 0)
      return TRUE;

    //PHP 5.4 introduces HTTP_CONTENT_TYPE instead CONTENT_TYPE
    $requestType = empty($_SERVER['HTTP_CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : $_SERVER['HTTP_CONTENT_TYPE'];

    foreach ($this->allowedContentTypes as $contentType => $format) {
      if (preg_match("($contentType)", $requestType)) {
        $this->contentType = $contentType;
        $this->inputFormat = $format;
        return TRUE;
      } else if($requestType === NULL) {
        $this->contentType = $defaultContentType;
        $this->inputFormat = $defaultFormat;

        return TRUE;
      }
    }

    return FALSE;
  }

  public function setBody(stdClass $body) {
    $this->body = $body;
  }

  public function setMethod($method) {
    $this->method = !empty($method) ? strtolower($method) : 'get';
  }

  public function getAllowedContentTypes() {
    return $this->allowedContentTypes;
  }

  public function getBody() {
    return $this->body;
  }

  public function getMethod() {
    return $this->method;
  }

  public function getContentType() {
    return $this->contentType;
  }

  public function getInputFormat() {
    return $this->inputFormat;
  }

  public function setAllowedContentTypes(array $contentTypes) {
    $this->allowedContentTypes = $contentTypes;
  }

  public function getHeaders() {
    return $_SERVER;
  }

  public function getHeader($name) {
    return $_SERVER[$name];
  }

}

?>
