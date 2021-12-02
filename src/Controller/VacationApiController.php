<?php

namespace Evrinoma\VacationBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\VacationBundle\Dto\VacationApiDtoInterface;
use Evrinoma\VacationBundle\Exception\Vacation\VacationCannotBeSavedException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationInvalidException;
use Evrinoma\VacationBundle\Exception\Vacation\VacationNotFoundException;
use Evrinoma\VacationBundle\Manager\Vacation\CommandManagerInterface;
use Evrinoma\VacationBundle\Manager\Vacation\QueryManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Nelmio\ApiDocBundle\Annotation\Model;

final class VacationApiController extends AbstractApiController implements ApiControllerInterface
{
//region SECTION: Fields
    private string $dtoClass;
    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;
//endregion Fields

//region SECTION: Constructor
    public function __construct(SerializerInterface $serializer, RequestStack $requestStack, FactoryDtoInterface $factoryDto, CommandManagerInterface $commandManager, QueryManagerInterface $queryManager, string $dtoClass)
    {
        parent::__construct($serializer);
        $this->request        = $requestStack->getCurrentRequest();
        $this->factoryDto     = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager   = $queryManager;
        $this->dtoClass       = $dtoClass;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @Rest\Post("/api/vacation/vacation/create", options={"expose"=true}, name="api_create_vacation")
     * @OA\Post(
     *     tags={"vacation"},
     *     description="the method perform create vacation",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\VacationBundle\Dto\VacationApiDto",
     *                  "author":"2",
     *                  "status":"pending",
     *                  "resolved_by":"3",
     *                  "request_created_at":"2020-08-09T12:57:13.506Z",
     *                  "vacation_start_date":"2020-08-24T00:00:00.000Z",
     *                  "vacation_end_date":"2020-09-04T00:00:00.000Z",
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\VacationBundle\Dto\VacationApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="author",type="string"),
     *               @OA\Property(property="status",type="string"),
     *               @OA\Property(property="resolved_by",type="string"),
     *               @OA\Property(property="request_created_at",type="string"),
     *               @OA\Property(property="vacation_start_date",type="string"),
     *               @OA\Property(property="vacation_end_date",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Create vacation")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var VacationApiDtoInterface $vacationApiDto */
        $vacationApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            $json = [];
            $em   = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($vacationApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($vacationApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_vacation')->json(['message' => 'Create vacation', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/vacation/vacation/save", options={"expose"=true}, name="api_save_vacation")
     * @OA\Put(
     *     tags={"vacation"},
     *     description="the method perform save vacation for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               example={
     *                  "class":"Evrinoma\VacationBundle\Dto\VacationApiDto",
     *                  "id":"48",
     *                  "author":"2",
     *                  "status":"approved",
     *                  "resolved_by":"3",
     *                  "request_created_at":"2020-08-09T12:57:13.506Z",
     *                  "vacation_start_date":"2020-08-24T00:00:00.000Z",
     *                  "vacation_end_date":"2020-09-04T00:00:00.000Z",
     *                  },
     *               type="object",
     *               @OA\Property(property="class",type="string",default="Evrinoma\VacationBundle\Dto\VacationApiDto"),
     *               @OA\Property(property="id",type="string"),
     *               @OA\Property(property="author",type="string"),
     *               @OA\Property(property="status",type="string"),
     *               @OA\Property(property="resolved_by",type="string"),
     *               @OA\Property(property="request_created_at",type="string"),
     *               @OA\Property(property="vacation_start_date",type="string"),
     *               @OA\Property(property="vacation_end_date",type="string")
     *            )
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Save vacation")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var VacationApiDtoInterface $vacationApiDto */
        $vacationApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            if ($vacationApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($vacationApiDto, $commandManager, &$json) {
                        $json = $commandManager->put($vacationApiDto);
                    }
                );
            } else {
                throw new VacationInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_vacation')->json(['message' => 'Save vacation', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/vacation/vacation/delete", options={"expose"=true}, name="api_delete_vacation")
     * @OA\Delete(
     *     tags={"vacation"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\VacationBundle\Dto\VacationApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Delete vacation")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var VacationApiDtoInterface $vacationApiDto */
        $vacationApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            if ($vacationApiDto->hasId()) {
                $json = [];
                $em   = $this->getDoctrine()->getManager();

                $em->transactional(
                    function () use ($vacationApiDto, $commandManager, &$json) {
                        $commandManager->delete($vacationApiDto);
                        $json = ['OK'];
                    }
                );
            } else {
                throw new VacationInvalidException('The Dto has\'t ID or class invalid');
            }
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete vacation', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/vacation/vacation/criteria", options={"expose"=true}, name="api_vacation_criteria")
     * @OA\Get(
     *     tags={"vacation"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\VacationBundle\Dto\VacationApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status",
     *         @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  type="string",
     *                  ref=@Model(type=Evrinoma\VacationBundle\Form\Vacation\StatusChoiceType::class)
     *              ),
     *          ),
     *         style="form"
     *     ),
     *      @OA\Parameter(
     *         description="person user",
     *         in="query",
     *         name="author",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="person resolver",
     *         in="query",
     *         name="resolved_by",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="request_created_at",
     *         in="query",
     *         description="created",
     *         @OA\Schema(
     *           type="string",
     *           default="2021-09-04T00:00:00.000Z"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="range[vacation_start_date]",
     *         in="query",
     *         description="Start range",
     *         @OA\Schema(
     *           type="string",
     *           default="2021-09-04T00:00:00.000Z"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="range[vacation_end_date]",
     *         in="query",
     *         description="End range",
     *         @OA\Schema(
     *           type="string",
     *           default="2021-09-04T00:00:00.000Z"
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return vacation")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var VacationApiDtoInterface $vacationApiDto */
        $vacationApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($vacationApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_vacation')->json(['message' => 'Get vacation', 'data' => $json], $this->queryManager->getRestStatus());
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @Rest\Get("/api/vacation/vacation", options={"expose"=true}, name="api_vacation")
     * @OA\Get(
     *     tags={"vacation"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="Evrinoma\VacationBundle\Dto\VacationApiDto",
     *           readOnly=true
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200,description="Return vacation")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var VacationApiDtoInterface $vacationApiDto */
        $vacationApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($vacationApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_vacation')->json(['message' => 'Get vacation', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof VacationCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof VacationNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof VacationInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
//endregion Getters/Setters
}