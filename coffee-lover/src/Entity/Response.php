<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
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
    private $text_response;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_correct;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="response")
     */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextResponse(): ?string
    {
        return $this->text_response;
    }

    public function setTextResponse(string $text_response): self
    {
        $this->text_response = $text_response;

        return $this;
    }

    public function isIsCorrect(): ?bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(?bool $is_correct): self
    {
        $this->is_correct = $is_correct;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
