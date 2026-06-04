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

use Bcs\Model\SearchIndex;

class SearchIndexBackend
{

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
