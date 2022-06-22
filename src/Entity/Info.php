<?php

namespace App\Entity;

use App\Repository\InfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoRepository::class)]
class Info
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_info;

    #[ORM\Column(type: 'string', length: 255)]
    private $code_info;

    #[ORM\Column(type: 'text')]
    private $qr_info;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomInfo(): ?string
    {
        return $this->nom_info;
    }

    public function setNomInfo(string $nom_info): self
    {
        $this->nom_info = $nom_info;

        return $this;
    }

    public function getCodeInfo(): ?string
    {
        return $this->code_info;
    }

    public function setCodeInfo(string $code_info): self
    {
        $this->code_info = $code_info;

        return $this;
    }

    public function getQrInfo(): ?string
    {
        return $this->qr_info;
    }

    public function setQrInfo(string $qr_info): self
    {
        $this->qr_info = $qr_info;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
