<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

class RequestNewPasswordController extends AbstractController
{
    public function __invoke()
    {

        return new JsonResponse('save the token in the database and send it to the user as a link');

    }
}
