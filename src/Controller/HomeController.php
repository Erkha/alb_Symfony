<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name= "main")
     */
    public function displayLandingPage(PageRepository $pageRepo): Response
    {
        $mainPages=$pageRepo->findBy(['parent' => null]);

        return $this->render('home/landing.html.twig', ['mainPages' => $mainPages]);
    }

    /**
     * @Route("page/{slug}", defaults={"slug"="home"}, name="pages")
     */
    public function displayPage(PageRepository $pageRepo, Page $page): Response
    {
        $mainPages=$pageRepo->findBy(['parent' => null]);

        return $this->render('home/dynamicPage.html.twig', [
            'mainPages' => $mainPages,
            'page'=>$page,
        ]);
    }
}
