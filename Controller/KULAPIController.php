<?php
namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Dellaert\ACCOBooklistBundle\Utility\ACCOUtility;

class KULAPIController extends Controller {

	public function listFacultiesByIdTitleAction() {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Faculties
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/faculties-id-title';
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}



			// Returning faculties
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
	    return $response;
	}

	public function listLevelsByIdTitleAction($fid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Levels
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/levels-id-title/'.$fid;
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}

			// Returning levels
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
		return $response;
	}

	public function listStudiesByIdTitleAction($fid,$lid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Studies
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/studies-id-title/'.$fid.'/'.$lid;
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}

			// Returning studies
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
		return $response;
	}

	public function listProgramsByIdTitleAction($sid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Programs
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/programs-id-title/'.$sid;
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}

			// Returning programs
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
		return $response;
	}

	public function listStagesByIdTitleAction($pid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Stages
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/stages-id-title/'.$pid;
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}

			// Returning stages
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
		return $response;
	}

	public function listCoursesInLevelAction($pid,$phid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Courses
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/courses-in-level/'.$pid.'/'.$phid;
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}

			// Returning Courses
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
		return $response;
	}

	public function listCoursesByGroupsInLevelAction($pid,$phid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Courses
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/courses-by-groups-in-level/'.$pid.'/'.$phid;
			$data = file_get_contents($url);

			if( $data === FALSE ) {
				$data = '';
			}

			// Returning Courses
			$response = new Response($data);
			$response->headers->set('Content-Type', 'application/json');
    	} else {
			$response = new Response();
    		$response->setStatusCode('403');
    	}
		return $response;
	}
}