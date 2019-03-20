<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/categories/ajout")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        // Récupération du formulaire
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        // Vérication du formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est valide :
            // => on ajoute la catégorie en BDD
            $category = $form->getData();

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('app_homepage');
        }
        // Sinon on renvoit une vue avec le formulaire
        return $this->render("category/add.html.twig", [
            "form" => $form->createView()
        ]);
    }
}