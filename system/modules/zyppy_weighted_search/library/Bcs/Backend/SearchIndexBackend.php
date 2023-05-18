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

 
namespace Bcs\Backend;

use Contao\DataContainer;
use Bcs\Model\SearchIndex;

class SearchIndexBackend extends \Backend
{

	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(\Input::get('tid')))
		{
			$this->toggleVisibility(\Input::get('tid'), (\Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.\Image::getHtml($icon, $label).'</a> ';
	}
	
	
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_listing']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_listing']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_listing SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")->execute($intId);
		$this->log('A new version of record "tl_listing.id='.$intId.'" has been created'.$this->getParentEntries('tl_listing', $intId), __METHOD__, TL_GENERAL);
	}
	
	
	public function exportSearchIndex()
	{
		$objLocation = SearchIndex::findAll();
		$strDelimiter = ',';
	
		if ($objLocation) {
			$strFilename = "search_index" .(date('Y-m-d_Hi')) ."csv";
			$tmpFile = fopen('php://memory', 'w');
			
			$count = 0;
			while($objLocation->next()) {
				$row = $objLocation->row();
				if ($count == 0) {
					$arrColumns = array();
					foreach ($row as $key => $value) {
						$arrColumns[] = $key;
					}
					fputcsv($tmpFile, $arrColumns, $strDelimiter);
				}
				$count ++;
				fputcsv($tmpFile, $row, $strDelimiter);
			}
			
			fseek($tmpFile, 0);
			
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $strFilename . '";');
			fpassthru($tmpFile);
			exit();
		} else {
			return "Nothing to export";
		}
	}
	
}
