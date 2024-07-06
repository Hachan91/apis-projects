<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/index', name: 'app_subscription')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SubscriptionController.php',
        ]);
    }

    #[Route('/subscription/{idContact}', name: 'get_subscriptions', methods: ['GET'])]
    public function getSubscriptions(SubscriptionRepository $subscriptionRepository, $idContact): Response
    {
        $subscriptions = $subscriptionRepository->findBy(['contact' => $idContact]);
        $responseData = [];
        foreach ($subscriptions as $subscription) {
            $responseData[] = [
                'id' => $subscription->getId(),
                'name' => $subscription->getContact()->getName(),
                'firstName' => $subscription->getContact()->getFirstName(),
                'product' => $subscription->getProduct()->getLabel(),
                'beginDate'=>$subscription->getBeginDate(),
                'endDate'=>$subscription->getEndDate()
            ];
        }
        return new JsonResponse($responseData, Response::HTTP_OK);
    }

    #[Route('/subscription', name: 'create_subscription', methods: ['POST'])]
    public function createSubscription(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $subscription = new Subscription();
        $subscription->setContact($em->getRepository(Contact::class)->find($data['contact']));
        $subscription->setProduct($em->getRepository(Product::class)->find($data['product']));
        $subscription->setBeginDate(new \DateTime($data['beginDate']));
        $subscription->setEndDate(new \DateTime($data['endDate']));

        $em->persist($subscription);
        $em->flush();

        $responseData[] = [
            'id' => $subscription->getId(),
            'name' => $subscription->getContact()->getName(),
            'firstName' => $subscription->getContact()->getFirstName(),
            'product' => $subscription->getProduct()->getLabel(),
            'beginDate'=>$subscription->getBeginDate(),
            'endDate'=>$subscription->getEndDate()
        ];

        return new JsonResponse($responseData, Response::HTTP_OK);
    }
    #[Route('/subscription/{idSubscription}', name: 'update_subscription', methods: ['PUT'])]
    public function updateSubscription(\Symfony\Component\HttpFoundation\Request $request, EntityManagerInterface $em, $idSubscription): Response
    {
        $subscription = $em->getRepository(Subscription::class)->find($idSubscription);
        $data = json_decode($request->getContent(), true);

        $subscription->setContact($em->getRepository(Contact::class)->find($data['contact']));
        $subscription->setProduct($em->getRepository(Product::class)->find($data['product']));
        $subscription->setBeginDate(new \DateTime($data['beginDate']));
        $subscription->setEndDate(new \DateTime($data['endDate']));

        $em->flush();

        $responseData[] = [
            'id' => $subscription->getId(),
            'name' => $subscription->getContact()->getName(),
            'firstName' => $subscription->getContact()->getFirstName(),
            'product' => $subscription->getProduct()->getLabel(),
            'beginDate'=>$subscription->getBeginDate(),
            'endDate'=>$subscription->getEndDate()
        ];

        return new JsonResponse($responseData, Response::HTTP_OK);    }

    #[Route('/subscription/{idSubscription}', name: 'delete_subscription', methods: ['DELETE'])]
    public function deleteSubscription(EntityManagerInterface $em, $idSubscription): Response
    {
        $subscription = $em->getRepository(Subscription::class)->find($idSubscription);
        $em->remove($subscription);
        $em->flush();

        return $this->json(['status' => 'Subscription deleted']);
    }

}
