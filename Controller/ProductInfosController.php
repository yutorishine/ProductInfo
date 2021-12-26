<?php

/**
 * [Controller] 情報出力コントローラ
 *
 * @link			https://yutori-shine.com/
 * @package			ゆとり社員は考える
 */
App::uses('ConnectionManager', 'Model');

class ProductInfosController extends AppController
{
	/**
	 * コンポーネント
	 *
	 * @var     array
	 */
	public $components = array('BcAuth', 'Cookie', 'BcAuthConfigure', 'BcManager');

	/**
	 * ぱんくずナビ
	 *
	 * @var string
	 */
	public $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index'))
	);

	public $uses = ['Plugin'];

	/**
	 * 管理画面タイトル
	 *
	 * @var string
	 */
	public $adminTitle = 'プロダクト情報出力プラグイン';

	protected function getDBVersion($dbConfigKeyName = 'default', $dbConfig = null)
	{
		$db = ConnectionManager::getDataSource('default');
		$result = $db->query("SELECT version() as version");
		$version = $result[0][0]['version'];

		return $version;
	}

	protected function getDBCharactorSet($dbConfigKeyName = 'default', $dbConfig = null)
	{
		$db = ConnectionManager::getDataSource('default');
		$result = $db->query("show variables like 'collation_database';");
		$collationDatabase = $result['0']['session_variables']['Value'];

		return $collationDatabase;
	}

	public function admin_index()
	{
		$this->pageTitle = $this->adminTitle;

		$this->set('datas', $this->getExportData());
	}

	protected function getExportData()
	{
		$this->Plugin->cacheQueries = false;
		$pluginDatas = $this->Plugin->find('list', [
			'fields' => array('Plugin.name', 'Plugin.version'),
			'conditions' => [
				'Plugin.status'	=> true,
			]
		]);

		$db = ConnectionManager::getDataSource('default');
		list($type, $name) = explode('/', $db->config['datasource'], 2);
		$datasource = preg_replace('/^bc/', '', strtolower($name));

		$datas = [
			'cms'				=> ['name' => 'CMS', 'value' => 'baserCMS'],
			'version'			=> ['name' => 'Version', 'value' => $this->siteConfigs['version']],
			'phpVersion'		=> ['name' => 'PHP Version', 'value' => phpversion()],
			'db'				=> ['name' => 'DB', 'value' => $datasource . $this->getDBVersion()],
			'collation'			=> ['name' => 'DB 文字コード', 'value' => $this->getDBCharactorSet()],
		];

		foreach ($pluginDatas as $key => $pluginData) {
			$datas[$key] = ['name' => '【プラグイン】' . $key . ' バージョン', 'value' => $this->getPluginVersion($pluginDatas, $key)];
		}
		return $datas;
	}

	protected function getPluginVersion($pluginDatas, $pluginName)
	{
		$varsion = '-';
		if (isset($pluginDatas[$pluginName])) {
			$varsion = $pluginDatas[$pluginName];
		}

		return $varsion;
	}

	public function admin_download_csv()
	{
		$datas = $this->getExportData();
		$this->set('encoding', 'utf8');
		$this->set('datas', $datas);
	}

	public function admin_download_tsv()
	{
		$datas = $this->getExportData();
		$this->set('encoding', 'utf8');
		$this->set('datas', $datas);
	}
}
