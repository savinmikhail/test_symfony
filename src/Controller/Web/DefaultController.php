<?php

namespace App\Controller\Web;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'blog_default')]
    public function index(BlogRepository $repository, EntityManagerInterface $entityManager): Response
    {
        return $this->render('default/index.html.twig', [
            'blogs' => $repository->getBlogs(),
        ]);
    }
}
