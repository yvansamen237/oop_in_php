<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;

class AnnoncesController extends Controller
{
    /**
     * cette methode affichera une page listant toutes les annonces de la base de donnees
     * @return void
     */
    public function index()
    {
        // on instancie le modele correspondant a la table annonce de la base de donnees
        $annoncesModel = new AnnoncesModel;

        // on va chercher toutes les annonces actives
        $annonces = $annoncesModel->findAll();

        $this->render('annonces/index',compact('annonces'));


        /*echo '<pre>';
        print_r($annonces);
        echo '</pre>';*/
    }


    /**
     * Affice 1 annonce
     * @param int $id Id de l'annonce
     * @return void
     */
    public function lire(int $id)
    {
        // on instancie le modele
        $annoncesModel = new AnnoncesModel;

        // on va chercher une annonce
        $annonce = $annoncesModel->findById($id);

        // on envoie a la vue
        $this->render('annonces/lire', compact('annonce')); 
    }
}