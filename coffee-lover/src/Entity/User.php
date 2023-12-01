<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="User")
     */
    private $articles;

    /**
     * @ORM\ManyToMany(targetEntity=Reward::class, inversedBy="users")
     */
    private $reward;

    /**
     * @ORM\OneToMany(targetEntity=Play::class, mappedBy="user")
     */
    private $play;

    /**
     * @ORM\OneToMany(targetEntity=Quiz::class, mappedBy="user")
     */
    private $quiz;





    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->reward = new ArrayCollection();
        $this->play = new ArrayCollection();
        $this->quiz = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getReward(): Collection
    {
        return $this->reward;
    }

    public function addReward(Reward $reward): self
    {
        if (!$this->reward->contains($reward)) {
            $this->reward[] = $reward;
        }

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        $this->reward->removeElement($reward);

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
            $play->setUser($this);
        }

        return $this;
    }

    public function removePlay(Play $play): self
    {
        if ($this->play->removeElement($play)) {
            // set the owning side to null (unless already changed)
            if ($play->getUser() === $this) {
                $play->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuiz(): Collection
    {
        return $this->quiz;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quiz->contains($quiz)) {
            $this->quiz[] = $quiz;
            $quiz->setUser($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quiz->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getUser() === $this) {
                $quiz->setUser(null);
            }
        }

        return $this;
    }
}
