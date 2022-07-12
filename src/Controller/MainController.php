<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Info;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_main")
     */
    public function index(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $user = $em->getRepository(User::class)->find($id);
        // dd($user);
        // $user = new User();
        /* $user->setFirstName("Pramesh");
        $user->setLastName("Mahat");


        $country = $em->getRepository(Country::class)->find(5);

        $user->setCountry($country);
        //dd($user);

        $info = new Info();
        $info->setClientName("hello");
        $info->setNumber("0348383");
        $info->setUser($user);

        $user->addInfo($info);*/

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        //dd($form);

        if ($form->isSubmitted()) {
            $em->persist($user);
            $em->flush();
        }

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
