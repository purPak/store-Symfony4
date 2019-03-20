<?php
namespace App\Controller;


use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Page d'accueil : affiche la liste cliquable des catégories
     * @return Response
     */
    public function home(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repo->findAll();

        return $this->render('home/index.html.twig', [
            "categories" => $categories
        ]);
    }

}