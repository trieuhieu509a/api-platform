<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;

use App\Entity\LostPassword;
use App\Entity\User;
use App\Event\ResetPasswordRequestEvent;
// use App\Listener\ResetPasswordRequestListener;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exception\CustomException;

class RequestNewPasswordController extends AbstractController
{
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->eventDispatcher = $dispatcher;
    }

    public function __invoke(LostPassword $data)
    {
        throw new CustomException('CustomException');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $data->getEmail()]);
        if($user)
        {
            $user->setLostPassword($data);
            $entityManager->flush();

            $dispatcher = $this->eventDispatcher;
            // $listener = new ResetPasswordRequestListener();
            // $dispatcher->addListener('reset.password.requested', [$listener, 'onResetPasswordRequestedAction']);
            $event = new ResetPasswordRequestEvent($user);
            $dispatcher->dispatch($event, ResetPasswordRequestEvent::NAME);
        }
        else
        {
            exit();
        }
        return new JsonResponse($user->getId());

    }
}
