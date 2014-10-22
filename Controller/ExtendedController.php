<?php

namespace Arkulpa\Bundle\SymfonyExtensionsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExtendedController extends Controller
{

    protected function generateSuccesResponse($data = null)
    {
        $returnValue = array("status" => "success", "data" => $data);
        return new Response(json_encode($returnValue));
    }

    protected function  generateValidationErrorResponse($validationErrors)
    {
        $returnValue = array("status" => "fail", "data" => array("errors" => $validationErrors));
        return new Response(json_encode($returnValue), 400);
    }

    protected function generateLogicErrorResponse($e)
    {
        if ($e instanceof \Exception) {
            $translatedError = $this->get("translator.default")->trans($e->getMessage());
        } else {
            $translatedError = $this->get("translator.default")->trans($e);
        }
        $returnValue = array("status" => "error", "data" => $translatedError);
        return new Response(json_encode($returnValue), 500);
    }

}
