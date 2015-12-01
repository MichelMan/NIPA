<?php
 
namespace NIPA\UserBundle\Command;
 
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Command\CreateUserCommand as BaseCommand;

use NIPA\UserBundle\Entity\Utilisateur; 
 
//class CreateUserCommand extends ContainerAwareCommand
class CreateUserCommand extends BaseCommand
{

	/**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('nipa:utilisateur:create')
            ->getDefinition()->addArguments(array(
                new InputArgument('identifiant', InputArgument::REQUIRED, 'The identifiant'),
                new InputArgument('prenom', InputArgument::REQUIRED, 'The prenom'),
				new InputArgument('nom', InputArgument::REQUIRED, 'The nom'),
				//new InputArgument('admin', InputArgument::REQUIRED, 'The admin'),
                //new InputArgument('createdAt', InputArgument::REQUIRED, 'The createdAt'),
                //new InputArgument('groupe', InputArgument::REQUIRED, 'The groupe')
            ))
        ;
        $this->setHelp(<<<EOT
// L'aide qui va bien
EOT
            );
    }
 
    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username   = $input->getArgument('username');
        $email      = $input->getArgument('email');
        $password   = $input->getArgument('password');
        $identifiant  = $input->getArgument('identifiant');
        $prenom   = $input->getArgument('prenom');
        $nom   = $input->getArgument('nom');
        $inactive   = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');
 
        /** @var \FOS\UserBundle\Model\UserManager $user_manager */
        $user_manager = $this->getContainer()->get('fos_user.user_manager');
 
        /** @var \NIPA\UserBundle\Entity\Utilisateur $utilisateur */
        $utilisateur = $user_manager->createUser();
        $utilisateur->setUsername($username);
        $utilisateur->setEmail($email);
        $utilisateur->setPlainPassword($password);
        $utilisateur->setEnabled((Boolean) !$inactive);
        $utilisateur->setSuperAdmin((Boolean) $superadmin);
        $utilisateur->setIdentifiant($identifiant);
        $utilisateur->setPrenom($prenom);
        $utilisateur->setNom($nom);
        $utilisateur->setAdmin(false);
 
        $user_manager->updateUser($utilisateur);
 
        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }

	/**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        parent::interact($input, $output);
        if (!$input->getArgument('identifiant')) {
            $identifiant = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a identifiant:',
                function($identifiant) {
                    if (empty($identifiant)) {
                        throw new \Exception('identifiant can not be empty');
                    }
 
                    return $identifiant;
                }
            );
            $input->setArgument('identifiant', $identifiant);
        }
        if (!$input->getArgument('prenom')) {
            $prenom = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a prenom:',
                function($prenom) {
                    if (empty($prenom)) {
                        throw new \Exception('prenom can not be empty');
                    }
 
                    return $prenom;
                }
            );
            $input->setArgument('prenom', $prenom);
        }
        if (!$input->getArgument('nom')) {
            $nom = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a nom:',
                function($nom) {
                    if (empty($nom)) {
                        throw new \Exception('nom can not be empty');
                    }
 
                    return $nom;
                }
            );
            $input->setArgument('nom', $nom);
        }
    }


}