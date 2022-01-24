<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * @Route("", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/{id}/mail", name="user_profil_mail", methods={"GET","POST"})
     */
    public function profilmail(Request $request, User $user): Response
    {
        $form = $this->createForm(UserProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre adresse email a été modifié');
            return $this->redirectToRoute('user_profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editProfilmail.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/password", name="user_profil_password", methods={"GET","POST"})
     */
    public function profilPassword(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //mot de passe actuel
            $plainPassword = $form->get('ActualPassword')->getData();
            //verification mdp actuel
            if (password_verify($plainPassword, $user->getPassword())) {
                //si ok changement de mot de passe
                if ($form->get('password')->getData() === $form->get('password2')->getData()) {
                    //changement de mot de passe
                    $user->setPassword(
                        $userPasswordHasherInterface->hashPassword(
                            $user,
                            $form->get('password')->getData()

                        )
                    );
                    $em= $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    $this->addFlash('success', 'Votre mot de passe a été modifié');
                    return $this->redirectToRoute('user_profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
                    //mauvais mdp nouveau
                } else {
                    $this->addFlash('danger', 'les champs: "nouveau mot de passe" et "confirmation" doivent être identiques');
                    return $this->redirectToRoute('user_profil_password', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
                }
            }else {
                $this->addFlash('danger', 'Votre mot de passe actuel n\'est pas valable');
                return $this->redirectToRoute('user_profil_password', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/editProfilpassword.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/profil", name="user_profil", methods={"GET","POST"})
     */
    public function profil(Request $request, User $user): Response
    {
        return $this->renderForm('admin/editProfil.html.twig', [
            'user' => $user,
        ]);
    }
}
