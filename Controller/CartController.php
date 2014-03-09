<?php

namespace Baglie\CartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends Controller
{
    public function addAction()
    {
        $request = $this->getRequest();
        return new JsonResponse($request);

    }

}
