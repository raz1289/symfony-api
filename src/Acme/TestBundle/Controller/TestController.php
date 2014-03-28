<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function indexAction($name)
    {
        return $this->render(
            'AcmeTestBundle:Home:index.html.twig',
            array('name' => $name)
        );
    }
}
