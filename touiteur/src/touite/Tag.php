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
    
    public static function extraireTags(string $texte): array {

        $tags = [];
        $tag = '';
        $lectureTag = false;

        //on parcourt avec un for each chaque caractere du texte
        foreach (str_split($texte . ' ') as $caractere) {

            //on verifie si le caractere appartient a un tag
            $estValide =
                ($caractere >= 'a' && $caractere <= 'z') ||
                ($caractere >= 'A' && $caractere <= 'Z') ||
                ($caractere >= '0' && $caractere <= '9') ||
                ($caractere === '_');

            if ($lectureTag) {

                if ($estValide) {
                    //on ajoute le caractere au tag
                    $tag .= strtoupper($caractere);

                } else {

                    //on enregistre le tag s'il est valide
                    if (strlen($tag) > 1 && strlen($tag) <= 100) {
                        $tags[$tag] = $tag;
                    }

                    $lectureTag = false;
                    $tag = '';

                    //un nouveau tag peut commencer directement
                    if ($caractere === '#') {
                        $lectureTag = true;
                        $tag = '#';
                    }
                }

            } elseif ($caractere === '#') {

                // On commence la lecture d'un tag
                $lectureTag = true;
                $tag = '#';
            }
        }

        return $tags;
    }
}