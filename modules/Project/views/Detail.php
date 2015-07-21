<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_Detail_View extends Vtiger_Detail_View {
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('showRelatedRecords');
		$this->exposeMethod('showCharts');
		$this->exposeMethod('showGantt');
	}

	function showCharts(Vtiger_Request $request) {
	
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		$viewer = $this->getViewer($request);
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$data = $moduleModel->getTimeEmployee($recordId);
		$response = $moduleModel->getTimeProject($recordId);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('DATA', $data);
		$viewer->assign('DATA2', $response);
		$viewer->view('charts/ShowTimeProjectEmployees.tpl', $moduleName);
		$viewer->view('charts/ShowTimeProject.tpl', $moduleName);
	}
	function showGantt(Vtiger_Request $request) {
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		$viewer = $this->getViewer($request);
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$data = $moduleModel->getGanttProject($recordId);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('DATA', Zend_Json::encode($data));
		$viewer->view('gantt/GanttContents.tpl', $moduleName);
	}
	public function getHeaderCss(Vtiger_Request $request) {
		$headerCssInstances = parent::getHeaderCss($request);
		$cssFileNames = array(
			'~libraries/dhtmlxGantt/skins/dhtmlxgantt_broadway.css',
		);
		$cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
		$headerCssInstances = array_merge($headerCssInstances, $cssInstances);
		 return $headerCssInstances;
	}
	function getFooterScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = array(
			'~libraries/dhtmlxGantt/dhtmlxgantt.js',
			'~libraries/jquery/flot/jquery.flot.min.js',
			'~libraries/jquery/flot/jquery.flot.resize.js',
			'~libraries/jquery/flot/jquery.flot.stack.min.js',
		);
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
?>
