<?php
namespace App\Controller;

use App\Form\ContactFormType;
use App\Entity\ContactMessages;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    
    #[Route('/contact', name: 'contact.index')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        // Je crée un nouveau contact
        $contact = new ContactMessages();

        // si il y a un utilisateur on prèremplie les champs

        
        // On créé le formulaire
        $contactForm = $this->createForm(ContactFormType::class, $contact);

        // On traite la requête du formulaire
        $contactForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contact = $contactForm->getData();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre demande a été envoyé avec succès');
            return $this->redirectToRoute('contact.index');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $contactForm->createView()
        ]);
    }
}
