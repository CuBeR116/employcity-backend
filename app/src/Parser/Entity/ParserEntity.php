<?php

namespace App\Parser\Entity;

use App\Parser\Repository\ParserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParserRepository::class)
 */
class ParserEntity
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
    private $site;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $length;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemNode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameNode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkNode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateNode;

    /**
     * @ORM\OneToOne(targetEntity=NewsParser::class, mappedBy="Parser", cascade={"persist", "remove"})
     */
    private $newsParser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getItemNode(): ?string
    {
        return $this->itemNode;
    }

    public function setItemNode(string $item_node): self
    {
        $this->itemNode = $item_node;

        return $this;
    }

    public function getNameNode(): ?string
    {
        return $this->nameNode;
    }

    public function setNameNode(string $name_node): self
    {
        $this->nameNode = $name_node;

        return $this;
    }

    public function getLinkNode(): ?string
    {
        return $this->linkNode;
    }

    public function setLinkNode(string $link_node): self
    {
        $this->linkNode = $link_node;

        return $this;
    }

    public function getDateNode(): ?string
    {
        return $this->dateNode;
    }

    public function setDateNode(string $date_node): self
    {
        $this->dateNode = $date_node;

        return $this;
    }

    public function getNewsParser(): ?NewsParserEntity
    {
        return $this->newsParser;
    }

    public function setNewsParser(NewsParserEntity $newsParser): self
    {
        // set the owning side of the relation if necessary
        if ($newsParser->getParser() !== $this) {
            $newsParser->setParser($this);
        }

        $this->newsParser = $newsParser;

        return $this;
    }
}
