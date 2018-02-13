<?php
/**
 * Created by PhpStorm.
 * User: zgr0629
 * Date: 19/3/2016
 * Time: 3:13 PM
 */


$client = new SoapClient('http://pms.lelai.com/api/soap?wsdl', array(
	'soap_version'=>SOAP_1_2,
));
$sessionId = $client->login('henryzhu', 'henryzhu@lightingever.com');
$result = $client->call($sessionId, 'catalog_product.info', array(array('product_type' => 'supermarket', 'lsin' => 'CS1000000017625')));
print_r($result);





/*
$soapClient = new SoapClient("http://pms.lelai.com/api/soap?wsdl");

// Prepare SoapHeader parameters
$sh_param = array(
	'Username'    =>    'henryzhu',
	'Password'    =>    'henryzhu@lightingever.com',
);
$headers = new SoapHeader('http://pms.lelai.com/api/soap?wsdl', 'Auth', $sh_param);

// Prepare Soap Client
$soapClient->__setSoapHeaders(array($headers));

// Setup the RemoteFunction parameters
$ap_param = array(
	'product_type' => 'supermarket',
	'lsin' => 'CS1000000017625',
);

$result = $soapClient->__call("catalog_product.info", array($ap_param));
print_r($result);

*/
