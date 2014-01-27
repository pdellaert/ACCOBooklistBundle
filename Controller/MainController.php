<?php

namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
	public function indexAction() {
		return $this->render('DellaertACCOBooklistBundle:Main:index.html.twig');
	}

	public function courseMaterialOverviewAction($locale) {
		$form = $this->createFormBuilder()
			->add('school','choice',array(
				'choices'=>array('-1'=>'Even geduld...'),
				'expanded'=>false,
				'multiple'=>false,
				'required'=>true))
			->add('faculty','choice',array(
				'choices'=>array('-1'=>'Even geduld...'),
				'expanded'=>false,
				'multiple'=>false,
				'required'=>true))
			->add('level','choice',array(
				'choices'=>array('-1'=>'Even geduld...'),
				'expanded'=>false,
				'multiple'=>false,
				'required'=>true));
		$results = array();
		$showResults = false;
		if( $request->getMethod() == 'POST' ) {
			// TODO: Do the generating stuff
		}
		return $this->render('DellaertACCOBooklistBundle:Main:course_material_overview.html.twig',array('locale'=>$locale,'form'=>$form->createView(),'results'=>$results,'showResults'=>$showResults));
	}
}
