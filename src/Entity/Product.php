<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * @see http://schema.org/Product Documentation on Schema.org
 *
 * @ORM\Entity
 * @Vich\Uploadable
 * @ApiResource(iri="http://schema.org/Product",normalizationContext={"groups"={"read"}},denormalizationContext={"groups"={"write"}})
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "name": "partial", "description": "partial"})
 * @ApiFilter(OrderFilter::class, properties={"id", "name"}, arguments={"orderParameterName"="order"})
 * @ApiFilter(ExistsFilter::class, properties={"image"})
 */
class Product
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @var string the name of the item
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/name")
     * @Assert\NotNull
     * @Groups({"read","write"})
     */
    private $name;

    /**
     * @var string a description of the item
     *
     * @ORM\Column(type="text")
     * @ApiProperty(iri="http://schema.org/description")
     * @Assert\NotNull
     * @Groups({"read","write"})
     */
    private $description;

    /**
     * @var string|null An image of the item. This can be a \[\[URL\]\] or a fully described \[\[ImageObject\]\].
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"read","write"})
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Offer::class, mappedBy="product",cascade={"remove","persist"})
     * @Groups({"read","write"})
     * @ApiProperty(attributes={"fetchEager": true})
     */
    private $offers;

    public function __construct()
    {
        $this->updatedAt = new \DateTime('now');
        $this->offers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setProduct($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getProduct() === $this) {
                $offer->setProduct(null);
            }
        }

        return $this;
    }
}
