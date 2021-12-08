<?php

namespace App\News\Entity;

use DateTimeImmutable;
use App\Parser\Entity\NewsParserEntity;
use App\News\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 */
class NewsEntity
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
     * @ORM\Column(type="string", length=255)
     */
    private $plug;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\OneToOne(targetEntity=NewsParser::class, mappedBy="news_id", cascade={"persist", "remove"})
     */
    private $parser_id;

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

    public function getPlug(): ?string
    {
        return $this->plug;
    }

    public function setPlug(string $plug): self
    {
        $this->plug = $plug;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getParserId(): ?NewsParserEntity
    {
        return $this->parser_id;
    }

    public function setParserId(NewsParser $parser_id): self
    {
        // set the owning side of the relation if necessary
        if ($parser_id->getNewsId() !== $this) {
            $parser_id->setNewsId($this);
        }

        $this->parser_id = $parser_id;

        return $this;
    }
}
