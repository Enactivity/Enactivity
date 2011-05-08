<?php

/*
 * DateTimeZoneBehavior
 * Automatically converts datetime fields to server time zone on saves 
 * and server times to user times on find.
 * 
 * @author: ajsharma
 * @version: 1.0
 * @requires: TimeZoneKeeper  
 */

class DateTimeZoneBehavior extends CActiveRecordBehavior
{
	public function beforeSave($event){
		
		//search for date/datetime columns. Convert it to pure PHP date format
		foreach($event->sender->tableSchema->columns as $columnName => $column){
						
			if ($column->dbType != 'datetime') continue;
									
			if (!strlen($event->sender->$columnName)){ 
				continue;
			}
			
			if($event->sender->$columnName == 'NOW()') {
				continue;
			}
			
			$event->sender->$columnName = 
				TimeZoneKeeper::userTimeToServerTime(
					$event->sender->$columnName
				);
		}
		return true;
	}
	
	public function afterFind($event){
					
		foreach($event->sender->tableSchema->columns as $columnName => $column){
						
			if ($column->dbType != 'datetime') continue;
			
			if (!strlen($event->sender->$columnName)){ 
				continue;
			}
			
			$event->sender->$columnName = 
				TimeZoneKeeper::serverTimeToUserTime(
					$event->sender->$columnName
				);
		}
		return true;
	}
}