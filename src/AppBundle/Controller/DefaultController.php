<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invoice;
use AppBundle\Form\InvoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller {
  /**
   * @Route("/", name="homepage")
   */
  public function indexAction(Request $request) {
	// replace this example code with whatever you need
	return $this->render('default/index.html.twig', [
	  'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
	]);
  }

  /**
   * @Route("/results/{invoiceDateTimeResults}", name="results")
   */
  public function resultsAction(Request $request,$invoiceDateTimeResults) {

	return $this->render("AppBundle::results.html.twig", array('invoiceDateTimeResults'=>$invoiceDateTimeResults


	));

  }

  /**
   * @Route("/invoices", name="invoice")
   */
  public function invoiceSenderAction(Request $request) {

	$calc = null;
	$invoice = new Invoice();
	$form = $this->createForm(InvoiceType::class,$invoice);
	$form->handleRequest($request);



	$form = $this->createForm(InvoiceType::class);
	$form->handleRequest($request);

	if ($form->isSubmitted() && $form->isValid()) {
	  ///$jobTitle = $form->getData();
	  //var_dump($form->get("dateInvoice")->getData());

	  //$input = new \DateTime('2017-01-06 9:00:00');
	  $input = $form->get("dateInvoice")->getData();
	  $instance = new CheckHolidays();
	  $boolHolidays = $instance->checkHolidays($input);
	  $day = date('l', strtotime($input->format('Y-m-d H:i:s')));
	  switch ($day) {
		case 'Monday':
		  $calc = $this->traitmentMonday($boolHolidays, $input);
		  break;
		case 'Tuesday':
		  $calc = $this->traitementCentrale($boolHolidays, $input);
		  break;
		case 'Wednesday':
		  $calc = $this->traitementCentrale($boolHolidays, $input);
		  break;
		case 'Thuesday':
		  $calc = $this->traitementCentrale($boolHolidays, $input);
		  break;
		case 'Friday':
		  $calc = $this->traitmentFriday($boolHolidays, $input);
		  break;
		case 'Saterday':
		  $calc = $this->traitmentMonday($boolHolidays, $input);
		  break;
		case 'Sunday':
		  $calc = $this->traitmentMonday($boolHolidays, $input);
		  break;
	  }
	  //$em = $this->getDoctrine()->getManager();
	  //$em->persist($jobTitle);
	  //$em->flush();


	  //return new Response($email);
	  //return $this->redirectToRoute('results');

	  return $this->redirect($this->generateUrl('results', array(
	    'invoiceDateTimeResults'=>$calc->format("Y-m-d H:i:s"))));
	}

	return $this->render("AppBundle::invoiceSender.html.twig", array(
	  //"mondayMoringRes" => $calc->format("Y-m-d H:i:s"),
	  'form' => $form->createView()

	));
  }

  public function traitmentMonday($boolHolidays, $input) {

	if ($boolHolidays) {
	  $vharr = clone $input;
	  $vdate = date_create($vharr->format('Y-m-d'));
	  $vdateRes = $vdate->add(new \DateInterval('P0Y0M1DT14H30M0S'));
	  return $vdateRes;
	}
	else {
	  $cpm = new \DateTime(ConstantlyCool::C1330);
	  $then = clone $cpm;
	  $vhdep = clone $input;
	  $result = $then->format('Y-m-d H:i:s');

	  $time = date('H:i:s', strtotime($result));

	  if (strtotime($vhdep->format('H:i:s')) <= strtotime($time)) {
		$vdate = date_create($vhdep->format('Y-m-d'));
		$vh1 = $vdate->add(new \DateInterval('P0Y0M1DT9H30M0S'));
		//var_dump($vh1);
		return $vh1;
	  }
	  else {
		$vh1 = strtotime(ConstantlyCool::C17) - strtotime($vhdep->format('H:i'));
		$vh2 = -strtotime(ConstantlyCool::C400) - strtotime($vh1);
		$vh2Hours = date("H", $vh2);
		$vh2Minutes = date("i", $vh2);
		$vdate = date_create($vhdep->format('Y-m-d'));
		$vdate = $vdate->add(new \DateInterval('P0Y0M0DT9H0M0S'));
		$vhd = $vdate->add(new \DateInterval('P0Y0M0DT' . $vh2Hours . 'H' . $vh2Minutes . 'M0S'));
		return $vhd;
	  }
	}
  }

  public function traitementCentrale($boolHolidays, $input) {

	$vhdep = clone $input;
	$vharr = clone $input;
	$cpm = new \DateTime(ConstantlyCool::C12);
	$c400 = new \DateTime(ConstantlyCool::C400);
	$then = clone $cpm;
	$c1 = clone $c400;
	$result = $then->format('Y-m-d H:i:s');
	$c2 = $c1->format('Y-m-d H:i:s');
	$time = date('H:i:s', strtotime($result));
	$c3 = date('H:i:s', strtotime($c2));

	if ($boolHolidays) {

	  $vharr = clone $input;
	  $vdate = date_create($vharr->format('Y-m-d'));
	  $vdateRes = $vdate->add(new \DateInterval('P0Y0M1DT14H30M0S'));
	  return $vdateRes;
	}
	else {

	  $vdate = date_create($vhdep->format('Y-m-d'));
	  $vdate = $vdate->sub(new \DateInterval('P0Y0M1DT0H0M0S'));
	  $instance = new CheckHolidays();
	  $siJourFeriee = $instance->checkHolidays($vdate);
	  if ($siJourFeriee) {
		$vdate = date_create($vharr->format('Y-m-d'));
		$vdate = $vdate->add(new \DateInterval('P0Y0M0DT14H30M0S'));
		return $vdate;
	  }
	  else {
		if (strtotime($vhdep->format('H:i:s')) <= strtotime($time)) {
		  $vh1 = strtotime($time) - strtotime($vhdep->format('H:i'));
		  $vh2 = strtotime($c3) - $vh1;
		  $res = $vh1 + $vh2 + strtotime(ConstantlyCool::C130);
		  $resHours = date("H", $res);
		  $resMinutes = date("i", $res);
		  $vdate = $vhdep->add(new \DateInterval('P0Y0M0DT' . $resHours . 'H' . $resMinutes . 'M0S'));
		  var_dump(($vdate));

		}
		else {
		  $vhdep = date_create($vharr->format('Y-m-d'));
		  $vdate = $vhdep->add(new \DateInterval('P0Y0M1DT9H30M0S'));
		  return $vdate;
		}
	  }
	}
  }

  public function traitmentFriday($boolHolidays, $input) {
	$vharr = clone $input;
	$cpm = new \DateTime(ConstantlyCool::C12Bis);
	$result = $cpm->format('Y-m-d H:i:s');
	$time = date('H:i:s', strtotime($result));
	if ($boolHolidays) {
	  $vhdep = date_create($vharr->format('Y-m-d'));
	  $vdate = $vhdep->add(new \DateInterval('P0Y0M4DT9H30M0S'));
	  return $vdate;
	}
	else {
	  if (strtotime($vharr->format('H:i:s')) <= strtotime($time)) //if heureInput <= 12h00
	  {
		$vh1 = strtotime(ConstantlyCool::C12) - strtotime($vharr->format('H:i:s'));
		$vh2 = strtotime(ConstantlyCool::C400Bis) - $vh1;
		$vdate = date_create($vharr->format('Y-m-d'));
		$vdateRes = $vdate->add(new \DateInterval('P0Y0M3DT13H30M0S'));
		$vh2Hours = date("H", $vh2);
		$vh2Minutes = date("i", $vh2);
		$instance = new CheckHolidays();
		$siJourFeriee = $instance->checkHolidays($vdateRes);


		if ($siJourFeriee) {
		  $vdate = date_create($vdateRes->format('Y-m-d'));
		  $vdateR = $vdate->add(new \DateInterval('P0Y0M1DT9H0M0S'));
		  $vdatePlus = $vdateR->add(new \DateInterval('P0Y0M0DT' . $vh2Hours . 'H' . $vh2Minutes . 'M0S'));
		  if (strtotime($vharr->format('H:i:s')) <= strtotime($time)) {
			$vdatePlus = $vdateR->add(new \DateInterval('P0Y0M1DT1H30M0S'));
		  }

		  return $vdatePlus;


		}
		else {
		  $vdateR = $vdateRes->add(new \DateInterval('P0Y0M0DT' . $vh2Hours . 'H' . $vh2Minutes . 'M0S'));
		  //var_dump($vdateR);
		  return $vdateR;
		}
	  }
	  else {
		$vdate = date_create($vharr->format('Y-m-d'));
		$vdateRes = $vdate->add(new \DateInterval('P0Y0M3DT13H30M0S'));
		$this->traitmentMonday($boolHolidays = FALSE, $vdateRes);

		//var_dump($vdateRes);
		return $vdateRes;
	  }


	}
  }


}