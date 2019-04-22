<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/index")
     */
    public function index()
    {
        return new Response("<html><body><h1>Zone admin</h1></body></html>");
    }

    /**
     * @Route("/admin/add-role")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function addRole(Request $request): Response
    {
        // Récupération des variables POST
        $userChoosed = (int) $request->request->get('choosed-user');
        $roleChoosed = $request->request->get('choosed-role');
        // Récupération du  Repository User pour avoir l'user + tous les users)
        $repo = $this->getDoctrine()->getRepository(User::class);
        // On vérifie que les variables POSTS ne sont pas nulles pour modifier en BDD
        if(!is_null($userChoosed) && !is_null($roleChoosed)) {
            // récupération de l'User correspondant à l'id passé en paramètre
            $user = $repo->find($userChoosed);
            if(!$user) {
                throw new \Exception('Utilisateur inconnu');
            }
            // On assigne le rôle unique à l'user
            $user->setRole($roleChoosed);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
        }

        $users = $repo->findAll();

        return $this->render('admin/add_role.html.twig', [
            "users" => $users
        ]);
    }
}