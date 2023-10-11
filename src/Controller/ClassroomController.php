<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/classroom', name: 'app_classroom')]
class ClassroomController extends AbstractController
{
    #[Route('/', name: 'list_classroom')]
    public function list(ClassroomRepository $repository): Response
    {
        $list=$repository->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list,
        ]);
    }


    #[Route('/add', name: 'add')]
    public function addClass(): Response
    {

    /*    $cl->setName($name);
        $em=$doctrine->getManager();
        $em->persist($cl);
        $em->flush();*/


        return $this->render('classroom/addClassroom.html.twig',[
          /*  'name'=> $name*/
        ]);

    }


    #[Route('/addClassroom', name: 'addClassroom')]
    public function addClassroom(ManagerRegistry $doctrine ): Response
    {
        $em = $doctrine->getManager();
        $classroom = new Classroom();
        $classroom->setName('2A28');
        $em->persist($classroom);


        $em->flush();

        return $this->render('classroom/classrooomdetail.html.twig', [
            'classroom' => $classroom,
        ]);
    }

    #[Route('/deleteClass/{id}', name : 'deleteClass')]
    public function deleteClassroom(Classroom $cl = null , ManagerRegistry $doctrine, $id): RedirectResponse{


        if($cl){
            $em=$doctrine->getManager();
            $em->remove($cl);
            $em->flush();
            $this->addFlash('success',"la classroom a ete supprimer");
        }
        else {
            $this->addFlash('error',"la classroom ne exist pas");
        }
    return $this->redirectToRoute('list_classroom');
    }
    #[Route('/update/{id}/{name}', name: 'update')]
    public function update(Classroom $cl = null,ManagerRegistry $doctrine, $name):Response{
        if($cl){
            $cl->setName($name);
            $em=$doctrine->getManager();
            $em->persist($cl);

            $em->flush();

            $this->addFlash('success',"la classroom a ete update");

        }
        else {
            $this->addFlash('error',"la classroom a ete update");

        }
        return $this->redirectToRoute('list_classroom');
    }


}
