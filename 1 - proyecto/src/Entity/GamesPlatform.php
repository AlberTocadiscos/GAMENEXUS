<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GamesPlatform
 *
 * @ORM\Table(name="games_platform", indexes={@ORM\Index(name="FK6", columns={"id_platform"}), @ORM\Index(name="FK20", columns={"id_feature"}), @ORM\Index(name="FK5", columns={"game_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\GamesPlatformRepository")
 */
class GamesPlatform
{
    /**
     * @var \Features::class
     *
     * @ORM\ManyToOne(targetEntity="Features")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_feature", referencedColumnName="id_feature")
     * })
     */
    private $idFeature;

    /**
     * @var \Platforms::class
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Platforms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_platform", referencedColumnName="id_platform")
     * })
     */
    private $idPlatform;

    /**
     * @var \Games::class
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="game_id", referencedColumnName="id_game")
     * })
     */
    private $game;

    public function getIdFeature(): ?Features
    {
        return $this->idFeature;
    }

    public function setIdFeature(?Features $idFeature): self
    {
        $this->idFeature = $idFeature;

        return $this;
    }

    public function getIdPlatform(): ?Platforms
    {
        return $this->idPlatform;
    }

    public function setIdPlatform(?Platforms $idPlatform): self
    {
        $this->idPlatform = $idPlatform;

        return $this;
    }

    public function getGame(): ?Games
    {
        return $this->game;
    }

    public function setGame(?Games $game): self
    {
        $this->game = $game;

        return $this;
    }


}
