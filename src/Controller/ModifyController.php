<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\Comment;
use App\Form\NewTrickType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ModifyController extends AbstractController
{
    private $em;
    private $doctrine;
    
    public function __construct(EntityManagerInterface $em,ManagerRegistry $doctrine)
    {
        $this->em = $em;
        $this->doctrine = $doctrine;
    }

    #[Route('/profil/delete/tricks', name: 'app_trick_delete')]
    public function delete_tricks(Request $request): Response
    {
        $id = $request->query->get('id');
        $trick = $this->doctrine->getRepository(Trick::class)->findOneBy(['id'=>$id]);
        $medias = $this->doctrine->getRepository(Media::class)->findBy(['Trick'=>$trick]);
        $comments = $this->doctrine->getRepository(Comment::class)->findBy(['Trick'=>$trick]);

        if ($this->isCsrfTokenValid('delete' . $trick->getId(), $request->request->get('_token'))) {
            foreach ($medias as $media) {
                $this->em->remove($media);
            }
            foreach ($comments as $comment) {
                $this->em->remove($comment);
            }
            $this->em->remove($trick);
            $this->em->flush();
        }
        $this->addFlash('succes','La figure à bien été supprimée !');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/profil/delete/media', name: 'app_media_delete')]
    public function delete_media(Request $request): Response
    {
        $id = $request->query->get('id');

        $media = $this->doctrine->getRepository(Media::class)->findOneBy(['id'=>$id]);

        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->em->remove($media);
            $this->em->flush();
        }
        $this->addFlash('succes','Le media à bien été supprimée !');
        return $this->redirectToRoute('app_trick',['id'=>$media->getTrick()->getId()]);
    }

    #[Route('/profil/modify/tricks', name: 'app_tricks_modify')]
    public function modify_media(Request $request,SluggerInterface $slugger): Response
    {
        $id = $request->query->get('id');

        $trick = $this->doctrine->getRepository(Trick::class)->findOneBy(['id'=>$id]);
        $medias = $this->doctrine->getRepository(Media::class)->findBy(['Trick'=>$trick]);

        $form = $this->createForm(NewTrickType::class,$trick);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted()) {

                $trick = $form->getData();
                $this->em->persist($trick);
                $this->em->flush();
                $file = $form->get('Medias')->getData();
                $Youtubelink = $request->request->get('new_trick')['Youtube'];
    
                if ($Youtubelink != [1=>""]) {
                    for ($i=1; $i < count($Youtubelink)+1; $i++) { 
                        $link = $Youtubelink[$i];
                        $link = str_replace('https://www.youtube.com/watch?v=','',$link);
                        $media = new Media;
                        $media->setFileName($link);
                        $media->setType('Youtube');
                        $media->setTrick($trick);

                        $this->em->persist($media);
                        $this->em->flush();
                    }
                }
                if ($file) {
                    foreach ($file as $key => $value) {
                        $originalFilename = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$value->guessExtension();
                        $value->move(
                            $this->getParameter('media_directory'),
                            $newFilename
                        );
                        $media = new Media;
                        $media->setFileName($newFilename);
                        $media->setType('Image');
                        $media->setTrick($trick);
    
                        $this->em->persist($media);
                        $this->em->flush();
                    }
                }else{
                    $media = new Media;
                    $media->setFileName('default.jpg');
                    $media->setType('Image');
                    $media->setTrick($trick);
    
                    $this->em->persist($media);
                    $this->em->flush();
                }
                $this->addFlash('succes','Le media à bien été ajoutée !');
            }
        } catch (\Throwable $th) {
            if ($th->getCode() === 1062) {
                $this->addFlash('error','Le nom de la figure existe deja');
            }
            return $this->redirect($request->headers->get('referer'));
        }
        
        return $this->render('profils/modifyTricks.html.twig', [
            'form'=>$form->createView(),
            'medias'=>$medias,
            'nameTrick'=> $trick->getName(),
            'idTrick'=> $trick->getId(),
        ]);
    }
}