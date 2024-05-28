<?php
namespace App\Controller;

use App\Form\LoginType;
use App\Repository\UsuariosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class LoginController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(Request $request, UsuariosRepository $usuariosRepository): Response
    {
        // Redirigir al usuario si ya está autenticado
        if ($this->security->getUser()) {
            return $this->redirectToRoute('app_avisos_index');
        }

        // Crear el formulario de login
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener los datos del formulario
            $data = $form->getData();
            $username = $data['_username'];
            $password = $data['_password'];

            // Buscar al usuario en la base de datos por el nombre de usuario
            $user = $usuariosRepository->findOneBy(['usuario' => $username]);

            // Verificar si el usuario y la contraseña son correctos
            if ($user && $this->passwordHasher->isPasswordValid($user, $password)) {
                // Usuario y contraseña correctos, redirigir al usuario a la página de avisos
                return $this->redirectToRoute('app_avisos_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Usuario y/o contraseña incorrectos, mostrar un mensaje de error genérico
                return $this->render('login/login.html.twig', [
                    'error_message' => 'Credenciales incorrectas',
                    'form' => $form->createView(),
                ]);
            }
        }

        // Si se está accediendo a la página de inicio de sesión a través de GET, simplemente muestra el formulario de inicio de sesión
        return $this->render('login/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
