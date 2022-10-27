<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Triks::class, mappedBy="groupes")
     */
    private $triks;

    public function __construct()
    {
        $this->triks = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name ;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Triks>
     */
    public function getTriks(): Collection
    {
        return $this->triks;
    }

    public function addTrik(Triks $trik): self
    {
        if (!$this->triks->contains($trik)) {
            $this->triks[] = $trik;
            $trik->setGroupes($this);
        }

        return $this;
    }

    public function removeTrik(Triks $trik): self
    {
        if ($this->triks->removeElement($trik)) {
            // set the owning side to null (unless already changed)
            if ($trik->getGroupes() === $this) {
                $trik->setGroupes(null);
            }
        }

        return $this;
    }
}
