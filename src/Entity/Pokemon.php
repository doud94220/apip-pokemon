<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PokemonRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

// Quand l'utilisateur veut modifier un champ en "readonly" il ne peut pas mais recoit un code 200 dans Postman. Bizarre. A creuser.

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 * @ApiResource(
 *     collectionOperations={"GET", "POST"},
 *     itemOperations={"GET", "PUT", "PATCH", "DELETE"},
 *     normalizationContext={"groups"={"pokemon_read"}},
 *     denormalizationContext={"groups"={"pokemon_write"}}          
 *             )
 * @ApiFilter(SearchFilter::class, properties={"name": "exact", "type1": "exact", "type2": "exact", "legendary": "exact", "generation": "exact"})
 * @Assert\Expression("this.getlegendary() in ['0']", message="ON NE PEUT PAS MODIFIER UN POKEMON LEGENDAIRE")
 */
class Pokemon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"pokemon_read", "pokemon_write"});
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"pokemon_read", "pokemon_write"})
     * @Assert\Choice(choices={"Fire","Water","Bug","Normal","Poison","Electric","Ground","Fairy","Grass","Fighting","Psychic","Rock","Ghost","Ice","Dragon","Dark","Steel","Flying"}, message="Merci de choisir un type1 parmi les 17 valeurs possibles")
     */
    private $type1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"pokemon_read", "pokemon_write"})
     * @Assert\Choice(choices={"Fire","Water","Bug","Normal","Poison","Electric","Ground","Fairy","Grass","Fighting","Psychic","Rock","Ghost","Ice","Dragon","Dark","Steel","Flying",""}, message="Merci de choisir un type1 parmi les 18 valeurs possibles")
     */
    private $type2;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $attack;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $defense;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $sp_atk;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $sp_def;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $speed;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read", "pokemon_write"});
     */
    private $generation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"pokemon_read", "pokemon_write"});
     */
    private $legendary;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"pokemon_read"})
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(string $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getSpAtk(): ?int
    {
        return $this->sp_atk;
    }

    public function setSpAtk(int $sp_atk): self
    {
        $this->sp_atk = $sp_atk;

        return $this;
    }

    public function getSpDef(): ?int
    {
        return $this->sp_def;
    }

    public function setSpDef(int $sp_def): self
    {
        $this->sp_def = $sp_def;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    public function setGeneration(int $generation): self
    {
        $this->generation = $generation;

        return $this;
    }

    public function getLegendary(): ?bool
    {
        return $this->legendary;
    }

    public function setLegendary(bool $legendary): self
    {
        $this->legendary = $legendary;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
