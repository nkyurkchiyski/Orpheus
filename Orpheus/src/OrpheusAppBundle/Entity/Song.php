<?php

namespace OrpheusAppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="songs")
 * @ORM\Entity(repositoryClass="OrpheusAppBundle\Repository\SongRepository")
 */
class Song
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="bigint")
     */
    private $playedCount;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\Regex(
     *     pattern="/^(http|https).+/",
     *     message="The cover art url has to start with http or https"
     * )
     */
    private $coverArtUrl;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\Regex(
     *     pattern="/^(http|https).+/",
     *     message="The song url has to start with http or https"
     * )
     */
    private $songUrl;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="songs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="songs")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     */
    private $genre;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Playlist",mappedBy="songs")
     */
    private $playlists;

    /**
     * @ORM\ManyToOne(targetEntity="Artist", inversedBy="songs")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     */
    private $artist;

    /**
     * @var integer
     */
    private $likes;

    public function __construct()
    {
        $this->dateAdded = new \DateTime('now');
        $this->playedCount = 0;
        $this->playlists = new ArrayCollection();
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
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

    public function getPlayedCount(): ?int
    {
        return $this->playedCount;
    }

    public function setPlayedCount(int $playedCount): self
    {
        $this->playedCount = $playedCount;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getDateAdded(): \DateTime
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTime $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getCoverArtUrl(): ?string
    {
        return $this->coverArtUrl;
    }

    public function setCoverArtUrl($coverArtUrl): self
    {
        $this->coverArtUrl = $coverArtUrl;

        return $this;
    }

    public function getPlaylists():Collection
    {
        return $this->playlists;
    }

    public function getSongUrl():?string
    {
        return $this->songUrl;
    }

    public function setSongUrl(string $songUrl): self
    {
        $this->songUrl = $songUrl;

        return $this;
    }

    public function getUser():?User
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLikes(): int
    {
        if ($this->likes === null)
        {
            $this->setLikes();
        }

        return $this->likes;
    }

    public function setLikes(): void
    {
        $count = $this->playlists->filter(function ($playlist){
            return $playlist->getName() === "Liked";
        })->count();

        $this->likes = $count;
    }

}
