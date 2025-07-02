<?php
	require_once 'config.php';

	function __list_event($despues, $antes, $log){
		$config = array (
		   'ServiceURL' => "https://mws-eu.amazonservices.com/Finances/2015-05-01",
		   'ProxyHost' => null,
		   'ProxyPort' => -1,
		   'ProxyUsername' => null,
		   'ProxyPassword' => null,
		   'MaxErrorRetry' => 3,
		);

	 	$service = new MWSFinancesService_Client(
	        AWS_ACCESS_KEY_ID,
	        AWS_SECRET_ACCESS_KEY,
	        APPLICATION_NAME,
	        APPLICATION_VERSION,
	        $config
    	);

		$request = new MWSFinancesService_Model_ListFinancialEventsRequest();
		$request->setSellerId(MERCHANT_ID);
		$request->setPostedAfter($despues);
		$request->setPostedBefore($antes);

		try {
	        $response = $service->ListFinancialEvents($request);
	        $dom = new DOMDocument();
	        $dom->loadXML($response->toXML());
	        $dom->preserveWhiteSpace = false;
	        $dom->formatOutput = true;

	        $operaciones = __process($dom);

	        $next = $dom;

	        while ($next) {
	        	$NextToken = $next->getElementsByTagName("NextToken");
		        if(count($NextToken) > 0){
		        	$token = $NextToken[0]->nodeValue;
		        	$next = __list_event_next($token, $log);
		        	if($next){
		        		$operacion_tem = __process($next);
		        		$operaciones = array("op" => array_merge($operaciones["op"], $operacion_tem["op"]), "dv" => array_merge($operaciones["dv"], $operacion_tem["dv"]));
		        	}elseif ($log) {
		        		echo ("Error de token: $token<br>");
		        	}
		        }else{
		        	$next = false;
		        }
	        }
	        

	        if($log){
		        echo ("Service Response<br>");
		        echo ("=============================================================================<br><pre>");
		        echo htmlspecialchars($dom->saveXML());
		        echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "</pre>");
		    }
		    
		    return $operaciones;
	    } catch (MarketplaceWebServiceOrders_Exception $ex) {
	     	if($log){
		        echo("Caught Exception: " . $ex->getMessage() . "<br>");
		        echo("Response Status Code: " . $ex->getStatusCode() . "<br>");
		        echo("Error Code: " . $ex->getErrorCode() . "<br>");
		        echo("Error Type: " . $ex->getErrorType() . "<br>");
		        echo("Request ID: " . $ex->getRequestId() . "<br>");
		        echo("XML: " . $ex->getXML() . "<br>");
		        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "<br>");
		    }
		    return false;
	     }
	}

	function __list_event_next($token, $log = false){
		$config = array (
		   'ServiceURL' => "https://mws-eu.amazonservices.com/Finances/2015-05-01",
		   'ProxyHost' => null,
		   'ProxyPort' => -1,
		   'ProxyUsername' => null,
		   'ProxyPassword' => null,
		   'MaxErrorRetry' => 3,
		);

	 	$service = new MWSFinancesService_Client(
	        AWS_ACCESS_KEY_ID,
	        AWS_SECRET_ACCESS_KEY,
	        APPLICATION_NAME,
	        APPLICATION_VERSION,
	        $config
    	);

		$request = new MWSFinancesService_Model_ListFinancialEventsByNextTokenRequest();
		$request->setSellerId(MERCHANT_ID);
		$request->setNextToken($token);

		try {
	        $response = $service->ListFinancialEventsByNextToken($request);
	        $dom = new DOMDocument();
		    $dom->loadXML($response->toXML());
		    $dom->preserveWhiteSpace = false;
		    $dom->formatOutput = true;
	        if($log){
		        echo ("Service Response<br>");
		        echo ("=============================================================================<br><pre>");
		        echo htmlspecialchars($dom->saveXML());
		        echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "</pre>");
		    }
		    return $dom;
	    } catch (MarketplaceWebServiceOrders_Exception $ex) {
	     	if($log){
		        echo("Caught Exception: " . $ex->getMessage() . "<br>");
		        echo("Response Status Code: " . $ex->getStatusCode() . "<br>");
		        echo("Error Code: " . $ex->getErrorCode() . "<br>");
		        echo("Error Type: " . $ex->getErrorType() . "<br>");
		        echo("Request ID: " . $ex->getRequestId() . "<br>");
		        echo("XML: " . $ex->getXML() . "<br>");
		        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "<br>");
		    }
		    return false;
	     }
	}

	function __process($dom){
		$ShipmentEvents = $dom->getElementsByTagName("ShipmentEventList")[0]->getElementsByTagName("ShipmentEvent");
		$RefundEvents = $dom->getElementsByTagName("RefundEventList")[0]->getElementsByTagName("ShipmentEvent");

		$_cambios = ["SEK" => 0.095, "GBP" => 1.15, "TRY" => 0.10, "EUR" => 1];

	    $operaciones = array();
	    $devoluciones = array();
	    $rt = array();
	    foreach ($ShipmentEvents as $key => $ShipmentEvent) {
	    	$ShipmentItems = $ShipmentEvent->getElementsByTagName("ShipmentItem");
	    	foreach ($ShipmentItems as $key => $ShipmentItem) {
		    	$operacion = array();
		    	$cant = $ShipmentItem->getElementsByTagName('QuantityShipped')[0]->nodeValue;
		    	$operacion['id'] = $ShipmentItem->getElementsByTagName('OrderItemId')[0]->nodeValue;
		    	$operacion['sku'] = $ShipmentItem->getElementsByTagName('SellerSKU')[0]->nodeValue;
		    	$operacion['cantidad'] = $ShipmentItem->getElementsByTagName('QuantityShipped')[0]->nodeValue;
		    	$operacion['orden'] = $ShipmentEvent->getElementsByTagName('AmazonOrderId')[0]->nodeValue;
		    	$operacion['tienda'] = $ShipmentEvent->getElementsByTagName('MarketplaceName')[0]->nodeValue;
		    	$operacion['fecha'] = $ShipmentEvent->getElementsByTagName('PostedDate')[0]->nodeValue;

		    	///Moneda
		    	$FeeComponents = $ShipmentItem->getElementsByTagName("FeeComponent");
		    	foreach ($FeeComponents as $key => $FeeComponent) {
		    		if($FeeComponent->getElementsByTagName("FeeType")[0]->nodeValue == 'Commission'){
		    			$X_cant = $FeeComponent->getElementsByTagName("FeeAmount")[0]->getElementsByTagName("CurrencyAmount")[0]->nodeValue;
		    			$M_cant = $_cambios[$FeeComponent->getElementsByTagName("FeeAmount")[0]->getElementsByTagName("CurrencyCode")[0]->nodeValue];
		    			$operacion['amz'] = $X_cant * $M_cant;
		    		}else if($FeeComponent->getElementsByTagName("FeeType")[0]->nodeValue == 'FBAPerUnitFulfillmentFee'){
		    			$X_cant = $FeeComponent->getElementsByTagName("FeeAmount")[0]->getElementsByTagName("CurrencyAmount")[0]->nodeValue;
		    			$M_cant = $_cambios[$FeeComponent->getElementsByTagName("FeeAmount")[0]->getElementsByTagName("CurrencyCode")[0]->nodeValue];
		    			$operacion['fba'] = $X_cant * $M_cant;
		    		}
		    	}

		    	$ChargeComponents = $ShipmentItem->getElementsByTagName("ChargeComponent");
		    	foreach ($ChargeComponents as $key => $ChargeComponent) {
		    		if($ChargeComponent->getElementsByTagName("ChargeType")[0]->nodeValue == 'Principal'){
		    			$X_cant = $ChargeComponent->getElementsByTagName("ChargeAmount")[0]->getElementsByTagName("CurrencyAmount")[0]->nodeValue;
		    			$M_cant = $_cambios[$ChargeComponent->getElementsByTagName("ChargeAmount")[0]->getElementsByTagName("CurrencyCode")[0]->nodeValue];
		    			$operacion['base'] = $X_cant * $M_cant;
		    		}else if($ChargeComponent->getElementsByTagName("ChargeType")[0]->nodeValue == 'Tax'){
		    			$X_cant = $ChargeComponent->getElementsByTagName("ChargeAmount")[0]->getElementsByTagName("CurrencyAmount")[0]->nodeValue;
		    			$M_cant = $_cambios[$ChargeComponent->getElementsByTagName("ChargeAmount")[0]->getElementsByTagName("CurrencyCode")[0]->nodeValue];
		    			$operacion['iva'] = $X_cant * $M_cant;
		    		}
		    	}
		    	$operaciones[] = $operacion;
		    }
	    }
	    $rt["op"] = $operaciones;
	    foreach ($RefundEvents as $key => $ShipmentEvent) {
	    	$ShipmentItems = $ShipmentEvent->getElementsByTagName("ShipmentItem");
	    	foreach ($ShipmentItems as $key => $ShipmentItem) {
	    		$operacion = array();
		    	$operacion['orden'] = $ShipmentEvent->getElementsByTagName('AmazonOrderId')[0]->nodeValue;
		    	$FeeComponents = $ShipmentItem->getElementsByTagName("FeeComponent");
		    	foreach ($FeeComponents as $key => $FeeComponent) {
		    		if($FeeComponent->getElementsByTagName("FeeType")[0]->nodeValue == 'RefundCommission'){
		    			$X_cant = $FeeComponent->getElementsByTagName("FeeAmount")[0]->getElementsByTagName("CurrencyAmount")[0]->nodeValue;
		    			$M_cant = $_cambios[$FeeComponent->getElementsByTagName("FeeAmount")[0]->getElementsByTagName("CurrencyCode")[0]->nodeValue];
		    			$operacion['amz'] = $X_cant * $M_cant;
		    		}
		    	}
		    	$devoluciones[] = $operacion;
	    	}
	    }
	    $rt["dv"] = $devoluciones;

		return $rt;
	}