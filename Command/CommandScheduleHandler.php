<?php
namespace Dellaert\ACCOBooklistBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CommandScheduleHandler extends Command
{
    protected function configure()
    {
        $this
            ->setName('accobooklist:command-schedule-handler')
            ->setDescription('Parse the command queue.')
            ->addOption(
                'test',
                null,
                InputOption::VALUE_NONE,
                'Only test, do not execute the command'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Handling options
        $test = $input->getOption('test');

        // Container
        $container = $this->getApplication()->getKernel()->getContainer();

        // Base variables
        $filedir = $container->getParameter('dellaert_acco_booklist.data.basedir');

        // Gathering open ScheduledCommand
        $sc_repository = $container->get('doctrine')->getRepository('DellaertACCOBooklistBundle:ScheduledCommand');
        $queued_scheduled_commands = $sc_repository->findBy(array('executed'=>false), array('createdAt'=>'ASC'));

        if( !empty($queued_scheduled_commands) && is_array($queued_scheduled_commands) and count($queued_scheduled_commands) > 0 ) {
            $current_command = $queued_scheduled_commands[0];
            $current_command_type = $current_command->getCommandType();

            // Generating the filename
            $filename = date('Ymd_Hi_').preg_replace('/\s/','',trim($current_command->getDescription())).'.xlsx';

            // Generating the command
            $search = array('%SCID%','%FID%','%LID%','%FILE%');
            $replace = array($current_command->getSchool(), $current_command->getFaculty(), $current_command->getLevel(), $filedir.'/'.$filename);
            $current_execution_string = preg_replace($search, $replace, $current_command_type->getCommand());

            // Executing command (if not testing)
            $exec_result = 0;
            if($test) {
                $output->writeln(date('Y-m-d H:i:s').' - TEST: Running command '.$current_execution_string);
            } else {
                exec($current_execution_string,null,$exec_result);
            }

            if($exec_result == 0 ) {
                $current_command->setExecuted(true)
                    ->setResult($filename)
                    ->setFinishedAt(new \DateTime());

                $em = $container->get('doctrine')->getManager();
                $em->persist($current_command);
                $em->flush();
            }
        }
    }
}