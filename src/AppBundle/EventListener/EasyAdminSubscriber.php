<?php
/**
 * Created by PhpStorm.
 * User: levian
 * Date: 09/08/2016
 * Time: 3:01
 */

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use AppBundle\Entity\Descarga;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $slugger;

    public function __construct()
    {
        $this->slugger = 1;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.post_edit' => array('setCompletada'),
        );
    }

    public function setCompletada(GenericEvent $event)
    {
        $entity = $event->getSubject();
       // $request = $event->getArgument('config');

        if (!($entity instanceof Descarga)) {
            return;
        }


        $entity->setCompletada(true);


        $event['entity'] = $entity;
    }
}