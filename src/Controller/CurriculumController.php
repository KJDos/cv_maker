<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Curriculum;
use App\Form\CurriculumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CurriculumController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $curriculum = new Curriculum();
        
        //test
        $skill = new Skill();
        $skill->setName('Flutter')
        ->setLevel(5);
        $curriculum->addSkill($skill);

        $skill2 = new Skill();
        $skill2->setName('Flutter2')
        ->setLevel(5);
        $curriculum->addSkill($skill2);
        // /test
        
        $form = $this->createForm(CurriculumType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();


            if ($photoFile) {

                $safeFilename = mt_rand(1,9999999999);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();


                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload = redirect + appflash error
                }
                $curriculum->setPhoto($newFilename);
            } else{
                $defaultPhoto = 'no-photo.png';
                $curriculum->setPhoto($defaultPhoto);
            }



            $manager->persist($curriculum);
            $manager->flush();

            //$this->addFlash(
            //    'success',
            //    "Income <strong>{$income->getTitle()}</strong> has been added."
            //);
            //return $this->redirectToRoute('income');
        }

        return $this->render('curriculum/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
