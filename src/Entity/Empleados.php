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
 * Empleados
 *
 * @ORM\Table(
 *      name="empleados", 
 *      indexes={
 *          @ORM\Index(
 *              name="fk_id_provincia_emp_idx", 
 *              columns={"provincia"}
 *          )
 *      }
 * )
 * @ORM\Entity
 * @ApiResource(
 *      collectionOperations={
 *          "get"={
 *              "openapi_context"={
 *                  "summary"="Devuelve una coleccion de Empleados"
 *              }
 *          },
 *          "post"={
 *              "openapi_context"={
 *                  "summary"="Crea un nuevo Empleado"
 *              }
 *          },
 *      },
 *      itemOperations={
 *         "get"={
 *              "openapi_context"={
 *                  "summary"="Devuelve un Empleado"
 *              }
 *          },
 *          "put"={
 *              "openapi_context"={
 *                  "summary"="Edita un Empleado"
 *              }
 *          },
 *          "delete"={
 *              "openapi_context"={
 *                  "summary"="Borra un Empleado"
 *              }
 *          }
 *      },
 *      normalizationContext={
 *          "groups"={"empleados:read"},
 *          "swagger_definition_name"="Read"
 *      },
 *      denormalizationContext={
 *          "groups"={"empleados:write"},
 *          "swagger_definition_name"="Write"
 *      },
 * )
 * @ApiFilter(
 *      SearchFilter::class,
 *      properties={
 *          "nombre" = "partial",
 *          "apellido1" = "partial",
 *          "dni" = "partial",
 *          "codigoPostal" = "exact",
 *          "provincia" = "exact",
 *      }
 * )
 * @ApiFilter(
 *      OrderFilter::class,
 *      properties={
 *          "nombre"="ASC",
 *          "apellido1"="ASC",
 *          "dni"="ASC",
 *          "provincia"="ASC",
 *      },
 *      arguments={"orderParameterName"="order"}
 * )
 */
class Empleados
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"empleados:read"})
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     * @Groups({"empleados:read", "empleados:write"})
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
     * @ORM\Column(name="apellido1", type="string", length=45, nullable=false)
     * @Groups({"empleados:read", "empleados:write"})
     * @Assert\NotBlank(message="El Campo Apellido 1 No Puede Estar En Blanco")
     * @Assert\Length(
     *      min=2,
     *      max=45,
     *      minMessage="El Apellido Tiene un Minimo de 2 Caracteres",
     *      maxMessage="El Apellido Tiene un Maximo de 45 Caracteres"
     * )
     */
    private $apellido1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido2", type="string", length=45, nullable=true)
     * @Groups({"empleados:read", "empleados:write"})
     * @Assert\Length(
     *      min=2,
     *      max=45,
     *      minMessage="El Segundo Apellido Tiene un Minimo de 2 Caracteres",
     *      maxMessage="El Segundo Apellido Tiene un Maximo de 45 Caracteres"
     * )
     */
    private $apellido2;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=45, nullable=false)
     * @Groups({"empleados:read", "empleados:write"})
     * @Assert\NotBlank(message="El Campo dni No Puede Estar En Blanco")
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=45, nullable=false)
     * @Groups({"empleados:read", "empleados:write"})
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
     * @ORM\Column(name="ciudad", type="string", length=45, nullable=false)
     * @Groups({"empleados:read", "empleados:write"})
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
     * @ORM\Column(name="codigo_postal", type="string", length=45, nullable=false)
     * @Groups({"empleados:read", "empleados:write"})
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     * @Groups({"empleados:read", "empleados:write"})
     * @Assert\NotBlank(message="El Campo Fecha de Nacimiento No Puede Estar En Blanco")
     */
    private $fechaNacimiento;

    /**
     * @var null|Provincias
     *
     * @ORM\ManyToOne(targetEntity="Provincias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="provincia", referencedColumnName="id")
     * })
     * @Groups({"empleados:read", "empleados:write"})
     * @Assert\NotBlank(message="El Campo Provincia No Puede Estar En Blanco")
     */
    private $provincia;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CentrosTrabajo", inversedBy="idEmpleado")
     * @ORM\JoinTable(name="empleados_centros_trabajo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_empleado", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_centro_trabajo", referencedColumnName="id")
     *   }
     * )
     * @Groups({"empleados:read", "empleados:write"})
     * @ApiSubresource(maxDepth=1)
     */
    private $idCentroTrabajo = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCentroTrabajo = new ArrayCollection();
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

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(?string $apellido2): self
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

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

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

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
     * @return Collection<int, CentrosTrabajo>
     */
    public function getIdCentroTrabajo(): Collection
    {
        return $this->idCentroTrabajo;
    }

    public function addIdCentroTrabajo(CentrosTrabajo $idCentroTrabajo): self
    {
        if (!$this->idCentroTrabajo->contains($idCentroTrabajo)) {
            $this->idCentroTrabajo[] = $idCentroTrabajo;
        }

        return $this;
    }

    public function removeIdCentroTrabajo(CentrosTrabajo $idCentroTrabajo): self
    {
        $this->idCentroTrabajo->removeElement($idCentroTrabajo);

        return $this;
    }

}
