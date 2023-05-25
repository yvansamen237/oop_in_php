<?php

namespace App\Core;

class Form 
{
    protected $formCode ='';

    /**
     * genere le formulaire HTML
     * @return string
     */
    public function create()
    {
       return $this->formCode;
    }

    /**
     * valide si tous les champs propose sont rempli
     * @param array $form Tableau issu du formulaire
     * @param array $champs Tableau listant les champs obligatoire  
     * @return bool
     */
    public static function validate(array $form, array $champs){
        // on parcours les champs
        foreach($champs as $champ){
            // si le champ est absent ou vide
            if(!isset($form[$champ]) || empty($form[$champ])){
                // on sort en retournant false
                return false;
            } 
            return true;
        }
    }


    /**
     * Ajoute les attributs envoyes a la balise
     *
     * @param array $attributs tableau associatif ['class'=>'form-control']
     * @return string chaine de caracteres genere
     */
    private function ajoutAttributs(array $attributs): string
    {
        // on instancie une chaine de caractere
        $str = '';

        // on liste les attributs courts
        $courts = ['checked','disabled','readonly','multiple','autofocus','novalidate','formnovalidate'];

        // on boucle sur le tableau d'attributs
        foreach($attributs as $attribut => $valeur){
            // si l'attribut est dans la liste des attributs courts
            if(in_array($attribut, $courts) && $valeur == true){
                $str .= " $attribut";
            }else{
                // on ajoute attribut='valeur'
                $str .=" $attribut='$valeur'";
            }
        }
        
        return $str;
    }


    /**
     * Balise d'ouverture du formulaire
     *
     * @param string $methode methode du formulaire (post ou get)
     * @param string $action action du formulaire
     * @param array $attributs Attributs
     * @return Form
     */
    public function debutForm(string $methode = 'post', string $action ='#', array $attributs = []): self
    {
        // on cree la balise form
        $this->formCode .= "<form action='$action' method='$methode'";

        //  on ajoute les attributs eventuels
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        return $this;
    }

    /**
     * balise de fermeture du formulaire
     *
     * @return Form
     */
    public function finForm():self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    public function ajoutLabelFor(string $for, string $texte, array $attributs = []): self
    {
        // on ouvre la balise
        $this->formCode .= "<label for='$for'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // on ajoute le texte
        $this->formCode .= ">$texte</label>";
        
        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs = []):self
    {
        // on ouvre la balise 
        $this->formCode .= "<input type='$type' name='$nom'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';
        return $this;
    }

    public function ajoutTextarea(string $nom, string $valeur = '', array $attributs =[]): self
    {
        // on ouvre la balise
        $this->formCode .= "<textarea name='$nom'";

        // on ajoute les attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';

        // on ajoute le texte
        $this->formCode .= ">$valeur</textarea>";
        
        return $this;
    }

    public function ajoutSelect(string $nom, array $options, array $attributs = []): self
    {
        // on cree le select
        $this->formCode .= "<select name='$nom'";

        // on ajoute des attributs
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs).'>' : '>';

        // on ajoute les options
        foreach($options as $valeur => $texte){
            $this->formCode .= "<option value='$valeur'>$texte</option>";
        }

        // on ferme le select
        $this->formCode .= '</select';
        return $this;
    }

    public function ajoutBouton(string $texte, array $attributs = []): self
    {
        $this->formCode .= '<button ';
        $this->formCode .= $attributs ? $this->ajoutAttributs($attributs) : '';
        $this->formCode .= ">$texte</button>";

        return $this;
    }
}