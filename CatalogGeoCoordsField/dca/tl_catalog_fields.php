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
 * This is the enhancement to the data container array for table tl_catalog_fields 
 * to allow the custom field type for geocoordsfield.
 *
 * PHP version 5
 * @copyright  Nikolas Runde 2011
 * @author     Nikolas Runde  <nikolas.runde@nrmedia.de> 
 * @package    CatalogGeoCoordsField
 * @license    GPL 
 * @filesource
 */


/**
 * Table tl_catalog_fields 
 */

// Palettes
$GLOBALS['TL_DCA']['tl_catalog_fields']['palettes']['geocoordsfield'] = 'name,description,colName,type,itemTable,geocoords_streetfield,geocoords_postalfield,geocoords_cityfield, geocoords_countryfield';

// register our fieldtype editor to the catalog Fields
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['itemTable'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['geoCoordsTable'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_catalog_fields', 'getTables'),
			'eval'                    => array('includeBlankOption'=>true, 'submitOnChange'=>true, 'mandatory'=>true)
		);
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['geocoords_streetfield'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['geocoords_streetfield'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_catalog_geocoords', 'getFields'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
		);

$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['geocoords_postalfield'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['geocoords_postalfield'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_catalog_geocoords', 'getFields'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
		);
		
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['geocoords_cityfield'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['geocoords_cityfield'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_catalog_geocoords', 'getFields'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
		);
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['geocoords_countryfield'] = array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['geocoords_countryfield'],
			'inputType'               => 'select',
			'options_callback'        => array('tl_catalog_geocoords', 'getFields'),
			'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50', 'mandatory'=>true),
		);
		
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['type']['options'][] = 'geocoordsfield';

class tl_catalog_geocoords extends Backend
{
	function getFields(DataContainer $dc)
	{
		$objTable = $this->Database->prepare("SELECT itemTable FROM tl_catalog_fields WHERE id=?")
			->limit(1)
			->execute($dc->id);
		 
		if ($objTable->numRows > 0 && $this->Database->tableExists($objTable->itemTable))
		{
			$fields = $this->Database->listFields($objTable->itemTable);
			return array_map(create_function('$x', 'return $x["name"];'), $fields);
		}
	}
}
?>