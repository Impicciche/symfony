<?php


namespace App\Controller;


use App\Entity\Picture;
use App\Form\PictureFormType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PictureController extends AbstractController
{
    /**
     *
     * @Route("/add/picture", name="add_picture")
     */

    public function addPicture(FormFactoryInterface $formBuilder, Environment $twig, Request $request){

        $picture = new Picture();
        $form = $formBuilder->create(PictureFormType::class,$picture,['standalone'  =>  true]);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('file')->getData();


            $image = imagecreatefromstring(file_get_contents($file->getPathname()));



            /*
             *
             *
             * Too finish
             *
             *
             *
             *
             */

            $filename = Uuid::uuid4() . '.' . $file->getExtension();
            $picture->setPath( $filename);
            $picture->setSharer($this->getUser());
            $picture->setMimeType($file->getMimeType());
            $file->move($this->getParameter('upload_directory'), $filename);


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($picture);
            $manager->flush();


            return $this->redirectToRoute('homepage');
        }
            return new Response($twig->render('addPicture.html.twig',[
                'myForm'    =>  $form->createView()
            ]));
    }

    /**
     * @Route("/picture/{picture}", name="get_picture_content")
     */
    public function gimmePic(Picture $picture)
    {
        $path = $this->getParameter('upload_directory') . $picture->getPath();

        return new Response(
            file_get_contents($path),
            200,
            [
                'Content-Type'  =>  $picture->getMimeType()
            ]);
    }

}