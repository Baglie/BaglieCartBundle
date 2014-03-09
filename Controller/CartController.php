<?php

namespace Baglie\CartBundle\Controller;

use MyProject\Proxies\__CG__\stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class CartController extends Controller
{
    public function addAction()
    {
        $request = $this->getRequest();
        return new JsonResponse($request);

    }

}
