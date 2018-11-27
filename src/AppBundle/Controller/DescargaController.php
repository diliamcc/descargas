<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Descarga;
use AppBundle\Form\DescargaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Descarga controller.
 *
 * @Route("/solicitudes")
 */
class DescargaController extends Controller
{
    /**
     * Lists all Descarga entities.
     *
     * @Route("/{page}", name="solicitud_index", defaults={"page" = 1}, requirements={"page" : "\d+"})
     * @Route("/pagina/{page}", name="solicitud_index_paginated", requirements={"page" : "\d+"})
     * @Method("GET")
     */
    public function indexAction(Request $request, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $descargas = $em->getRepository('AppBundle:Descarga')->getPublicas(1);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($descargas, $page, 5);
        //$pagination->setUsedRoute('solicitud_index_paginated');

        return $this->render('descarga/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new Descarga entity.
     *
     * @Route("/nueva-solicitud-de-descarga", name="solicitud_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $descarga = new Descarga();
        $form = $this->createForm('AppBundle\Form\DescargaType', $descarga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //guardando las descargas en la bd
            $descarga->setCompletada(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($descarga);
            $cadena = $descarga->getUrl() . '|' . $descarga->getUsuario() . '|' . $descarga->getCorreo() . '|' . $descarga->getNombre();
            $em->flush();

            //leyendo las descargas directas y manuales
            $descargasDirectas = $em->getRepository('AppBundle:Descarga')->getDirectas();
            $descargasManuales = $em->getRepository('AppBundle:Descarga')->getManuales();
            $arrayDirectas = $arrayManuales = array();

            //hidratando en arrays
            if ($descargasDirectas != null) {
                foreach ($descargasDirectas as $dd) {
                    array_push($arrayDirectas, $dd->getUrl() . ';' . $dd->getUsuario() . ';' . $dd->getCorreo(). ';' . $dd->getPrivada()."\n");
                }
            }

            if ($descargasManuales != null) {
                foreach ($descargasManuales as $dm) {
                    array_push($arrayManuales, $dm->getUrl() . ';' . $dm->getUsuario() . ';' . $dm->getCorreo(). ';' . $dm->getPrivada()."\n");
                }
            }

            //escribiendo los archivos
            $fs = $this->container->get('knp_gaufrette.filesystem_map')->get('flocal');

            if (!$fs->has('directas.csv')) {
                !$fs->createFile('directas.csv');
            }
            if (!$fs->has('manuales.csv')) {
                !$fs->createFile('manuales.csv');
            }
            $fs->write('directas.csv', $arrayDirectas, true);
            $fs->write('manuales.csv', $arrayManuales, true);


            return $this->redirectToRoute('solicitud_resumen', array('slug' => $descarga->getSlug()));

        }

        return $this->render('descarga/new.html.twig', array(
            'descarga' => $descarga,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Descarga entity.
     *
     * @Route("/{id}", name="solicitud_show")
     * @Method("GET")
     */
    public function showAction(Descarga $descarga)
    {
        $deleteForm = $this->createDeleteForm($descarga);

        return $this->render('descarga/show.html.twig', array(
            'descarga' => $descarga,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Descarga entity.
     *
     * @Route("/{slug}/resumen", name="solicitud_resumen")
     * @ParamConverter("descarga", options={"mapping": {"slug": "slug"}})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Descarga $descarga)
    {
        $deleteForm = $this->createDeleteForm($descarga);
        $editForm = $this->createForm('AppBundle\Form\DescargaType', $descarga);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($descarga);
            $em->flush();
            return $this->redirectToRoute('solicitud_resumen', array('id' => $descarga->getSlug()));

        }

        return $this->render('descarga/edit.html.twig', array(
            'descarga' => $descarga,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Descarga entity.
     *
     * @Route("/{id}", name="solicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Descarga $descarga)
    {
        $form = $this->createDeleteForm($descarga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($descarga);
            $em->flush();
        }

        return $this->redirectToRoute('solicitud_index');
    }

    /**
     * Creates a form to delete a Descarga entity.
     *
     * @param Descarga $descarga The Descarga entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Descarga $descarga)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitud_delete', array('id' => $descarga->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * @Route(path = "/admin/descarga/completar", name = "completar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function completarAction(Request $request)
    {
        // change the properties of the given entity and save the changes
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('AppBundle:Descarga');

        $id = $request->query->get('id');
        $entity = $repository->find($id);
        $entity->setCompletada(true);
        $em->flush();

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'edit',
            'id' => $id,
            'entity' => $request->query->get('entity'),
        ));

    }


}
