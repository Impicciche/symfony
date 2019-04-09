<?php


namespace App\Controller;




use App\Repository\PictureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DefaultController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
    */
    public function homepageAction(
        Environment $twig,
        PictureRepository $repository,
        Request $request,
        PaginatorInterface $paginator
    )
    {

        $color = "green";

        return new Response($twig->render("homepage.html.twig",
            [
                "pictures" => $repository->findPaginated(
                    $request,
                    $paginator
                )
            ]));
    }

    /**
     *
     * @Route("/terms" ,name="term_of_service")
     * @return  Response
     */

    public function TermOfServiceAction(){
        return new Response("This is the terms...");
    }

}