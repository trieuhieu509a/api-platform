<?php
namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\User;

class ResetPasswordRequestEvent extends Event
{
    public const NAME = 'reset.password.requested';

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
