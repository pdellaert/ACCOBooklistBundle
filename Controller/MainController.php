<?php

namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
	public function indexAction() {
		return $this->render('DellaertACCOBooklistBundle:Main:index.html.twig');
	}

	public function courseMaterialOverviewAction() {
		$request = $this->getRequest();
		$scid = -1;
		$fid = -1;
		$lid = -1;

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
				'required'=>true))
			->getForm();
		$results = array();
		$showResults = false;
		if( $request->getMethod() == 'POST' ) {
			$formData = $request->request->get('form');
			$scid = $formData['school'];
			$fid = $formData['faculty'];
			$lid = $formData['level'];

			if( !empty($scid)  && $fid > 0 && $lid > 0 ) {
				$showResults = true;
				$locale = $request->getLocale();

				$studies = APIUtility::getLiveStudiesByIdTitle($this->container,$locale,$scid,$fid,$lid);
				foreach($studies as $study) {
					$programs = APIUtility::getLiveProgramsByIdTitle($this->container,$locale,$scid,$study['id']);
					foreach($programs as $program) {
						$stages = APIUtility::getLiveStagesByIdTitle($this->container,$locale,$scid,$program['id']);
						foreach($stages as $stage) {
							switch($stage['id']) {
								case '1':
									$ftxt = '1';
									break;
								case '2':
									$ftxt = '2';
									break;
								case '3':
									$ftxt = '3';
									break;
								case '4':
									$ftxt = '4';
									break;
								case '5':
									$ftxt = '5';
									break;
								case '0':
								default:
									$ftxt = 'geen';
									break;
							}
							$courses = APIUtility::getLiveCoursesInLevel($this->container,$locale,$scid,$program['id'],$stage['id'],1);
							$programTxt = preg_replace('/\s+/',' ',$program['title'].'('.$program['studypoints'].' sp.)');
							foreach($courses as $course) {
								switch($course['mandatory']) {
									case 'J':
									case 'Y':
										$mtxt = 'verplicht';
										break;
									default:
										$mtxt = 'keuze';
										break;
								}
								switch($course['period']) {
									case '1':
										$ptxt = '1';
										break;
									case '2':
										$ptxt = '2';
										break;
									case '3':
									default:
										$ptxt = '1+2';
										break;
								}

								$courseDetails = APIUtility::getLiveCourseDetails($this->container,$course['original_language'],$scid,$course['course_id']);
								$courseMaterial = '';
								foreach( $courseDetails['teaching_activities'] as $teaching_activity ) {
									$courseMaterial .= strip_tags($teaching_activity['course_material']).' - ';
								}
								$courseMaterial = substr($courseMaterial, 0, -3);

								$line = array(
									'last_edit'		=>	data("d/m/Y"),
									'school'		=>	APIUtility::$schools[$scid][0],
									'program'		=>	$programTxt,
									'year'			=>	$ftxt,
									'period'			=>	$ptxt,
									'course'		=>	preg_replace('/\s+/',' ',$course['title']),
									'course_id'		=>	$course['course_id'],
									'mandatory'		=>	$mtxt,
									'material'		=>	$courseMaterial,
									'student_nr'	=> 	''
								);

								$teachers = $course['teachers'];
								if( count($teachers) == 0 ) {
									$line['teacher1_firstname'] = 'Niet';
									$line['teacher1_name'] = 'Toegewezen';
									$line['teacher1_email'] = '';
									$line['teacher1_phone'] = '';
									$line['teacher2_firstname'] = '';
									$line['teacher2_name'] = '';
									$line['teacher2_email'] = '';
									$line['teacher2_phone'] = '';
									$line['teacher3_firstname'] = '';
									$line['teacher3_name'] = '';
									$line['teacher3_email'] = '';
									$line['teacher3_phone'] = '';
								}

								if( count($teachers) > 0 ) {
									$line['teacher1_firstname'] = preg_replace('/\s+/',' ',$teachers[0]['firstname']);
									$line['teacher1_name'] = preg_replace('/\s+/',' ',$teachers[0]['lastname']);
									$line['teacher1_email'] = '';
									$line['teacher1_phone'] = '';
								}

								if( count($teachers) > 1 ) {
									$line['teacher2_firstname'] = preg_replace('/\s+/',' ',$teachers[1]['firstname']);
									$line['teacher2_name'] = preg_replace('/\s+/',' ',$teachers[1]['lastname']);
									$line['teacher2_email'] = '';
									$line['teacher2_phone'] = '';
								}

								if( count($teachers) > 2 ) {
									$line['teacher3_firstname'] = preg_replace('/\s+/',' ',$teachers[2]['firstname']);
									$line['teacher3_name'] = preg_replace('/\s+/',' ',$teachers[2]['lastname']);
									$line['teacher3_email'] = '';
									$line['teacher3_phone'] = '';
								}

								$results[] = $line;
							}
						}
					}
				}
			}
		}
		return $this->render('DellaertACCOBooklistBundle:Main:course_material_overview.html.twig',array('form'=>$form->createView(),'results'=>$results,'showResults'=>$showResults,'scid'=>$scid,'fid'=>$fid,'lid'=>$lid));
	}
}
