<?php
namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dellaert\ACCOBooklistBundle\Utility\ACCOUtility;
use Dellaert\ACCOBooklistBundle\Entity\CommandType;
use Dellaert\ACCOBooklistBundle\Entity\ScheduledCommand;

class MainController extends Controller
{
    public function indexAction() {
        return $this->render('DellaertACCOBooklistBundle:Main:index.html.twig');
    }

    public function listCommandTypesByIdDescriptionAction() {
        if( ACCOUtility::verifyReferer($this->getRequest()->server->get('HTTP_REFERER'),$this->getRequest()->server->get('SERVER_NAME')) ) {
            // Getting CommandTypes
            $repository = $this->getDoctrine()->getRepository('DellaertACCOBooklistBundle:CommandType');
            $command_types = $repository->findAll();

            $data = array();
            foreach( $command_types as $command_type ) {
                $data[] = array('id'=>$command_type->getId(),'description'=>$command_type->getDescription());
            }

            // Returning CommandTypes
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
        } else {
            $response = new Response();
            $response->setStatusCode('403');
        }
        return $response;
    }

    public function commandScheduleAction() {
        $request = $this->getRequest();
        $cid = -1;
        $scid = -1;
        $fid = -1;
        $lid = -1;

        $form = $this->createFormBuilder()
            ->add('command_type','choice',array(
                'choices'=>array('-1'=>'Even geduld...'),
                'expanded'=>false,
                'multiple'=>false,
                'required'=>true))
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
        // Getting ScheduledCommands
        $sc_repository = $this->getDoctrine()->getRepository('DellaertACCOBooklistBundle:ScheduledCommand');
        $message = '';

        if( $request->getMethod() == 'POST' ) {
            $formData = $request->request->get('form');
            $cid = $formData['command_type'];
            $scid = $formData['school'];
            $fid = $formData['faculty'];
            $lid = $formData['level'];

            if( $cid > 0 && !empty($scid) && $fid > 0 && $lid > 0 ) {
                $locale = $request->getLocale();
                // Getting name set
                $schools = ACCOUtility::getLiveSchoolsbyIdTitle($this->container,$locale);
                $faculties = ACCOUtility::getLiveFacultiesByIdTitle($this->container,$locale,$scid);
                $levels = ACCOUtility::getLiveLevelsByIdTitle($this->container,$locale,$scid,$fid);

                if( !empty($schools) && !empty($faculties) && !empty($levels) ) {
                    $description = $schools[$scid].' - '.$faculties[$fid].' - '.$levels[$lid];
                    // Getting command type
                    $ct_repository = $this->getDoctrine()->getRepository('DellaertACCOBooklistBundle:CommandType');
                    $command_type = $ct_repository->FindById($cid);

                    $scheduled_command = new ScheduledCommand();
                    $scheduled_command
                        ->setExecuted(false)
                        ->setDescription($description)
                        ->setSchool($scid)
                        ->setFaculty($fid)
                        ->setLevel($lid)
                        ->setCommandType($command_type);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($scheduled_command);

                    $message = 'Je aanvraag is aangemaakt en zal uitgevoerd worden volgens de wachtrij.';

                } else {
                    $message = 'Invalid school, faculty or level!';
                }
            } else {
                $message = 'Invalid command type, school, faculty or level!';
            }
        }

        $queued_sheduled_commands = $sc_repository->findBy(array('executed'=>false), array('finishedAt'=>'DESC'));
        $completed_sheduled_commands = $sc_repository->findBy(array('executed'=>true),array('createdAt'=>'ASC'));

        return $this->render('DellaertACCOBooklistBundle:Main:command-schedule.html.twig',array('form'=>$form->createView(),'queued_sheduled_commands'=>$queued_sheduled_commands,'completed_sheduled_commands'=>$completed_sheduled_commands,'message'=>$message,'cid'=>$cid,'scid'=>$scid,'fid'=>$fid,'lid'=>$lid));
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

        // write a timer so no requests in a number of seconds are made...
        $now = time();
        $timerExceeded = false;
        $timerRemaining = 0;
        $timerMinwait = 15*60;
        if( file_exists('/tmp/course-material-overview-timer') ) {
            $lastExecution = file_get_contents('/tmp/course-material-overview-timer');
            $timerRemaining = $timerMinwait-($now-$lastExecution);
            if( $timerRemaining <= 0 && $request->getMethod() == 'POST' ) {
                $timerExceeded = true;
                file_put_contents('/tmp/course-material-overview-timer', $now);
            }
        } elseif( $request->getMethod() == 'POST' ) {
            $timerExceeded = true;
            $timerRemaining = 0;
            file_put_contents('/tmp/course-material-overview-timer', $now);
        }

        if( $request->getMethod() == 'POST' ) {
            $formData = $request->request->get('form');
            $scid = $formData['school'];
            $fid = $formData['faculty'];
            $lid = $formData['level'];

            if( $timerExceeded && !empty($scid) && $fid > 0 && $lid > 0 ) {
                $showResults = true;
                $locale = $request->getLocale();
                $schools = ACCOUtility::getLiveSchoolsbyIdTitle($this->container,$locale);

                $studies = ACCOUtility::getLiveStudiesByIdTitle($this->container,$locale,$scid,$fid,$lid);
                foreach($studies as $study) {
                    $programs = ACCOUtility::getLiveProgramsByIdTitle($this->container,$locale,$scid,$study['id']);
                    foreach($programs as $program) {
                        $stages = ACCOUtility::getLiveStagesByIdTitle($this->container,$locale,$scid,$program['id']);
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
                            $courses = ACCOUtility::getLiveCoursesInLevel($this->container,$locale,$scid,$program['id'],$stage['id'],1);
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

                                $courseDetails = ACCOUtility::getLiveCourseDetails($this->container,$locale,$scid,$course['course_id']);
                                $courseMaterial = '';
                                if( array_key_exists('teaching_activities',$courseDetails) && is_array($courseDetails['teaching_activities']) && count($courseDetails['teaching_activities']) > 0 ) {
                                    foreach( $courseDetails['teaching_activities'] as $teaching_activity ) {
                                        $courseMaterial .= strip_tags($teaching_activity['course_material']).' - ';
                                    }
                                }
                                $courseMaterial = substr($courseMaterial, 0, -3);

                                $line = array(
                                    'last_edit'     =>  date("d/m/Y"),
                                    'school'        =>  $schools[$scid],
                                    'program'       =>  $programTxt,
                                    'year'          =>  $ftxt,
                                    'period'            =>  $ptxt,
                                    'course'        =>  preg_replace('/\s+/',' ',$course['title']),
                                    'course_id'     =>  $course['course_id'],
                                    'mandatory'     =>  $mtxt,
                                    'material'      =>  $courseMaterial,
                                    'student_nr'    =>  ''
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
        return $this->render('DellaertACCOBooklistBundle:Main:course_material_overview.html.twig',array('form'=>$form->createView(),'results'=>$results,'showResults'=>$showResults,'scid'=>$scid,'fid'=>$fid,'lid'=>$lid,'timerRemaining'=>$timerRemaining));
    }
}
