-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

CREATE TABLE `tl_catalog_fields` (
  `geocoords_coords` varchar(60) NOT NULL default ' ',
-- street for generating Coords
  `geocoords_streetfield` varchar(255) NOT NULL default '',
-- postal for generating Coords
  `geocoords_postalfield` varchar(255) NOT NULL default '',
-- city for generating Coords
  `geocoords_cityfield` varchar(255) NOT NULL default '',
-- country for generating Coords
  `geocoords_countryfield` varchar(255) NOT NULL default '',
) TYPE=MyISAM DEFAULT CHARSET=utf8;