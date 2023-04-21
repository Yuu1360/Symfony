<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CentrosTrabajo
 *
 * @ORM\Table(
 *      name="centros_trabajo", 
 *      indexes={
 *          @ORM\Index(
 *              name="fk_id_provincia_cent_trab_idx", 
 *              columns={"provincia"}
 *          )
 *      }
 * )
 * @ORM\Entity
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "openapi_context"={
 *                  "summary"="Devuelve una coleccion de Centros de Trabajo"
 *              }
 *          },
 *          "post"={
 *              "openapi_context"={
 *                  "summary"="Crea un nuevo Centro de Trabajo"
 *              }
 *          },
 *      },
 *      itemOperations={
 *         "get"={
 *              "openapi_context"={
 *                  "summary"="Devuelve un Centro de Trabajo"
 *              }
 *          },
 *          "put"={
 *              "openapi_context"={
 *                  "summary"="Edita un Centro de Trabajo"
 *              }
 *          },
 *          "delete"={
 *              "openapi_context"={
 *                  "summary"="Borra un Centro de Trabajo"
 *              }
 *          }
 *      },
 *      normalizationContext={
 *          "groups"={"centroTrabajo:read"},
 *          "swagger_definition_name"="Read"
 *      },
 *      denormalizationContext={
 *          "groups"={"centroTrabajo:write"},
 *          "swagger_definition_name"="Write"
 *      },
 * )
 * @ApiFilter(
 *      SearchFilter::class,
 *      properties={
 *          "nombre" = "partial",
 *          "direccion" = "partial",
 *          "ciudad" = "partial",
 *          "codigoPostal" = "exact",
 *          "telefono" = "partial",
 *          "provincia" = "exact",
 *      }
 * )
 * @ApiFilter(
 *      OrderFilter::class,
 *      properties={
 *          "nombre"="ASC",
 *          "direccion"="ASC",
 *          "provincia"="ASC",
 *      },
 *      arguments={"orderParameterName"="order"}
 * )
 */
class CentrosTrabajo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"centroTrabajo:read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @Assert\NotBlank(message="El Campo Nombre No Puede Estar En Blanco")
     * @Assert\Length(
     *      min=2,
     *      max=45,
     *      minMessage="El Nombre Tiene un Minimo de 2 Caracteres",
     *      maxMessage="El Nombre Tiene un Maximo de 45 Caracteres"
     * )
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=45, nullable=false)
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @Assert\NotBlank(message="El Campo Direccion No Puede Estar En Blanco")
     * @Assert\Length(
     *      min=2,
     *      max=45,
     *      minMessage="La Direccion Tiene un Minimo de 2 Caracteres",
     *      maxMessage="La Direccion Tiene un Maximo de 45 Caracteres"
     * )
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_postal", type="string", length=45, nullable=false)
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @Assert\NotBlank(message="El Campo Codigo Postal No Puede Estar En Blanco")
     * @Assert\Length(
     *      min=4,
     *      max=5,
     *      maxMessage="El Codigo Postal Tiene un Maximo de 5 Caracteres",
     *      minMessage="El Codigo Postal Tiene un Minimo de 4 Caracteres"
     * )
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=45, nullable=false)
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @Assert\NotBlank(message="El Campo Ciudad No Puede Estar En Blanco")
     * @Assert\Length(
     *      min=2,
     *      max=45,
     *      minMessage="La Ciudad Tiene un Minimo de 2 Caracteres",
     *      maxMessage="La Ciudad Tiene un Maximo de 45 Caracteres"
     * )
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=45, nullable=false)
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @Assert\NotBlank(message="El Campo Telefono No Puede Estar En Blanco")
     */
    private $telefono;

    /**
     * @var null|Provincias
     *
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="provincia", referencedColumnName="id")
     * })
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @Assert\NotBlank(message="El Campo Provincia No Puede Estar En Blanco")
     */
    private $provincia;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Empleados", mappedBy="idCentroTrabajo")
     * @Groups({"centroTrabajo:read", "centroTrabajo:write"})
     * @ApiSubresource(maxDepth=1)
     */
    private $idEmpleado = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEmpleado = new ArrayCollection();
    }

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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getProvincia(): ?Provincias
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincias $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return Collection<int, Empleados>
     */
    public function getIdEmpleado(): Collection
    {
        return $this->idEmpleado;
    }

    public function addIdEmpleado(Empleados $idEmpleado): self
    {
        if (!$this->idEmpleado->contains($idEmpleado)) {
            $this->idEmpleado[] = $idEmpleado;
            $idEmpleado->addIdCentroTrabajo($this);
        }

        return $this;
    }

    public function removeIdEmpleado(Empleados $idEmpleado): self
    {
        if ($this->idEmpleado->removeElement($idEmpleado)) {
            $idEmpleado->removeIdCentroTrabajo($this);
        }

        return $this;
    }

}
