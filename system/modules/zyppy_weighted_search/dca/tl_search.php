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

/* Table tl_location */
$GLOBALS['TL_DCA']['tl_search'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'url' => 'unique',
				'checksum,pid' => 'unique'
			)
		)
	),
	'list' => array
	(
	'sorting' => array
	(
	    'mode'                    => 2,
	    'fields'                  => array('weight'),
	    'flag'                    => 1,
	    'panelLayout'             => 'sort;filter;search,limit'
	),
	'label' => array
	(
	    'fields'                  => array('url', 'weight'),
	    'format'                  => '%s (%s)'
	),
	'global_operations' => array
	(
	    'export' => array
	    (
		'label'               => 'Export Search Index CSV',
		'href'                => 'key=exportSearchIndex',
		'icon'                => 'system/modules/contao_search_weight/assets/icons/file-export-icon-16.png'
	    ),
	    'all' => array
	    (
		'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
		'href'                => 'act=select',
		'class'               => 'header_edit_all',
		'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
	    )

	),
	'operations' => array
	(
	    'edit' => array
	    (
		'label'               => &$GLOBALS['TL_LANG']['tl_search']['edit'],
		'href'                => 'act=edit',
		'icon'                => 'edit.gif'
	    ),

	    'copy' => array
	    (
		'label'               => &$GLOBALS['TL_LANG']['tl_search']['copy'],
		'href'                => 'act=copy',
		'icon'                => 'copy.gif'
	    ),
	    'delete' => array
	    (
		'label'               => &$GLOBALS['TL_LANG']['tl_search']['delete'],
		'href'                => 'act=delete',
		'icon'                => 'delete.gif',
		'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
	    ),
	    'toggle' => array
		(
			'label'               => &$GLOBALS['TL_LANG']['tl_search']['toggle'],
			'icon'                => 'visible.gif',
			'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
			'button_callback'     => array('Bcs\Backend\SearchIndexBackend', 'toggleIcon')
		),
	    'show' => array
	    (
		'label'               => &$GLOBALS['TL_LANG']['tl_search']['show'],
		'href'                => 'act=show',
		'icon'                => 'show.gif'
	    )
	)
	),
	
	
	
	
	
	
	'palettes' => array
	(
		'default'         => '{search_index_legend},url,weight;'
	),
	
	
	
	
	
	
	
	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default 0"
		),
		'title' => array
		(
			'sql'                     => "text NULL"
		),
		'url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_search']['url'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "varchar(2048) COLLATE ascii_bin NOT NULL default ''"
		),
		'text' => array
		(
			'sql'                     => "mediumtext NULL"
		),
		'filesize' => array
		(
			'sql'                     => "double NOT NULL default 0" // see doctrine/dbal#1018
		),
		'checksum' => array
		(
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'protected' => array
		(
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'groups' => array
		(
			'sql'                     => "blob NULL"
		),
		'language' => array
		(
			'sql'                     => "varchar(5) NOT NULL default ''"
		),
		'vectorLength' => array
		(
			'sql'                     => "double NOT NULL default 0"
		),
		'meta' => array
		(
			'sql'                     => "mediumtext NULL"
		),
		'weight' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_search']['weight'],
			'inputType'               => 'text',
			'default'                 => '',
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
	)
);
