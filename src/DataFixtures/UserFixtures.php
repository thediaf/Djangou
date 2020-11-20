<?php

/*
 * This file is part of the Djangou application.
 *
 * (c) Diafra Soumaré and Bechir Ba
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
//use Symfony\Componen\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as EncoderUserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(EncoderUserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as [$username, $password, $roles]) {
            $user = (new User())
                ->setUsername($username)
                ->setRoles($roles);
            $user->setPassword($this->encoder->encodePassword($user, $password));

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getData(): array
    {
        return [
            ['demo', 'demo', ['ROLE_USER']],
            ['admin', 'admin', ['ROLE_ADMIN']],
        ];
    }
}
