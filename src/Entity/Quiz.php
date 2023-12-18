<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Play::class, mappedBy="quiz")
     */
    private $play;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quiz")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, inversedBy="quizzes")
     *@ORM\JoinTable(name="quiz_question")
     */
    private $questions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    public function __construct()
    {
        $this->play = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Play>
     */
    public function getPlay(): Collection
    {
        return $this->play;
    }

    public function addPlay(Play $play): self
    {
        if (!$this->play->contains($play)) {
            $this->play[] = $play;
            $play->setQuiz($this);
        }

        return $this;
    }

    public function removePlay(Play $play): self
    {
        if ($this->play->removeElement($play)) {
            // set the owning side to null (unless already changed)
            if ($play->getQuiz() === $this) {
                $play->setQuiz(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            if (!$question->getQuizzes()->contains($this)) {
                $question->addQuiz($this);
            }
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        $this->questions->removeElement($question);

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
