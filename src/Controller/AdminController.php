<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function persistUserEntity(User $user): void
    {
        $this->updatePassword($user);
        parent::persistEntity($user);
    }

    public function updateUserEntity(User $user): void
    {
        $this->updatePassword($user);
        parent::updateEntity($user);
    }

    public function updatePassword(User $user): void
    {
        if (empty($user->getPlainPassword())) {
            return;
        }

        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
    }
}
