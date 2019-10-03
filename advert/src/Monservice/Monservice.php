<?php  
namespace App\Monservice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Monservice extends AbstractController
{
	
	public $age;
	public $locale;
	public $mailer;

	public function __Construct($age, $locale, \Swift_Mailer $mailer){
		$this->age = $age;
		$this->locale = $locale;
		$this->mailer = $mailer;
	}

	public function mailsend(){
		
		$message = (new \Swift_Message('Hello Email'))
		->setFrom('kevin.adorais@gmail.com')
		->setTo('kevin.adorais@gmail.com')
		->setBody(
			$this->renderView(
				'emails/registration.html.twig',
				['locale' => $this->locale]
			),
			'text/html'
		)
		;
		$this->mailer->send($message);

		return new Response('votre requete a bien été executer');
	}
}