<?php

/**
 * @file controllers/grid/files/attachment/EditorSelectableReviewAttachmentsGridHandler.inc.php
 *
 * Copyright (c) 2003-2012 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class EditorSelectableReviewAttachmentsGridHandler
 * @ingroup controllers_grid_files_attachments
 *
 * @brief Selectable review attachment grid requests (editor's perspective).
 */

import('controllers.grid.files.fileList.SelectableFileListGridHandler');

class EditorSelectableReviewAttachmentsGridHandler extends SelectableFileListGridHandler {
	/**
	 * Constructor
	 */
	function EditorSelectableReviewAttachmentsGridHandler() {
		import('controllers.grid.files.review.ReviewGridDataProvider');
		// Pass in null stageId to be set in initialize from request var.
		parent::SelectableFileListGridHandler(
			new ReviewGridDataProvider(MONOGRAPH_FILE_REVIEW_ATTACHMENT),
			null,
			FILE_GRID_DELETE|FILE_GRID_VIEW_NOTES
		);

		$this->addRoleAssignment(
			array(ROLE_ID_PRESS_MANAGER, ROLE_ID_SERIES_EDITOR, ROLE_ID_PRESS_ASSISTANT),
			array('fetchGrid', 'fetchRow')
		);

		// Set the grid title.
		$this->setTitle('grid.reviewAttachments.title');

		$this->setInstructions('editor.monograph.selectAttachments');
	}

	/**
	 * @see SelectableFileListGridHandler::getSelectName()
	 */
	function getSelectName() {
		return 'selectedAttachments';
	}
}

?>
