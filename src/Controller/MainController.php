<?php

namespace App\Controller;

use App\Entity\CdList;
use App\Form\CdListFormType;
use App\Repository\CdListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CdListRepository $cdListRepository): Response
    {
        $data = $cdListRepository->findAll();

        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }

    #[Route('detail/{id}', name: 'detail')]
    public function detail(EntityManagerInterface $entityManager, $id): Response
    {
        $data = $entityManager->getRepository(CdList::class)->find($id);

        return $this->render('main/detail.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addItem(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $cdList = new CdList();

        $form = $this->createForm(CdListFormType::class, $cdList);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if($imageFile) {
                $originalImagename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImagename = $slugger->slug($originalImagename);
                $newImagename = $safeImagename. '-' .uniqid(). '.' .$imageFile->guessExtension();
            }

            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newImagename
                );
            } catch (FileException $e) {

            }

            $cdList->setImage($newImagename);

            $entityManager->persist($cdList);
            $entityManager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->renderForm('main/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteItem(EntityManagerInterface $entityManager, $id): Response
    {
        $item = $entityManager->getRepository(CdList::class)->find($id);
        $entityManager->remove($item);
        $entityManager->flush();

        return $this->redirectToRoute('app_main');
    }
}
