<?php

/**
 * @file controllers/grid/admin/systemInfo/SystemInfoGridHandler.inc.php
 *
 * Copyright (c) 2000-2012 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class SystemInfoGridHandler
 * @ingroup controllers_grid_admin_systemInfo
 *
 * @brief Handle system info grid requests.
 */

import('lib.pkp.classes.controllers.grid.CategoryGridHandler');
import('controllers.grid.admin.systemInfo.SystemInfoGridCategoryRow');


class SystemInfoGridHandler extends CategoryGridHandler {

	var $_configData;

	/**
	 * Constructor
	 */
	function SystemInfoGridHandler() {
		parent::CategoryGridHandler();
		$this->addRoleAssignment(array(
			ROLE_ID_SITE_ADMIN),
			array('fetchGrid', 'fetchCategory', 'fetchRow')
		);
	}


	//
	// Implement template methods from PKPHandler.
	//
	/**
	 * @see PKPHandler::authorize()
	 */
	function authorize(&$request, $args, $roleAssignments) {
		import('lib.pkp.classes.security.authorization.PolicySet');
		$rolePolicy = new PolicySet(COMBINING_PERMIT_OVERRIDES);

		import('lib.pkp.classes.security.authorization.RoleBasedHandlerOperationPolicy');
		foreach($roleAssignments as $role => $operations) {
			$rolePolicy->addPolicy(new RoleBasedHandlerOperationPolicy($request, $role, $operations));
		}
		$this->addPolicy($rolePolicy);

		return parent::authorize($request, $args, $roleAssignments);
	}

	/**
	 * @see PKPHandler::initialize()
	 */
	function initialize(&$request) {
		parent::initialize($request);

		// Load user-related translations.
		AppLocale::requireComponents(
			LOCALE_COMPONENT_PKP_USER,
			LOCALE_COMPONENT_OMP_ADMIN,
			LOCALE_COMPONENT_OMP_MANAGER,
			LOCALE_COMPONENT_APPLICATION_COMMON
		);

		// Basic grid configuration.
		$this->setTitle('admin.systemConfiguration');
		$this->setInstructions('admin.systemConfigurationDescription');

		//
		// Grid columns.
		//
		import('controllers.grid.admin.systemInfo.InfoGridCellProvider');
		$infoGridCellProvider = new InfoGridCellProvider();

		// setting name.
		$this->addColumn(
			new GridColumn(
				'name',
				'admin.systemInfo.settingName',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider,
				array('width' => 20)
			)
		);

		// setting value.
		$this->addColumn(
			new GridColumn(
				'value',
				'admin.systemInfo.settingValue',
				null,
				'controllers/grid/gridCell.tpl',
				$infoGridCellProvider
			)
		);

		$this->_configData = Config::getData();
	}


	//
	// Implement template methods from CategoryGridHandler
	//
	/**
	 * @see CategoryGridHandler::getCategoryRowInstance()
	 */
	function &getCategoryRowInstance() {
		$row = new SystemInfoGridCategoryRow();
		return $row;
	}

	/**
	 * @see CategoryGridHandler::getCategoryData()
	 */
	function getCategoryData($configSection) {
		return $this->_configData[$configSection];
	}

	/**
	 * @see GridHandler::loadData
	 */
	function loadData(&$request, $filter) {
		return array_keys($this->_configData);
	}
}
?>
