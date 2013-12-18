<?php
namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Dellaert\ACCOBooklistBundle\Utility\ACCOUtility;

class KULAPIController extends Controller {

	public function listSchoolsByIdTitleAction() {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Faculties
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/schools-id-title';
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

	public function listFacultiesByIdTitleAction($scid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Faculties
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/faculties-id-title/'.$scid;
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

	public function listLevelsByIdTitleAction($scid,$fid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Levels
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/levels-id-title/'.$scid.'/'.$fid;
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

	public function listStudiesByIdTitleAction($scid,$fid,$lid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Studies
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/studies-id-title/'.$scid.'/'.$fid.'/'.$lid;
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

	public function listProgramsByIdTitleAction($scid,$sid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Programs
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/programs-id-title/'.$scid.'/'.$sid;
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

	public function listStagesByIdTitleAction($scid,$pid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Stages
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/stages-id-title/'.$scid.'/'.$pid;
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

	public function listCoursesInLevelAction($scid,$pid,$phid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Courses
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/courses-in-level/'.$scid.'/'.$pid.'/'.$phid;
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

	public function listCoursesByGroupsInLevelAction($scid,$pid,$phid) {
		if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
			// Getting Courses
			$url = $this->container->getParameter('dellaert_acco_booklist.kulapi.base');
			$url .= '/'.$this->getRequest()->getLocale().'/courses-by-groups-in-level/'.$scid.'/'.$pid.'/'.$phid;
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