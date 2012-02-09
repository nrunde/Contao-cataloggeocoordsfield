<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This is the catalog geocoordsfield extension file.
 *
 * PHP version 5
 * @copyright  Nikolas Runde 2011
 * @author     Nikolas Runde  <nikolas.runde@nrmedia.de> 
 * @package    CatalogGeoCoordsField
 * @license    GPL 
 * @filesource
 */
// New Comment
// class to manipulate the field info to be as we want it to be, to render it and to make editing possible.
class CatalogGeoCoordsField extends Backend {

	public function getCoords($varValue, DataContainer $dc)
	{	
		$type = 'geocoordsfield';
		
		$objFields = $this->Database->prepare("SELECT colname, geocoords_streetfield, geocoords_postalfield, geocoords_cityfield, geocoords_countryfield, itemTable FROM tl_catalog_fields WHERE type=?") 
				->limit(1)
				->execute($type);
		
		
		$streetfield = $objFields->geocoords_streetfield;
		$postalfield = $objFields->geocoords_postalfield;
		$cityfield = $objFields->geocoords_cityfield;
		$countryfield = $objFields->geocoords_countryfield;
		
		
		$street = $this->Input->post($streetfield);
		$postal = $this->Input->post($postalfield);
		$city = $this->Input->post($cityfield);
		$country = $this->Input->post($countryfield);
		
		
		$adress =  $street . ", " . $postal . " " . $city;

		$strGeoURL = 'http://maps.google.com/maps/api/geocode/xml?address='.str_replace(' ', '+', $adress).'&sensor=false'.($country ? '&region='.$country : '');
		if(function_exists("curl_init"))
		{
			$curl = curl_init();
			if($curl)
			{
				if(curl_setopt($curl, CURLOPT_URL, $strGeoURL) && curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1) && curl_setopt($curl, CURLOPT_HEADER, 0))
				{
					$curlVal = curl_exec($curl);
					curl_close($curl);
					$xml = new SimpleXMLElement($curlVal);
					if($xml)
					{
						$varValue = $xml->result->geometry->location->lat . ',' . $xml->result->geometry->location->lng;
					}
				}
			} else {
				$varValue = "No Coords";
			}
		}
		return $varValue;
	}
}
?>