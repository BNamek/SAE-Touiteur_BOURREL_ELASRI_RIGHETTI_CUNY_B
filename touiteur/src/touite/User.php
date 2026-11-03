<?php
namespace iutnc\touiteur\touite;

class User{


    private ?int $id = null;
    private string $nom;
    private string $prenom;
    private string $email;
    private int $nbTouites = 0;


    public function __construct(string $nom, string $prenom, string $email, int $nbTouites = 0, ?int $id = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->nbTouites = $nbTouites;
        $this->id = $id;
    }


    public function getId(): ?int{
        return $this->id;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getPrenom(): string{
        return $this->prenom;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getNbTouites(): int{
        return $this->nbTouites;
    }


    public function setId(int $id): void{
        $this->id = $id;
    }

    public function setNbTouites(int $nbTouites): void{
        $this->nbTouites = $nbTouites;
    }

}


