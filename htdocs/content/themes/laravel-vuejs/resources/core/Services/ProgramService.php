<?php

namespace Core\Services;


use Core\Models\Program;
use Core\Repository\ProgramRepository;
use Core\Transformers\ProgramTransformer;

class ProgramService
{
    /** @var ProgramRepository */
    protected $programRepository;
    /** @var ProgramTransformer */
    protected $programTransformer;

    public function __construct(ProgramRepository $programRepository, ProgramTransformer $programTransformer)
    {
        $this->programRepository = $programRepository;
        $this->programTransformer = $programTransformer;
    }

    public function getFirstByMeta($meta, $value)
    {
        /** @var Program $program */
        $program = $this->programRepository->getPublishedByMeta($meta, $value);

        return (null === $program) ? null : $this->programTransformer->item($program);
    }

}