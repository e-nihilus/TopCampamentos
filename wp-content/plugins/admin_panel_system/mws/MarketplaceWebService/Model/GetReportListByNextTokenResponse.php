<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/******************************************************************************* 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */

/**
 *  @see MarketplaceWebService_Model
 */
require_once ('MarketplaceWebService/Model.php');  

    

/**
 * MarketplaceWebService_Model_GetReportListByNextTokenResponse
 * 
 * Properties:
 * <ul>
 * 
 * <li>GetReportListByNextTokenResult: MarketplaceWebService_Model_GetReportListByNextTokenResult</li>
 * <li>ResponseMetadata: MarketplaceWebService_Model_ResponseMetadata</li>
 *
 * </ul>
 */ 
class MarketplaceWebService_Model_GetReportListByNextTokenResponse extends MarketplaceWebService_Model
{


    /**
     * Construct new MarketplaceWebService_Model_GetReportListByNextTokenResponse
     * 
     * @param mixed $data DOMElement or Associative Array to construct from. 
     * 
     * Valid properties:
     * <ul>
     * 
     * <li>GetReportListByNextTokenResult: MarketplaceWebService_Model_GetReportListByNextTokenResult</li>
     * <li>ResponseMetadata: MarketplaceWebService_Model_ResponseMetadata</li>
     *
     * </ul>
     */
    public function __construct($data = null)
    {
        $this->fields = array (
        'GetReportListByNextTokenResult' => array('FieldValue' => null, 'FieldType' => 'MarketplaceWebService_Model_GetReportListByNextTokenResult'),
        'ResponseMetadata' => array('FieldValue' => null, 'FieldType' => 'MarketplaceWebService_Model_ResponseMetadata'),
        );
        parent::__construct($data);
    }

       
    /**
     * Construct MarketplaceWebService_Model_GetReportListByNextTokenResponse from XML string
     * 
     * @param string $xml XML string to construct from
     * @return MarketplaceWebService_Model_GetReportListByNextTokenResponse 
     */
    public static function fromXML($xml)
    {
        $dom = new DOMDocument();
        $dom->loadXML($xml);
        $xpath = new DOMXPath($dom);
    	$xpath->registerNamespace('a', 'http://mws.amazonaws.com/doc/2009-01-01/');
        $response = $xpath->query('//a:GetReportListByNextTokenResponse');
        if ($response->length == 1) {
            return new MarketplaceWebService_Model_GetReportListByNextTokenResponse(($response->item(0))); 
        } else {
            throw new Exception ("Unable to construct MarketplaceWebService_Model_GetReportListByNextTokenResponse from provided XML. 
                                  Make sure that GetReportListByNextTokenResponse is a root element");
        }
          
    }
    
    /**
     * Gets the value of the GetReportListByNextTokenResult.
     * 
     * @return GetReportListByNextTokenResult GetReportListByNextTokenResult
     */
    public function getGetReportListByNextTokenResult() 
    {
        return $this->fields['GetReportListByNextTokenResult']['FieldValue'];
    }

    /**
     * Sets the value of the GetReportListByNextTokenResult.
     * 
     * @param GetReportListByNextTokenResult GetReportListByNextTokenResult
     * @return void
     */
    public function setGetReportListByNextTokenResult($value) 
    {
        $this->fields['GetReportListByNextTokenResult']['FieldValue'] = $value;
        return;
    }

    /**
     * Sets the value of the GetReportListByNextTokenResult  and returns this instance
     * 
     * @param GetReportListByNextTokenResult $value GetReportListByNextTokenResult
     * @return MarketplaceWebService_Model_GetReportListByNextTokenResponse instance
     */
    public function withGetReportListByNextTokenResult($value)
    {
        $this->setGetReportListByNextTokenResult($value);
        return $this;
    }


    /**
     * Checks if GetReportListByNextTokenResult  is set
     * 
     * @return bool true if GetReportListByNextTokenResult property is set
     */
    public function isSetGetReportListByNextTokenResult()
    {
        return !is_null($this->fields['GetReportListByNextTokenResult']['FieldValue']);

    }

    /**
     * Gets the value of the ResponseMetadata.
     * 
     * @return ResponseMetadata ResponseMetadata
     */
    public function getResponseMetadata() 
    {
        return $this->fields['ResponseMetadata']['FieldValue'];
    }

    /**
     * Sets the value of the ResponseMetadata.
     * 
     * @param ResponseMetadata ResponseMetadata
     * @return void
     */
    public function setResponseMetadata($value) 
    {
        $this->fields['ResponseMetadata']['FieldValue'] = $value;
        return;
    }

    /**
     * Sets the value of the ResponseMetadata  and returns this instance
     * 
     * @param ResponseMetadata $value ResponseMetadata
     * @return MarketplaceWebService_Model_GetReportListByNextTokenResponse instance
     */
    public function withResponseMetadata($value)
    {
        $this->setResponseMetadata($value);
        return $this;
    }


    /**
     * Checks if ResponseMetadata  is set
     * 
     * @return bool true if ResponseMetadata property is set
     */
    public function isSetResponseMetadata()
    {
        return !is_null($this->fields['ResponseMetadata']['FieldValue']);

    }



    /**
     * XML Representation for this object
     * 
     * @return string XML for this object
     */
    public function toXML() 
    {
        $xml = "";
        $xml .= "<GetReportListByNextTokenResponse xmlns=\"http://mws.amazonaws.com/doc/2009-01-01/\">";
        $xml .= $this->toXMLFragment();
        $xml .= "</GetReportListByNextTokenResponse>";
        return $xml;
    }

    private $_responseHeaderMetadata = null;

    public function getResponseHeaderMetadata() {
      return $this->_responseHeaderMetadata;
    }

    public function setResponseHeaderMetadata($responseHeaderMetadata) {
      return $this->_responseHeaderMetadata = $responseHeaderMetadata;
    }
}
