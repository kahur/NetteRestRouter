<?php

/**
 * Description of RestRoute
 *
 * @author Webvizitky, Softdream(Kamil Hurajt) <info@webvizitky.cz>,<info@softdream.net>
 * @copyright (c) 2013, Softdream, Webvizitky
 * @package library\KH
 * @category Routers
 * 
 */

namespace library\KH;

use Nette,
	Nette\Application,
	Nette\Utils\Strings,
	Nette\Application\Routers\Route;


class RestRoute extends Route {
    
    const METHOD_POST = 1;
    const METHOD_GET = 2;
    const METHOD_PUT = 3;
    const METHOD_DELETE = 4;
    
    const METHOD_POST_STR = 'POST';
    const METHOD_GET_STR = 'GET';
    const METHOD_PUT_STR = 'PUT';
    const METHOD_DELETE_STR = 'DELETE';
    
    /**
     * @var int request id method
     */
    private $method;
    
    private $createMethod = 'create';
    private $updateMethod = 'update';
    private $deleteMethod = 'delete';
    private $defaultMethod = 'default';
    
    
    public function match(Nette\Http\IRequest $httpRequest) {
	
		
	//set manualy request method or automaticaly
	if($this->isManualRequest()){
	    $this->setRequestMethod($this->flags);	    
	}
	else {
	    $requestMethod = $httpRequest->getMethod();
	    $requestMethodId = $this->getRequestIdByMethod($requestMethod);
	    $this->setRequestMethod($requestMethodId);
	}
	
	//prepare all
	
	//get presenter request
	$presenterRequest = parent::match($httpRequest);
//	var_dump($presenterRequest);
//	exit;
	if($presenterRequest){
	    //get presenter setting parrams
	    $presenterParams = $presenterRequest->getParameters();

	    $presenterParams['action'] = $this->getActionByRequest($this->getRequestMethod());

	    //replace presenter params
	    $presenterRequest->setParameters($presenterParams);

	    return $presenterRequest;
	}
	else {
	    //todo
	}
	
    }
    
    /**
     * Checking if request is set manualy
     * @return boolean return false if request is not set by manualy by flag or return request method ID
     */
    private function isManualRequest(){
	if($this->flags === self::METHOD_POST || $this->flags === self::METHOD_GET || $this->flags === self::METHOD_PUT || $this->flags === self::METHOD_DELETE){	    
	    return true;
	}
	
	return false;
    }
    
    
    /**
     * set request method
     * @param int $methodId Id of request method 
     * @todo Validation if method is valid.
     */
    public function setRequestMethod($methodId){
	$this->method = $methodId;
    }
    
    /**
     * Return request method ID
     * @return int request method id
     */
    public function getRequestMethod(){
	//if method is not set, set default method GET
	if(!$this->method){
	    $this->setRequestMethod(self::METHOD_GET);
	}
	
	return $this->method;
    }
    
    /**
     * @param int $requestMethodId request method id
     * @return String returns method name
     * @throws Nette\InvalidArgumentException
     */
    private function getMethodByRequestId($requestMethodId){
	$method = false;
	
	switch($requestMethodId){
	    case self::METHOD_POST :
		$method = self::METHOD_POST_STR;
	    break;
	    case self::METHOD_GET :
		$method = self::METHOD_GET_STR;
	    break;
	    case self::METHOD_PUT :
		$method = self::METHOD_PUT_STR;
	    break;
	    case self::METHOD_DELTE :
		$method = self::METHOD_DELETE_STR;
	    break;
	    default: break;	    
	}
	
	//throw exception if method is invalid
	if(!$method){
	    throw new Nette\InvalidArgumentException('Invalid/unsuported request method');
	}
	
	return $method;
    }
    
    /**
     * @param String $requestString request method type
     * @return int returns id of method
     * @throws Nette\InvalidArgumentException
     */
    private function getRequestIdByMethod($requestString){
	$requestMethod = Strings::upper($requestString);
	
	$requestId = 0;
	switch($requestMethod){
	    case self::METHOD_POST_STR :
		$requestId = self::METHOD_POST;
	    break;
	    case self::METHOD_GET_STR :
		$requestId = self::METHOD_GET;
	    break;
	    case self::METHOD_PUT_STR :
		$requestId = self::METHOD_PUT;
	    break;
	    case self::METHOD_DELETE_STR :
		$requestId = self::METHOD_DELETE;
	    break;
	    default: break;
	}
	
	if(!$requestId){
	    throw new Nette\InvalidArgumentException("Invalid/unsuported request method");
	}
	
	return $requestId;
    }
    
    public function getDefaultMethod(){
	return $this->defaultMethod;
    }
    
    public function getCreateMethod(){
	return $this->createMethod;
    }
    
    public function getUpdateMethod(){
	return $this->updateMethod;
    }
    
    public function getDeleteMethod(){
	return $this->deleteMethod;
    }
    
    public function setCreateMethod($methodName){
	$this->createMethod = $methodName;
    }
    
    public function setDefaultMethod($methodName){
	$this->defaultMethod = $methodName;
    }
    
    
    public function setUpdateMethod($methodName){
	$this->updateMethod = $methodName;
    }
    
    public function setDeleteMethod($methodName){
	$this->deleteMethod = $methodName;
    }
    
    
    /**
     * 
     */
    private function getActionByRequest($requestId){
	$action = (string)'';
	
	switch($requestId){
	    case self::METHOD_POST :
		$action = $this->getCreateMethod();
	    break;
	    case self::METHOD_GET : 
		$action = $this->getDefaultMethod();
	    break;
	    case self::METHOD_PUT :
		$action = $this->getUpdateMethod();
	    break;
	    case self::METHOD_DELETE :
		$action = $this->getDeleteMethod();
	    break;
	    default:
		$action = $this->getDefaultMethod();
	    break;
	}
	
	return $action;
	
    }
    
    
}