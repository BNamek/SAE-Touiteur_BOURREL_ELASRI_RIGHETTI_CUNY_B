<?php
namespace iutnc\touiteur\touite;

class Touite{

    private ?int $id = null;
    private string $texte;
    private string $datePublication;
    private int $idAuteur;
    private int $note = 0;
    private string $nom = '';
    private string $prenom = '';

    public function __construct(string $texte, int $idAuteur, string $datePublication = '', int $note = 0, ?int $id = null){
        if (mb_strlen($texte) > 235) {
            throw new \InvalidArgumentException("Message trop long");
        }
        $this->texte = $texte;
        
        $this->idAuteur = $idAuteur;

        if($datePublication === ''){
            $this->datePublication = date('Y-m-d H:i:s');
        }else{
            $this->datePublication = $datePublication;
        }
        
        $this->note = $note;
        $this->id = $id;
    }


    public function getId(): ?int{
        return $this->id;
    }

    public function getTexte(): string{
        return $this->texte;
    }

    public function getDatePublication(): string{
        return $this->datePublication;
    }
    
    public function getIdAuteur(): int{
        return $this->idAuteur;
    }

    public function getNote(): int{
        return $this->note;
    }


    public function setId(int $id): void{
        $this->id = $id;
    }

    public function setNote(int $note): void{
        $this->note = $note;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getPrenom(): string {
        return $this->prenom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }

}
