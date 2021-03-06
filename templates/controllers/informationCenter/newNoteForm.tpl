{**
 * templates/controllers/informationCenter/newNoteForm.tpl
 *
 * Copyright (c) 2003-2012 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Display submission file notes/note form in information center.
 *}

<script type="text/javascript">
	// Attach the Information Center handler.
	$(function() {ldelim}
		$('#newNoteForm').pkpHandler(
			'$.pkp.controllers.form.AjaxFormHandler',
			{ldelim}
				baseUrl: '{$baseUrl|escape:"javascript"}'
			{rdelim}
		);
	{rdelim});
</script>

<div id="newNoteContainer">
	<form class="pkp_form" id="newNoteForm" action="{url router=$smarty.const.ROUTE_COMPONENT op="saveNote" params=$linkParams}" method="post">
		{fbvFormSection title="informationCenter.composeNote" for="newNote"}
			{fbvElement type="textarea" id="newNote"}
		{/fbvFormSection}
		{fbvFormButtons hideCancel=true submitText=$submitNoteText}
	</form>
</div>
