<?php

namespace App\Controller\BackOffice;

use App\Entity\Reward;
use App\Form\RewardFormType;
use App\Repository\RewardRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/back-office")
 */
class RewardBackOfficeController extends AbstractController
{
    /**
     * @Route("/recompenses", name="app_back_reward")
     */
    public function list(RewardRepository $rewardRepository): Response
    {
        // Afficher la liste des récompenses
        $rewards = $rewardRepository->findAll();

        return $this->render('back-office/reward/list.html.twig', [
            'rewards' => $rewards,
        ]);
    }

    /**
     * @Route("/recompenses/ajouter", name="app_back_reward_add")
     */
    public function create(Request $request, RewardRepository $rewardRepository): Response
    {
        $reward = new Reward();

        $form = $this->createForm(RewardFormType::class, $reward);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $rewardRepository->add($reward, true);
            $this->addFlash('success', 'Ajout effectué avec succès !');
            return $this->redirectToRoute('app_back_reward');
        }

        return $this->renderForm('back-office/reward/add.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @Route("/recompenses/{id}/delete", name="app_back_reward_delete")
     */
    public function delete($id, RewardRepository $rewardRepository)
    {
        $reward = $rewardRepository->find($id);
        
        $rewardRepository->remove($reward, true);

        return $this->redirectToRoute('app_back_reward');
    }
}