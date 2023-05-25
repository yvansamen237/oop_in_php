<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;

class UsersController extends Controller
{
    /**
     * connexion des utilisateurs
     *
     * @return void
     */
    public function login()
    {
        // on verifie si le formulaire est complet
        if (Form::validate($_POST, ['email', 'password'])) {
            // on va chercher dans la base de donnee l'utilisateur avec l'eamil rentre
            $usersModel = new UsersModel;
            $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));

            // si l'utilisateur n'existe pas
            if (!$userArray) {
                // on envoi un message de session
                $_SESSION['erreur'] = 'L\'adresse email et ou le mot de passe est incorrect';
                header('Location:/users/login');
                exit;
            }

            // l'utilisateur existe
            $user = $usersModel->hydrate($userArray);

            // on verifie si le mot de passe est correct
            if (password_verify($_POST['password'], $user->getPassword())) {
                // le mot de passe est bon
                // on cree la session
                $user->setSession();
                header('Location: /');
                exit;
            } else {
                // on envoi un message de session
                $_SESSION['erreur'] = 'L\'adresse email et ou le mot de passe est incorrect';
                header('Location:/users/login');
                exit;
            }
        }

        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail')
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email'])
            ->ajoutLabelFor('pass', 'Mot de passe')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('Me connecter', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('users/login', ['loginForm' => $form->create()]);
    }

    /**
     * inscription des utilisateurs
     *
     * @return void
     */
    public function register()
    {
        // on verifie si le formulaire est valide
        if (Form::validate($_POST, ['email', 'password'])) {
            // le formulaire est valide
            // on nettoie l'adresse mail
            $email = strip_tags($_POST['email']);

            // on chiffre le mot de passe 
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            // on hydrate l'utilisateur 

            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass);

            $user->create();
        }
        $form = new Form;

        $form->debutForm()
            ->ajoutLabelFor('email', 'E-mail :')
            ->ajoutInput('email', 'email', ['id' => 'email', 'class' => 'form-control'])
            ->ajoutLabelFor('pass', 'mot de passe')
            ->ajoutInput('password', 'password', ['id' => 'pass', 'class' => 'form-control'])
            ->ajoutBouton('m\'inscrire', ['class' => 'btn btn-primary'])
            ->finForm();

        $this->render('users/register', ['registerForm' => $form->create()]);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
