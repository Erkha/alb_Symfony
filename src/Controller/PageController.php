<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Page;
use App\Exceptions\ImageLoaderException;
use App\Form\PageType;
use App\Repository\PageRepository;
use App\Service\ImageLoaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Safe\json_encode as SafeJson_encode;

/**
 * @Route("/adminpage")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="page_index", methods={"GET"})
     */
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="page_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('page/new.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_show", methods={"GET"})
     */
    public function show(Page $page): Response
    {
        return $this->render('page/show.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/{id}/edit", name="page_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page_index');
        }

        return $this->render('page/edit.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="page_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Page $page): Response
    {
        if ($this->isCsrfTokenValid('delete' . $page->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page_index');
    }

    /**
     * Upload a picture and create the related SiFile object with the type in parameter
     *
     * @param Request $request request object
     * @param ContentService $contentService content service
     *
     * @return Response response object
     *
     * @throws ImageLoaderException
     *
     * @Route("/upload/{id}", name="content_upload", methods={"POST"})
     */
    public function upload(Request $request, Page $page, ImageLoaderService $imageLoaderService): Response
    {
        $response = new Response();
        $result = [];
        $file = $request->files->get('file');
        try {
            $image = $imageLoaderService->uploadPicture($page, $file);
            $result = [
                'id' => $image->getId(),
                'mediaFileName' => $image->getImage(),
            ];
        } catch (ImageLoaderException $e) {
            $result['error'] = $e->__toString();
        }

        $response->setContent(SafeJson_encode($result));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Delete the picture in parameter from the page in parameter.
     *
     * @param ContentService $contentService
     *
     * @Route("/{id}/picture/{image}")
     */
    public function deletePicture(Page $page, Image $image, ImageLoaderService $imageLoaderService): Response
    {
        $imageLoaderService->deletePicture($page, $image);

        $response = new Response();
        $response->setContent(SafeJson_encode(['result' => true]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
