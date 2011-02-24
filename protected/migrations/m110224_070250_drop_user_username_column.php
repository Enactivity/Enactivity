<?php
/**
 * Drops the username column from the user table.  It's unnecessary 
 * for now, email is sufficient.
 * @author Ajay Sharma
 *
 */
class m110224_070250_drop_user_username_column extends CDbMigration
{
    public function up()
    {
    	$this->dropColumn('user', 'username');
    }

    /*
    public function down()
    {
    }
    */
}