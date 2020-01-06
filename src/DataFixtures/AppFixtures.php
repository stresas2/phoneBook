<?php

namespace App\DataFixtures;

use App\Entity\Contacts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;


class AppFixtures extends Fixture
{
    private $encoder;
    private $faker;

    private $user1;
    private $user2;
    private $user3;
    private $user4;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->makeUsers(3, $manager);
        $this->makeContacts(40, $manager);
    }

    public function makeUsers($number, ObjectManager $manager)
    {
        $users = array();

        for ($i = 0; $i <= $number; $i++) {
            $users[$i] = new User();
            $password = $this->encoder->encodePassword($users[$i], 'test' . $i);
            $users[$i]->setPassword($password);

            $users[$i]->setEmail('test' . $i . '@test.lt');
            $users[$i]->setRoles(array('ROLE_USER'));

            $manager->persist($users[$i]);
        }

        $manager->flush();

        $this->user1 = $users[0];
        $this->user2 = $users[1];
        $this->user3 = $users[2];
        $this->user4 = $users[3];
    }

    public function makeContacts($number, ObjectManager $manager)
    {
        for ($i = 0; $i < $number; $i++) {

            $contact = new Contacts();
            $name = $this->faker->firstName;
            $contact->setName($name);
            $contact->setNumber(mt_rand(860000000, 869999999));
            if ($i < 11) {
                $user = $this->user1;
                $contact->setFkUser($user);
            } else if ($i < 21) {
                $user = $this->user2;
                $contact->setFkUser($user);
            } else if ($i < 31) {
                $user = $this->user3;
                $contact->setFkUser($user);
            } else if ($i <= 40){
                $user = $this->user4;
                $contact->setFkUser($user);
            }

            $manager->persist($contact);
        }

        $manager->flush();
    }
}
