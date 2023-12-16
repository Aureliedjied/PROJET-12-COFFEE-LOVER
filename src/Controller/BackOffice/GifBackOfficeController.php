<?php

namespace App\Controller\BackOffice;

use App\Entity\Gif;
use App\Form\GifFormType;
use App\Repository\GifRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back-office")
 */
class GifBackOfficeController extends AbstractController
{
    /**
     * @Route("/gif-musique", name="app_back_gif")
     */
    public function list(GifRepository $gifRepository): Response
    {
        $gifs = $gifRepository->findAll();

        return $this->render('back-office/gif/list.html.twig', [
            'gifs' => $gifs,
        ]);
    }

    /**
     * @Route("/gif-musique/ajouter", name="app_back_gif_add")
     */
    public function create(Request $request, gifRepository $gifRepository): Response
    {
        $gif = new Gif();

        $form = $this->createForm(GifFormType::class, $gif);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $gifRepository->add($gif, true);

            return $this->redirectToRoute('app_back_gif');
        }

        return $this->renderForm('back-office/gif/add.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/gif/{id}/delete", name="app_back_gif_delete")
     */
    public function delete($id, GifRepository $gifRepository)
    {
        $gif = $gifRepository->find($id);
        
        $gifRepository->remove($gif, true);

        return $this->redirectToRoute('app_back_gif');
    }
}
