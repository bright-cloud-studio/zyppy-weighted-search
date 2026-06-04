<?php

/**
 * Bright Cloud Studio's Zyppy Weighted Search
 *
 * Copyright (C) 2023 Bright Cloud Studio
 *
 * @package    bright-cloud-studio/zyppy-weighted-search
 * @link       https://www.brightcloudstudio.com/
 * @license    http://opensource.org/licenses/lgpl-3.0.html
**/

/* Back end modules */
$GLOBALS['BE_MOD']['content']['search_index'] = array(
	'tables' => array('tl_search'),
	'exportSearchIndex' => array('Bcs\Backend\SearchIndexBackend', 'exportSearchIndex')
);

/* Models */
$GLOBALS['TL_MODELS']['tl_search'] = 'Bcs\Model\SearchIndex';

/* Front end modules */
$GLOBALS['FE_MOD']['application']['zyppy_search'] = 'Bcs\Module\ZyppyWeightedSearch';
