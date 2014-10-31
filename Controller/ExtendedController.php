<?php

namespace Arkulpa\Bundle\SymfonyExtensionsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExtendedController extends Controller
{

    protected function generateSuccesResponse($data = null)
    {
        $returnValue = array("status" => "success", "data" => $data);
        $response = new Response(json_encode($returnValue));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    protected function  generateValidationErrorResponse($validationErrors)
    {
        $returnValue = array("status" => "fail", "data" => array("errors" => $validationErrors));
        $response = new Response(json_encode($returnValue), 400);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    protected function generateLogicErrorResponse($e)
    {
        if ($e instanceof \Exception) {
            $translatedError = $this->get("translator.default")->trans($e->getMessage());
        } else {
            $translatedError = $this->get("translator.default")->trans($e);
        }
        $returnValue = array("status" => "error", "data" => $translatedError);
        $response = new Response(json_encode($returnValue), 500);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
