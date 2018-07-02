<?php

namespace App\Controller;

use App\Entity\AbstractEntity;
use App\Entity\Requirement;
use App\Entity\Role;
use App\Entity\Table;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncode;

/**
 * Class ParserController
 *
 * @package App\Controller
 */
class ParserController extends Controller
{
    /**
     * @Route("/get-roles", name="get-roles")
     */
    public function getRoles()
    {
        $entity = new Role();
        $response = $entity->fill(Table::get());
        $response = AbstractEntity::normalizeResponse($response);

        return new JsonResponse($response);
    }

    /**
     * @Route("/get-requirements", name="get-requirements")
     */
    public function getRequirements()
    {
        $entity = new Requirement();
        $response = $entity->fill(Table::get());
        $response = AbstractEntity::normalizeResponse($response);

        return new JsonResponse($response);
    }
}
