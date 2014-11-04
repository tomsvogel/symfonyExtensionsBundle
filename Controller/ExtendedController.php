<?php

namespace Arkulpa\Bundle\SymfonyExtensionsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExtendedController extends Controller
{

    protected function generateSuccesResponse($data = null)
    {
        $returnValue = array("status" => "success", "data" => $data);
        $response = new JsonResponse($returnValue);
        return $response;
    }

    protected function  generateValidationErrorResponse($validationErrors)
    {
        $returnValue = array("status" => "fail", "data" => array("errors" => $validationErrors));
        $response = new JsonResponse($returnValue, 400);
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
        $response = new JsonResponse($returnValue, 500);
        return $response;
    }

}
