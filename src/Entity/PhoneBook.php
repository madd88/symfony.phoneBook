<?php

namespace App\Entity;

use App\Repository\PhoneBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PhoneBookRepository::class)
 */
class PhoneBook
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min="2",
     *     max="255",
     *     maxMessage="Максимальная длина не должна превышать 255 символов",
     *     minMessage="Слишком короткое имя"
     * )
     *
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *     pattern="/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/",
     *     match=true,
     *     message="Неверный формат телефона"
     * )
     */

    private $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
