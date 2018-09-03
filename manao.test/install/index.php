<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
Loc::loadMessages(__FILE__);
Class manao_test extends CModule {

	public function __construct(){

		if (file_exists(__DIR__."/version.php")){
			$arModuleVersion = array();

			include_once(__DIR__."/version.php");

			$this->MODULE_ID 		   = str_replace("_", ".", get_class($this));
			$this->MODULE_VERSION 	   = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
			$this->MODULE_NAME 		   = Loc::getMessage("MANAO_TEST_NAME");
			$this->MODULE_DESCRIPTION  = Loc::getMessage("MANAO_TEST_DESCRIPTION");
			$this->PARTNER_NAME 	   = Loc::getMessage("MANAO_TEST_PARTNER_NAME");

		}
	}

	function DoInstall(){

		global $APPLICATION;

		if (CheckVersion(ModuleManager::GetVersion("main"), "14.00.00")){

			$this->InstallFiles();
			$this->InstallDB();

			ModuleManager::registerModule($this->MODULE_ID);

			$this->InstallEvents();
		}else{

			$APPLICATION->ThrowException(Loc::getMessage("MANAO_TEST_ERROR_VERSION"));

		}

		$APPLICATION->IncludeAdminFile(Loc::getMessage("MANAO_TEST_INSTALL_TITLE")." \"".Loc::getMessage("MANAO_TEST_NAME")."\"", __DIR__."/step.php");

		return false;
		
	}

	function DoUninstall(){

		global $APPLICATION;

		$this->UnInstallFiles();
		$this->UnInstallDB();
		$this->UnInstallEvents();

		ModuleManager::unRegisterModule($this->MODULE_ID);

		$APPLICATION->IncludeAdminFile(Loc::getMessage("MANAO_TEST_UNINSTALL_TITLE")." \"".Loc::getMessage("MANAO_TEST_NAME")."\"",	__DIR__."/unstep.php");

	}

	public function InstallFiles(){}

	public function InstallDB(){}

	public function InstallEvents(){

		RegisterModuleDependences(
			"main",
			"OnProlog",
			$this->MODULE_ID,
			"Manao\Test\Main",
			"manaoTest"
		);

	}	

	public function UnInstallFiles(){}

	public function UnInstallDB(){}

	public function UnInstallEvents(){

		UnRegisterModuleDependences(
			"main",
			"OnProlog",
			$this->MODULE_ID,
			"Manao\Test\Main",
			"manaoTest"
		);

	}
}
?>