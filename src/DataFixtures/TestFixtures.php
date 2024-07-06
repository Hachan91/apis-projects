<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contact = new Contact();
        $contact->setName('test');
        $contact->setFirstName('testname');
        $manager->persist($contact);

        $product = new Product();
        $product->setLabel('Product1');
        $manager->persist($product);

        $subscription = new Subscription();
        $subscription->setContact($contact);
        $subscription->setProduct($product);
        $subscription->setBeginDate(new \DateTime('2023-01-01T00:00:00'));
        $subscription->setEndDate(new \DateTime('2024-01-01T00:00:00'));
        $manager->persist($subscription);

        $contact2 = new Contact();
        $contact2->setName('test');
        $contact2->setFirstName('testname');
        $manager->persist($contact2);

        $product2 = new Product();
        $product2->setLabel('product2');
        $manager->persist($product2);

        $subscription2 = new Subscription();
        $subscription2->setContact($contact2);
        $subscription2->setProduct($product2);
        $subscription2->setBeginDate(new \DateTime('2023-01-01T00:00:00'));
        $subscription2->setEndDate(new \DateTime('2024-01-01T00:00:00'));
        $manager->persist($subscription2);

        $manager->flush();
    }
}
