<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{
    // Table de la base de donnee
    protected $table;

    // instance de db pour creer la connexion
    private $db;

    protected function requete(string $sql, array $attributs = null)
    {
        // on recupere l'instance de db
        $this->db = Db::getInstance();

        // on verifie si on a des attributs
        if ($attributs !== null) {
            // requete prepare
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // requete simple
            return $this->db->query($sql);
        }
    }

    // on cree les methodes CRUD

    public function findAll()
    {
        $query = $this->requete('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];

        // on boucle pour eclater le tableau
        foreach ($criteres as $champ => $valeur) {
            // select * from annonces where actif = ? and titre = ?
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $liste_champs = implode(' AND ', $champs);

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs;

        $query = $this->requete($sql, $valeurs);

        return $query->fetch();
    }

    public function findById(int $id)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';
        return $this->requete($sql, [$id])->fetch();
    }

    public function create()
    {
        $champs = [];
        $valeurs = [];
        $liste_inter = [];

        foreach ($this as $champ => $valeur) {
            // INSERT INTO annonces (titre, description, actif) VALUES (?,?,?)
            if ($champ !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = '?';
                $valeurs[] = $valeur;
            }
        }

        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(',', $inter);

        $sql = 'INSERT INTO ' . $this->table . ' (' . $liste_champs . ')' . ' VALUES (' . $liste_inter . ')';

        $this->requete($sql, $valeurs);
    }

    public function update(int $id)
    {
        $champs = [];
        $valeurs = [];

        foreach ($this as $champ => $valeur) {
            // update annonces set titre = ?, description = ? where id = ?
            if ($valeur !== null && $champ != null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }

        $valeurs[] = $this->id;

        $liste_champs = implode(', ', $champs);

        $sql = 'UPDATE annonces SET ' . $liste_champs . ' WHERE id = ?';

        $this->requete($sql, $valeurs);
    }

    public function delete(int $id)
    {
        // delete from annonces where id = ?
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $this->requete($sql, [$id]);
    }

    public function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {

            // on recupere le nom du setter correspondant a la cle
            // titre -> setTitre
            $setter = 'set' . ucfirst($key);

            // on verifie si le setter existe
            if (method_exists($this, $setter)) {
                // on appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }
}
