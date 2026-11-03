<?php
namespace iutnc\touiteur\touite;

class Tag{

    private ?int $id = null;
    private string $libelle;
    private ?string $description;

    public function __construct(string $libelle, ?string $description = null, ?int $id = null){
        $this->libelle = $libelle;  
        $this->description = $description;
        $this->id = $id;
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getLibelle(): string{
        return $this->libelle;
    }

    public function getDescription(): ?string{
        return $this->description;
    }


    public function setId(int $id): void{
        $this->id = $id;
    }

    public function setDescription(?string $description): void{
        $this->description = $description;
    }
}