<?php
/**
 * Created by PhpStorm.
 * User: levian
 * Date: 22/07/2016
 * Time: 2:15
 */

// src/AppBundle/Menu/MenuBuilder.php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class MenuBuilder
{
    private $factory;
    private $ac;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac)
    {
        $this->factory = $factory;
        $this->ac = $ac;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        $menu->addChild('Inicio', array('route' => 'homepage'));
        $menu->addChild('Descargas Públicas', array('route' => 'solicitud_index',array('page'=>1)));
        //$menu->addChild('Registro', array('route' => 'fos_user_registration_register'));

        if( $this->ac->isGranted('ROLE_ADMIN') ){
            $menu->addChild('Administrar', array('route' => 'easyadmin'));
        }
        if( $this->ac->isGranted('ROLE_USER') ){
            $menu->addChild('Salir', array('route' => 'fos_user_security_logout'));
        }
        return $menu;
    }
}