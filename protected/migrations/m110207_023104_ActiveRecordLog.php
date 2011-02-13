<?php

class m110207_023104_ActiveRecordLog extends CDbMigration
{
    public function up()
    {
    	$this->createTable(
    		'activerecordlog', 
    		array(
    			'id' => 'int(11) NOT NULL AUTO_INCREMENT',
    			'groupId' => 'int(11) NOT NULL',
    			'model' => 'VARCHAR(45) NOT NULL',
    			'modelId' => 'int(11) NULL',
    			'action' => 'VARCHAR(20) NULL',
				'modelAttribute' => 'VARCHAR(45) NULL',
				'userId' => 'int(11) NULL',
    			'created' => 'datetime DEFAULT NULL',
  				'modified' => 'datetime DEFAULT NULL',
    			'PRIMARY KEY(id)',
    		),
    		'ENGINE=InnoDB DEFAULT CHARSET=utf8'
    	);
    	
    	// ALTER TABLE  `activerecordlog` ADD INDEX (  `groupId` ) ;
    	$this->createIndex('groupId', 'activerecordlog', 'groupId');
    	$this->createIndex('userId', 'activerecordlog', 'userId');
    	
//    	ALTER TABLE  `activerecordlog` ADD FOREIGN KEY (  `groupId` ) REFERENCES  `poncla_yii`.`group` (
//		`id` ) ON DELETE CASCADE ON UPDATE CASCADE ;
		$this->addForeignKey('activerecordlog_ibfk_1', 'activerecordlog', 'groupId',
			'group', 'id', 'CASCADE', 'CASCADE');
		
		$this->addForeignKey('activerecordlog_ibfk_2', 'activerecordlog', 'userId',
			'user', 'id', 'CASCADE', 'CASCADE');
	}

    public function down()
    {
    	$this->dropTable('activerecordlog');
    }
}