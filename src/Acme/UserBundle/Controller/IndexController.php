<?php
/**
 * Created by PhpStorm.
 * User: guiguinox
 * Date: 18/02/14
 * Time: 14:26
 */

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use Acme\UserBundle\Form\Type\CompteType;
use Acme\UserBundle\Entity\Compte;


class IndexController extends Controller
{
    public function indexAction(){
        return $this->render('UserBundle:Index:index.html.twig');
    }

}