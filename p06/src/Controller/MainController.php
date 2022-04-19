<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\ChatType;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $doctrine;
    private $em;
    
    public function __construct(ManagerRegistry $doctrine,EntityManagerInterface $em)
    {
        $this->doctrine = $doctrine;
        $this->em = $em;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        if ($request->request->get('more')) {
            $tricks = $this->doctrine->getRepository(Trick::class)->findAll();
            $medias = $this->doctrine->getRepository(Media::class)->findAll();
        }else{
            $tricks = $this->doctrine->getRepository(Trick::class)->findBy([],[],15);
            $medias = $this->doctrine->getRepository(Media::class)->findAll();
        }

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'tricks'=> $tricks,
            'medias'=>$medias,
        ]);
    }

    #[Route('/trick', name: 'app_trick')]
    public function trick(Request $request): Response
    {
        $id = $request->query->get('id');
        $trick = $this->doctrine->getRepository(Trick::class)->findOneBy(['id'=>$id]);
        $medias = $this->doctrine->getRepository(Media::class)->findBy(['Trick'=>$trick]);
        $comments = $this->doctrine->getRepository(Comment::class)->findLast(10,$trick->getId());
        $form = $this->createForm(ChatType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $info = $form->getData();
            $comment = new Comment;
            $comment->setBody($info['message']);
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);
            $this->em->persist($comment);
            $this->em->flush();
            return $this->redirectToRoute('app_trick',['id'=>$id]);
        }
        
        return $this->render('main/tricks.html.twig', [
            'controller_name' => 'MainController',
            'trick' => $trick,
            'medias' => $medias,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
