<?php


namespace App\Controller;


use App\Entity\Tag;


use App\Form\TagFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class TagController extends AbstractController
{
    /**
     * @Route("/tag",name="api_tag_getAll", methods={"GET"})
     * @return JsonResponse
     */
    public function getTags(){
        $repository = $this->getDoctrine()->getManager()->getRepository(Tag::class);

        $tags = $repository->findAll();

        return $this->json($tags);
    }

    /**
     * @Route("/tag", name="api_create_tag", methods={"POST"})
     */
    public function createTag(Request $request){
        $tag = new Tag();

        $form = $this->createForm(TagFormType::class,$tag);

        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tag);
            $manager->flush();

            return $this->json($tag);
        }

        $errorMessages = [];

        foreach($form->getErrors(true) as $error)
        {
            $errorMessages[$error->getOrigin()->getProperty()] = $error->getMessage();
        }

        return $this->json($errorMessages);
    }

    /**
     * @Route("/tag/{tag}",name="api_tag_getOne", methods={"GET"})
     */
    public function getTag(Tag $tag){
        return $this->json($tag);
    }
    /**
     * @Route("/tag/{tag}",name="api_tag_delete", methods={"DELETE"})
     */
    public function deleteTag(Tag $tag){
        $manager= $this->getDoctrine()->getManager();
        $manager->remove($tag);
        $manager->flush();

        return new Response(null,200,["Content-type"    =>  'application/json']);

    }

    /**
     * @Route("/tag/{tag}", name="api_put_tag", methods={"PUT"})
     */
    public function putTag(Request $request,Tag $tag){

        $form = $this->createForm(TagFormType::class,$tag);

        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tag);
            $manager->flush();

            return $this->json($tag);
        }

        $errorMessages = [];

        foreach($form->getErrors(true) as $error)
        {
            $errorMessages[$error->getOrigin()->getProperty()] = $error->getMessage();
        }

        return $this->json($errorMessages);
    }

    /**
     * @Route("/tag/{tag}", name="api_patch_tag", methods={"PATCH"})
     */
    public function patchTag(Request $request,Tag $tag){

        $form = $this->createForm(TagFormType::class,$tag);

        $form->submit($request->request->all(),false);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tag);
            $manager->flush();

            return $this->json($tag);
        }

        $errorMessages = [];

        foreach($form->getErrors(true) as $error)
        {
            $errorMessages[$error->getOrigin()->getProperty()] = $error->getMessage();
        }

        return $this->json($errorMessages);
    }
}