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


namespace Bcs\Module;

use ZyppySearch\Module\ZyppySearch;

/**
 * Identical to the base Zyppy Search module, except results are ordered by the
 * "weight" assigned on the search index instead of pure relevance.
 *
 * Everything else (rendering, lazy loading, templates, images, news/teaser
 * handling) is inherited from ZyppySearch — only the result ordering is
 * overridden here, so future changes to the base module apply automatically.
 */
class ZyppyWeightedSearch extends ZyppySearch
{
	/**
	 * Sort the full result set by weight (global ordering), then slice the
	 * requested range so weighting stays correct across lazy-loaded batches.
	 *
	 * {@inheritdoc}
	 */
	protected function fetchResults($objResult, int $from, int $to, int $count): array
	{
		$arrAll = $objResult->getResults($count, 0);

		usort($arrAll, function($a, $b) {
			return $b['weight'] <=> $a['weight'];
		});

		// After weight sorting the first row is no longer the most relevant, so
		// take the maximum relevance across all results as the 100% denominator.
		$dblMaxRelevance = 0;

		foreach ($arrAll as $arrRow)
		{
			if (($arrRow['relevance'] ?? 0) > $dblMaxRelevance)
			{
				$dblMaxRelevance = $arrRow['relevance'];
			}
		}

		if ($dblMaxRelevance <= 0)
		{
			$dblMaxRelevance = 1;
		}

		return array(array_slice($arrAll, $from - 1, $to - $from + 1), $dblMaxRelevance);
	}
}
