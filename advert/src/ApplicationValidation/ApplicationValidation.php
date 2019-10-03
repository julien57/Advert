<?php  
namespace App\ApplicationValidation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Application;

class ApplicationValidation extends AbstractController
{
  public $mailer;

  public function __Construct(\Swift_Mailer $mailer){
    $this->mailer = $mailer;
  }

  public function postPersist(LifecycleEventArgs $args){

   $entity = $args->getObject();

   if(!$entity instanceof Application){
     return;
   }
   else{
    $mail = 'libano938@hotmail.fr';
    $message = (new \Swift_Message('Hello Email'))
    ->setFrom('kevin.adorais@gmail.com')
    ->setTo($mail)
    ->setBody($this->renderView(
      'emails/applicationValidation.html.twig',
      ['mail' => $mail]
    ),
    'text/html'
  )
    ;
    $this->mailer->send($message);
  }
}
}