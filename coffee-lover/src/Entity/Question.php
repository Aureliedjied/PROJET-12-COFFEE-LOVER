<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
    private $text_question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextQuestion(): ?string
    {
        return $this->text_question;
    }

    public function setTextQuestion(string $text_question): self
    {
        $this->text_question = $text_question;

        return $this;
    }
}
