<?php
namespace Dellaert\ACCOBooklistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dellaert\ACCOBooklistBundle\Utility\ACCOUtility;
use Dellaert\ACCOBooklistBundle\Entity\CommandType;
use Dellaert\ACCOBooklistBundle\Entity\ScheduledCommand;
use Symfony\Component\HttpFoundation\Response;

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
                    $school_title = $schools[$scid];
                    $faculty_title = '';
                    foreach( $faculties as $faculty ) {
                        if( $faculty['id'] == $fid ) {
                            $faculty_title = $faculty['title'];
                            break;
                        }
                    }
                    $level_title = '';
                    foreach( $levels as $level ) {
                        if( $level['id'] == $lid ) {
                            $level_title = $level['title'];
                            break;
                        }
                    }

                    $description = $school_title.' - '.$faculty_title.' - '.$level_title;
                    // Getting command type
                    $ct_repository = $this->getDoctrine()->getRepository('DellaertACCOBooklistBundle:CommandType');
                    $command_type = $ct_repository->findOneById($cid);

                    $scheduled_command = new ScheduledCommand();
                    $scheduled_command
                        ->setExecuted(false)
                        ->setDescription($description)
                        ->setSchool($scid)
                        ->setFaculty($fid)
                        ->setLevel($lid)
                        ->setCommandType($command_type)
                        ->setCreatedAt(new \DateTime());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($scheduled_command);
                    $em->flush();

                    $message = 'Je aanvraag is aangemaakt en zal uitgevoerd worden volgens de wachtrij.';

                } else {
                    $message = 'Invalid school, faculty or level!';
                }
            } else {
                $message = 'Invalid command type, school, faculty or level!';
            }
        }

        $queued_scheduled_commands = $sc_repository->findBy(array('executed'=>false), array('createdAt'=>'ASC'));
        $completed_scheduled_commands = $sc_repository->findBy(array('executed'=>true),array('finishedAt'=>'DESC'));

        return $this->render('DellaertACCOBooklistBundle:Main:command-schedule.html.twig',array('form'=>$form->createView(),'queued_scheduled_commands'=>$queued_scheduled_commands,'completed_scheduled_commands'=>$completed_scheduled_commands,'message'=>$message,'cid'=>$cid,'scid'=>$scid,'fid'=>$fid,'lid'=>$lid));
    }

    public function courseMaterialOverviewAction() {
        return $this->redirect($this->generateUrl('dellaert_acco_booklist_command_schedule'));
    }
}
