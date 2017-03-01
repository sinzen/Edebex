<?php
/**
 * Created by PhpStorm.
 * User: yassirhessane
 * Date: 26/02/17
 * Time: 20:51
 */

namespace AppBundle\Controller;


class CheckHolidays {

  function getHolidays($year = null)
  {
	if ($year === null)
	{
	  $year = intval(date('Y'));
	}

	$easterDate  = easter_date($year);
	$easterDay   = date('j', $easterDate);
	$easterMonth = date('n', $easterDate);
	$easterYear   = date('Y', $easterDate);

	$holidays = array(
	  // Dates fixes
	  mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
	  mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
	  mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
	  mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
	  mktime(0, 0, 0, 8,  15, $year),  // Assomption
	  mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
	  mktime(0, 0, 0, 11, 11, $year),  // Armistice
	  mktime(0, 0, 0, 12, 25, $year),  // Noel

	  // Dates variables
	  mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
	  mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
	  mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
	);

	sort($holidays);

	return $holidays;
  }


  public function checkHolidays($input)
  {
	$boolHolidays = false;
	foreach ($this->getHolidays(2017) as $a)
	{
	  if ($input->format("Y-m-d") == date("Y-m-d",$a))
	  {
		$boolHolidays = true;
	  }
	}
	return $boolHolidays;
  }



}