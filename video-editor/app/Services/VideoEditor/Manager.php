<?php

namespace App\Services\VideoEditor;

use App\Services\VideoEditor\Contracts\ICommandSequenceBuilder;
use App\Services\VideoEditor\Contracts\IConverter;
use App\Services\VideoEditor\Contracts\IManager;
use App\Services\VideoEditor\Contracts\IVideoProvider;

/**
 * Class Manager
 * @package App\Services\VideoEditor
 */
class Manager implements IManager
{
    /**
     * @var ICommandSequenceBuilder $commandSequenceBuilder
     */
    private $commandSequenceBuilder;

    /**
     * @var IConverter $converter
     */
    private $converter;

    /**
     * @var IVideoProvider $videoProvider
     */
    private $videoProvider;

    /**
     * Manager constructor.
     * @param ICommandSequenceBuilder $commandSequenceBuilder
     * @param IConverter $converter
     * @param IVideoProvider $videoProvider
     */
    public function __construct(
        ICommandSequenceBuilder $commandSequenceBuilder,
        IConverter $converter,
        IVideoProvider $videoProvider
    ) {
        $this->commandSequenceBuilder = $commandSequenceBuilder;
        $this->converter = $converter;
        $this->videoProvider = $videoProvider;
    }

    /**
     * @param $input
     */
    public function create($input)
    {
        $this->videoProvider->getVideo(
            $input['firstVideoUrl'],
            $input['workDirPath'],
            $input['firstVideo'],
            $input['uniqueKey']
        );
        $this->videoProvider->getVideo(
            $input['secondVideoUrl'],
            $input['workDirPath'],
            $input['secondVideo'],
            $input['uniqueKey']
        );

        $input['videoResolution'] = $this->videoProvider->getResolution();

        $command = $this->commandSequenceBuilder->build($input);
        $this->converter->process($command);
    }
}