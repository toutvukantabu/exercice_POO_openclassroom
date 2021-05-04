<?php

namespace App\Classes\Personnage;

use DateTime;


class Personnage

{
  private $_degats,
    $_id,
    $_nom,
    $_experience,
    $_niveau,
    $_nbcoups,
    $_dateDernierCoup,
    $_dateDerniereConnexion;

  const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
  const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
  const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
  const PAS_AUJOURDHUI = 4; // Constante annonçant que l'on ne peut pas frapper aujourd'hui 
  const BRAVO_VOUS_AVEZ_GAGNER_UN_NIVEAU = 5;
  // METHOD //

  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }

  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value) {
      $method = 'set' . ucfirst($key);

      if (method_exists($this, $method)) {
        $this->$method($value);
      }
    }
  }

  public function frapper(Personnage $perso)
  {
    if ($perso->id() == $this->_id) {
      return self::CEST_MOI;
    }

    $DateNow = new DateTime('Now');

    $diff = $this->dateDernierCoup->diff($DateNow);

    $diff->format("%a:%h:%i:%s");

    if ($this->nbcoups() >= 3 && $diff->d <= 0 && $diff->h <= 23) {

      return self::PAS_AUJOURDHUI;

    } else {
      $this->setdateDernierCoup($DateNow);

      $this->setNbcoups($this->nbCoups() + 1);

      $this->setExperience($this->experience() +1);
      
      return $perso->recevoirDegats();
    }
  }

  public function recevoirDegats()
  {
    $this->_degats += 5;

    if ($this->_degats >= 100) {

      return self::PERSONNAGE_TUE;
    }
    return self::PERSONNAGE_FRAPPE;
  }


  // GETTERS //

  public function degats()
  {
    return $this->_degats;
  }

  public function id()
  {
    return $this->_id;
  }

  public function nom()
  {
    return $this->_nom;
  }

  public function experience()
  {
    return $this->_experience;
  }

  public function nbcoups()
  {
    return $this->_nbcoups;
  }

  public function niveau()
  {
    return $this->_niveau;
  }

  public function dateDernierCoup()
  {
    return $this->_dateDernierCoup;
  }

  public function dateDerniereConnexion()
  {
    return $this->_dateDerniereConnexion;
  }


  //SETTER //

  public function setDegats(int $degats)
  {
    if ($degats >= 0 && $degats <= 100) {
      $this->_degats = $degats;
    }
  }
  public function setNbCoups(int $_nbcoups)
  {
    if ($_nbcoups >= 0 && $_nbcoups <= 100) {
      $this->_nbcoups = $_nbcoups;
    }
  }

  public function setId(int $id)
  {
    if ($id > 0) {
      $this->_id = $id;
    }
  }

  public function setNom(string $nom)
  {
    $this->_nom = $nom;
  }

  public function nomValide()
  {

    return !empty( $this->_nom);
  }


  public function setDateDernierCoup()
  {
 
    $this->_dateDernierCoup;
  }
  
  public function setExperience(){

    $this->_experience;
  }

  public function setNiveau(int $lvl){

    $this->_niveau = $lvl;
  }
}
