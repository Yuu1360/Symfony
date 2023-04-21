<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Provincias
 *
 * @ORM\Table(name="provincias")
 * @ORM\Entity
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "openapi_context"={
 *                  "summary"="Devuelve una coleccion de Provincias"
 *              }
 *          },
 *          "post"={
 *              "openapi_context"={
 *                  "summary"="Crea una nueva Provincias"
 *              }
 *          },
 *      },
 *      itemOperations={
 *         "get"={
 *              "openapi_context"={
 *                  "summary"="Devuelve una Provincia"
 *              }
 *          },
 *          "put"={
 *              "openapi_context"={
 *                  "summary"="Edita una Provincia"
 *              }
 *          },
 *          "delete"={
 *              "openapi_context"={
 *                  "summary"="Borra una Provincia"
 *              }
 *          }
 *      },
 *      normalizationContext={
 *          "groups"={"provincias:read"},
 *          "swagger_definition_name"="Read"
 *      },
 *      denormalizationContext={
 *          "groups"={"provincias:write"},
 *          "swagger_definition_name"="Write"
 *      },
 * )
 * @ApiFilter(
 *      SearchFilter::class,
 *      properties={"nombre"= "partial"}
 * )
 */
class Provincias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"provincias:read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     * @Groups({"provincias:read", "provincias:write", "empleados:read"})
     * @Assert\NotBlank(message="El Campo Nombre No Puede Estar En Blanco")
     * @Assert\Length(
     *      min=2,
     *      max=45,
     *      minMessage="El Nombre Tiene un Minimo de 2 Caracteres",
     *      maxMessage="El Nombre Tiene un Maximo de 45 Caracteres"
     * )
     */
    private $nombre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }


}
