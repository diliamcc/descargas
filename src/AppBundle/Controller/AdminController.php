<?php
/**
 * Created by PhpStorm.
 * User: levian
 * Date: 29/07/2016
 * Time: 2:19
 */

namespace AppBundle\Controller;

#use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{


    public function completarAction()
    {
        // change the properties of the given entity and save the changes
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Descarga');

        $id = $this->request->query->get('id');
        $entity = $repository->find($id);
        $entity->setCompletada(true);
        $em->flush();

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'edit',
            'id' =>$id,
            'entity' => $this->request->query->get('entity'),
        ));

    }
}