<?php
/**
 * Tests for User::PromoteToAdmin
 * @author ajsharma
 */
class UserPromoteToAdminTest extends DbTestCase
{
	/**
	 * Test  
	 */
	public function testPromoteToAdmin() {
		$user = UserFactory::insert();
		
		$this->assertTrue($user->promote(), "Promote admin returned false");
		$this->assertEquals(1, $user->isAdmin, "Promote to admin did not actually promote user");
	}
}