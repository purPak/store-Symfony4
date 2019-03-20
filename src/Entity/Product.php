<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     *  @Assert\Type(
     *     type="string",
     *     message="Le nom du produit doit être une chaine de caractères"
     * )
     * @Assert\Length(
     *     min=4,
     *     max=50,
     *     minMessage="Le nom doit comporter au moins {{ limit }} caractères",
     *     maxMessage="Le nom doit comporter maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Type(
     *     type="string",
     *     message="La description du produit doit être une chaine de caractères"
     * )
     * @Assert\Length(
     *     min=4,
     *     max=500,
     *     minMessage="La description doit comporter au moins {{ limit }} caractères",
     *     maxMessage="La description doit comporter maximum {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Assert\Regex("/^\d+([.]{1}\d{1,2})?$/")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbViews;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(
     *     type="bool"
     * )
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_img", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="products")
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $slug;

    public function __construct()
    {
        $this->nbViews = 0;
        $this->tags = new ArrayCollection();
    }

    /**
     * On met à jour la champ "updatedAt" APRES chaque "modification (update)"
     * @ORM\PostUpdate
     */
    public function postUpdate()
    {
        $this->updatedAt = new \Datetime();
    }

    /**
     * On initialise le champ "createdAt" AVANT "l'ajout (persist)" en BDD
     * @ORM\PrePersist
     */
    public function initializeCreatedAt()
    {
        $this->createdAt = new \DateTime();
        $this->slugifyName();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateSlug()
    {
        $this->slugifyName();
    }

    public function getId()
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNbViews(): ?int
    {
        return $this->nbViews;
    }

    public function setNbViews(int $nbViews): self
    {
        $this->nbViews = $nbViews;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @throws \Exception
     */
    public function setImageFile(?File $image = null): void
    {
        $this->imageFile = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function slugifyName()
    {
        $slugger = new Slugify();
        $this->slug = $slugger->slugify($this->name);
    }
}
