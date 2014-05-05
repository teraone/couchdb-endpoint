<?php

namespace Kagency\CouchdbEndpoint\Endpoint\Silex;

use Kagency\CouchdbEndpoint\Replicator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller
{
    /**
     * Replicator
     *
     * @var Replicator
     */
    protected $replicator;

    /**
     * __construct
     *
     * @param Replicator $replicator
     * @return void
     */
    public function __construct(Replicator $replicator)
    {
        $this->replicator = $replicator;
    }

    /**
     * Get database status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatabaseStatus(Request $request)
    {
        return new JsonResponse(
            $this->replicator->getDatabaseStatus(
                $request->get('database')
            )
        );
    }

    /**
     * Check if change exists
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function hasChange(Request $request)
    {
        $result = $this->replicator->hasChange(
            $request->get('database'),
            $request->get('revision')
        );

        return new JsonResponse(
            $result,
            $result instanceof Replicator\Error ? 404 : 200
        );
    }

    /**
     * Calculate revision diff
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function revisionDiff(Request $request)
    {
        return new JsonResponse(
            $this->replicator->revisionDiff(
                json_decode($request->getContent(), true)
            )
        );
    }
}
