<?php

namespace App\Parser\Entity;

use App\Parser\Repository\NewsParserRepository;
use Doctrine\ORM\Mapping as ORM;
use \App\News\Entity\NewsEntity;

/**
 * @ORM\Entity(repositoryClass=NewsParserRepository::class)
 */
class NewsParserEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=NewsEntity::class, inversedBy="parser_id", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $newsId;

    /**
     * @ORM\OneToOne(targetEntity=Parser::class, inversedBy="newsParser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $parser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $source;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewsId(): ?NewsEntity
    {
        return $this->newsId;
    }

    public function setNewsId(NewsEntity $newsId): self
    {
        $this->newsId = $newsId;

        return $this;
    }

    public function getParser(): ?ParserEntity
    {
        return $this->parser;
    }

    public function setParser(ParserEntity $parser): self
    {
        $this->parser = $parser;

        return $this;
    }
}
