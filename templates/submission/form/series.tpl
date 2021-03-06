{**
 * templates/submission/form/series.tpl
 *
 * Copyright (c) 2003-2012 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Include series placement for submissions.
 *}
{if count($seriesOptions) > 1} {* only display the series picker if there are series configured for this press *}
	{fbvFormSection label="series.series" description="submission.submit.placement.seriesDescription"}
		{fbvElement type="select" id="seriesId" from=$seriesOptions selected=$seriesId translate=false disabled=$readOnly}
	{/fbvFormSection}

	{fbvFormSection label="submission.submit.seriesPosition" description="submission.submit.placement.seriesPositionDescription"}
		{fbvElement type="text" id="seriesPosition" name="seriesPosition" value=$seriesPosition|escape maxlength="255" disabled=$readOnly}
	{/fbvFormSection}
{/if}