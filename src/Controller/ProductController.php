<?php
namespace App\Controller;

use App\Entity\Product;
use App\Entity\Collections;
use App\Entity\Category;
use App\Form\ProductType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_home")
     */
   public function index() {
       $repo = $this->getDoctrine()->getRepository(Product::class);
       $products = $repo->findAll();
       return $this->render('front/home.html.twig', ['products' => $products]);
   }

    /**
     * @Route("/edit/{id}", name="product_edit")
     * On recupère l'id du produit directement en Appelant la class Product en param
     *
     * @param Product       $product
     * @param Request       $request
     * @param ObjectManager $manager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
   public function editProduct(Product $product,Request $request, ObjectManager $manager) {
       $form = $this->createForm(ProductType::class,$product);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $manager->persist($product);
           $manager->flush();
           return $this->redirectToRoute('product_home');
       }
       return $this->render('front/edit.html.twig',['formProduct'=>$form->createView(),'id'=>$product->getId()]);
   }

}