<?php  
namespace App\Personne;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Personne as pers;

class Personne extends AbstractController
{
	public $mailer;
	public $manager;

	public function __Construct( \Swift_Mailer $mailer, $manager){
		$this->mailer = $mailer;
		$this->manager = $manager;
	}

	public function mailsend(){

		$rep = $this->manager->getRepository(pers::class)->findBy(array('statut' => 'Premium'));

		foreach ($rep as $key => $value) {
			$mail = $value->getMail();
			$message = (new \Swift_Message('Hello Member Premium'))
			->setFrom('kevin.adorais@gmail.com')
			->setTo($value->getMail())
			->setBody(
				$this->renderView(
					'emails/registration.html.twig',
					['name' => $value->getName(), 'statut' => $value->getMail(), 'mail' => $mail]
				),
				'text/html'
			)
			;
			$this->mailer->send($message);
		}

		return new Response('votre requete a bien été executer');
	}
}