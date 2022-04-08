<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Trick;
use App\Form\AvatarType;
use App\Form\NewTrickType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfilsController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;       
    }

    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profils/index.html.twig', [
            'controller_name' => 'ProfilsController',
        ]);
    }

    #[Route('/profil/createTricks', name: 'app_profil_createTricks')]
    public function createTricks(Request $request,SluggerInterface $slugger): Response
    {
        $trick = new Trick;
        $form = $this->createForm(NewTrickType::class,$trick);
        $form->handleRequest($request);
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
                foreach ($file as $value) {
                    $originalFilename = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$value->guessExtension();
                    try {
                        $value->move(
                            $this->getParameter('media_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
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

            $this->addFlash('succes','Votre figure a bien ete crée');
        }

        return $this->render('profils/createTricks.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profil/modifyProfil', name: 'app_profil_modifyProfil')]
    public function modifyProfil(Request $request,SluggerInterface $slugger): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(AvatarType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('avatar')->getData();

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('avatar_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'file' property to store the PDF file name
            // instead of its contents
            $user->setAvatar($newFilename);
            $this->em->flush();
        }

        return $this->render('profils/modifyProfil.html.twig', [
            'controller_name' => 'ProfilsController',
            'user'=> $user,
            'form'=>$form->createView()
        ]);
    }

    #[Route('/profil/editUser/{value}/{typedata}', name: 'app_profil_editUser')]
    public function editUser($value, $typedata)
    {
        $user = $this->getUser();
        switch ($typedata) {
            case 'email':
                $user->setEmail($value);
                break;
            case 'name':
                $user->setName($value);
                break;
            default:
                # code...
                break;
        }

        $this->em->flush();

        return new Response(
            'Payment crée',
            Response::HTTP_OK
        );
    }

    #[Route('/profil/modifypassword/', name: 'app_profil_modifypassword')]
    public function modifypassword(Request $request)
    {
        $data = $request->request->all();
        $user = $this->getUser();

        if ($data['passwordold'] !== "" && $data['passwordnew'] !== "" && $data['passworddouble'] !== "") {
            if(password_verify($data['passwordold'],$user->getPassword())){
                if ($data['passwordnew'] === $data['passworddouble']) {
                    $user->setPassword(password_hash($data['passwordnew'],PASSWORD_DEFAULT));
                    $this->em->flush();
                    $this->addFlash('succes','Mot de passe modifier !');
                    return $this->redirectToRoute('app_profil_modifyProfil');
                }else{
                    $this->addFlash('error','Les mots de passe tapper ne sont pas les même !');
                    return $this->redirectToRoute('app_profil_modifyProfil');
                }
            }else{
                $this->addFlash('error','L\'ancien mot de passe est pas le bon !');
                return $this->redirectToRoute('app_profil_modifyProfil');
            }
        }

    }
}
