<?php

namespace Acme\RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Acme\RestBundle\Entity\Organization;
use Acme\RestBundle\Entity\User;
use Acme\RestBundle\Form\UserType;

class UserController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Collection get action
     * @var Request $request
     * @var integer $organizationId Id of the entity's organization
     * @return array
     *
     * @Rest\View()
     */
    public function cgetAction(Request $request, $organizationId)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeRestBundle:User')->findBy(
            array(
                'organization' => $organizationId,
            )
        );

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Get action
     * @var integer $organizationId Id of the entity's organization
     * @var integer $id Id of the entity
     * @return array
     *
     * @Rest\View()
     */
    public function getAction($organizationId, $id)
    {
        $entity = $this->getEntity($organizationId, $id);

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Collection post action
     * @var Request $request
     * @var integer $organizationId Id of the entity's organization
     * @return View|array
     */
    public function cpostAction(Request $request, $organizationId)
    {
        $organization = $this->getOrganization($organizationId);
        $entity = new User();
        $entity->setOrganization($organization);
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectView(
                $this->generateUrl(
                    'get_organization_user',
                    array(
                        'organizationId' => $entity->getOrganization()->getId(),
                        'id' => $entity->getId()
                    )
                ),
                Codes::HTTP_CREATED
            );
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Put action
     * @var Request $request
     * @var integer $organizationId Id of the entity's organization
     * @var integer $id Id of the entity
     * @return View|array
     */
    public function putAction(Request $request, $organizationId, $id)
    {
        $entity = $this->getEntity($organizationId, $id);
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Delete action
     * @var integer $organizationId Id of the entity's organization
     * @var integer $id Id of the entity
     * @return View
     */
    public function deleteAction($organizationId, $id)
    {
        $entity = $this->getEntity($organizationId, $id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }

    /**
     * Get entity instance
     * @var integer $organizationId Id of the entity's organization
     * @var integer $id Id of the entity
     * @return User
     */
    protected function getEntity($organizationId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeRestBundle:User')->findOneBy(
            array(
                'id' => $id,
                'organization' => $organizationId,
            )
        );

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find user entity');
        }

        return $entity;
    }

    /**
     * Get organization instance
     * @var integer $id Id of the organization
     * @return Organization
     */
    protected function getOrganization($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeRestBundle:Organization')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find organization entity');
        }

        return $entity;
    }
}