<?php

namespace Acme\ApiBundle\Controller;

use Acme\ApiBundle\Entity\Truc;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;


class TrucRestController extends FOSRestController
{
    /**
     * @param Truc $truc
     * @return Response
     */
    public function getTrucAction(Truc $truc)
    {
        $view = $this->view($truc);
        return $this->handleView($view);
    }

    /**
     * @param Truc $truc
     * @return Response
     */
    public function deleteTrucAction(Truc $truc)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->remove($truc);
        $em->flush();

        // return {} to avoid Response::HTTP_NO_CONTENT
        $view = $this->view('{}', Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function postTrucAction(Request $request)
    {
        $data = $request->request->all();

        // Controle champ obligatoires
        $filters = array(
            'nom' => array("flags" => FILTER_REQUIRE_SCALAR)
        );
        $input = filter_var_array($data, $filters);
        if (!$input["nom"]) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, '');
        }

        // POST
        // Création nouvelle entité
        $truc = new Truc();
        $truc->setNom($input['nom']);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($truc);
        $em->flush();

        // return something to avoid Response::HTTP_NO_CONTENT
        $view = $this->view(
            array('id' => $truc->getId()),
            Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Truc $truc
     * @return Response
     */
    public function putTrucAction(Request $request, Truc $truc)
    {
        $data = $request->request->all();

        // Controle champ obligatoires
        $filters = array(
            'nom' => array("flags" => FILTER_REQUIRE_SCALAR)
        );
        $input = filter_var_array($data, $filters);
        if (!$input["nom"]) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, '');
        }

        // PUT
        // on remplace tous les attributs
        // on supprime les attributs absents
        $truc->setNom($input['nom']);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($truc);
        $em->flush();

        // return something to avoid Response::HTTP_NO_CONTENT
        $view = $this->view(array(
            'id' => $truc->getId()),
            Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Truc $truc
     * @return Response
     */
    public function patchTrucAction(Request $request, Truc $truc)
    {
        $data = $request->request->all();

        // Controle champ obligatoires
        $filters = array(
            'nom' => array("flags" => FILTER_REQUIRE_SCALAR)
        );
        $input = filter_var_array($data, $filters);
        if (!$input["nom"]) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, '');
        }

        // PATCH
        // On ne modifie que les attributs présents
        $truc->setNom($input['nom']);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($truc);
        $em->flush();

        // return something to avoid Response::HTTP_NO_CONTENT
        $view = $this->view(array(
            'id' => $truc->getId()),
            Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function searchTrucAction(Request $request)
    {
        $data = $request->query->all();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $trucs = $em->getRepository("AcmeApiBundle:Truc")->findByNom($data['nom']);

        $view = $this->view($trucs);
        return $this->handleView($view);
    }
}
