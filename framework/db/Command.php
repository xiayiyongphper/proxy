<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace framework\db;

use framework\components\ToolsAbstract;

class Command extends \yii\db\Command
{
	/**
	 * @var Connection
	 */
	public $db;
	/**
	 * @var array pending parameters to be bound to the current PDO statement.
	 */
	private $_pendingParams = [];
	/**
	 * @var string the SQL statement that this command represents
	 */
	private $_sql;
	/**
	 * @var string name of the table, which schema, should be refreshed after command execution.
	 */
	private $_refreshTableName;

	public function prepare($forRead = null)
	{
		$this->db->check();//add by henry zxj prevent client working
		parent::prepare($forRead);
		//ToolsAbstract::log($this->getRawSql(),'sql.log');   //先注释，怕误上线
	}
}
