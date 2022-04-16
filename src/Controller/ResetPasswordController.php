<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends AbstractController
{
    public function __invoke()
    {
        return new Response('save new password in the database');
    }
}