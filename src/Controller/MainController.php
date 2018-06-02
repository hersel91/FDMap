<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MarkerType;
use App\Entity\Marker;

class MainController extends Controller
{
	/**
	 * @Route("/map", name="map")
	 */
	public function mainAction(Request $request)
	{
		$marker = new Marker;
		$form = $this->createForm(MarkerType::class, $marker);
		return $this->render("map.html.twig", array(
			"form" => $form->createView()
		));
	}
}