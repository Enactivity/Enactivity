<?php
/**
 * Tests for {@link User::encrypt}
 * @author ajsharma
 */
class TimeZoneKeeperServerTimeToTimeZone extends DbTestCase
{
	/**
	 * Test valid change to New York Time
	 */
	public function testServerTimeToNewYorkTime() {
		$dateTimeString = '2000-01-01 00:00:00'; // midnight new years
		$timeZone = 'America/New_York';
		
		$convertedDateTime = TimeZoneKeeper::serverTimeToTimeZone($dateTimeString, $timeZone);
		$convertedDateTimeString = $convertedDateTime->format('g:i:s');
		$this->assertEquals('3:00:00', $convertedDateTimeString, "DateTime was not converted properly from server time to new york time");
	}
	
	/**
	* Test
	*/
	public function testServerTimeToTimeNullTimeZone() {
		$dateTimeString = '2000-01-01 00:00:00'; // midnight new years
	
		try {
			$convertedDateTimeString = TimeZoneKeeper::serverTimeToTimeZone($dateTimeString, null);
		}
		catch(Exception $e) {
			return;
		}
		
		$this->fail("Was able to pass in null to serverTimeToTime");
	}
}