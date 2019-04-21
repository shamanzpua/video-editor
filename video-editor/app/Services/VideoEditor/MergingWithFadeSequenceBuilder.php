<?php
namespace App\Services\VideoEditor;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\Contracts\ICommandSequenceBuilder;
use App\Services\VideoEditor\Exceptions\CommandBuilderException;
use App\Services\VideoEditor\VideoEditCommands\AddFadeInEffect;
use App\Services\VideoEditor\VideoEditCommands\AddFadeOutEffect;
use App\Services\VideoEditor\VideoEditCommands\AddWatermark;
use App\Services\VideoEditor\VideoEditCommands\Buffer;
use App\Services\VideoEditor\VideoEditCommands\ConcatVideo;
use App\Services\VideoEditor\VideoEditCommands\CreateConcatList;
use App\Services\VideoEditor\VideoEditCommands\CutVideo;
use App\Services\VideoEditor\VideoEditCommands\DeleteTemporaryFiles;
use App\Services\VideoEditor\VideoEditCommands\ScaleResolution;

/**
 * Class MergingWithFadeSequenceBuilder
 * @package App\Services\VideoEditor
 */
class MergingWithFadeSequenceBuilder implements ICommandSequenceBuilder
{
    /**
     * @var ICommandChain $previousChain
     */
    private $previous;


    /**
     * @param $data
     */
    private function checkRequiredFields($data)
    {
        $required = [
            'videoResolution',

            'firstVideo',
            'cutFirstVideo',
            'firstScaledVideo',
            'firstVideoCutStart',
            'firstVideoDuration',

            'secondVideo',
            'cutSecondVideo',
            'secondScaledVideo',
            'secondVideoCutStart',
            'secondVideoDuration',

            'firstVideoWithFade',
            'secondVideoWithFade',
            'finalVideo',

            'uniqueKey',
            'workDirPath',
            'outputDirPath',

            'waterMarkPath',
            'firstWaterMarkFile',
            'secondWaterMarkFile',
            'firstVideoWithWatermark',
            'secondVideoWithWatermark',

        ];

        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new CommandBuilderException("\'$field\' should be configured");
            }
        }
    }


    /**
     * @return mixed
     */
    public function build($data): ICommand
    {
        $this->checkRequiredFields($data);

        $buffer = (new Buffer());

        $cutFirstVideo = new CutVideo([
            'uniqueKey' => $data['uniqueKey'],
            'inputVideo' => $data['firstVideo'],
            'startTime' => $data['firstVideoCutStart'],
            'duration' => $data['firstVideoDuration'],
            'output' => $data['cutFirstVideo']
        ]);
        $cutFirstVideo
            ->setParams($data)
            ->setBuffer($buffer);

        $this->previous = $cutFirstVideo;

        $this->buildChain([
            new CutVideo([
                'inputVideo' => $data['secondVideo'],
                'startTime' => $data['secondVideoCutStart'],
                'duration' => $data['secondVideoDuration'],
                'output' => $data['cutSecondVideo']
            ]),
            new ScaleResolution([
                'inputVideo' => $data['cutFirstVideo'],
                'output' => $data['firstScaledVideo'],
                'resolution' => $data['videoResolution']
            ]),
            new ScaleResolution([
                'inputVideo' => $data['cutSecondVideo'],
                'output' => $data['secondScaledVideo'],
                'resolution' => $data['videoResolution']
            ]),
            new AddWatermark([
                'inputVideo' => $data['firstScaledVideo'],
                'output' => $data['firstVideoWithWatermark'],
                'waterMarkPath' => $data['waterMarkPath'],
                'waterMarkFile' => $data['firstWaterMarkFile']
            ]),
            new AddWatermark([
                'inputVideo' => $data['secondScaledVideo'],
                'output' => $data['secondVideoWithWatermark'],
                'waterMarkPath' => $data['waterMarkPath'],
                'waterMarkFile' => $data['secondWaterMarkFile']
            ]),
            new AddFadeOutEffect([
                'inputVideo' => $data['firstVideoWithWatermark'],
                'output' => $data['firstVideoWithFade'],
                'duration' => $data['firstVideoDuration'],
            ]),
            new AddFadeInEffect([
                'inputVideo' => $data['secondVideoWithWatermark'],
                'output' => $data['secondVideoWithFade']
            ]),

            new ConcatVideo([
                'finalVideo' => $data['finalVideo'],
                'firstPart' => $data['firstVideoWithFade'],
                'secondPart' => $data['secondVideoWithFade'],
            ]),
            new DeleteTemporaryFiles(),
        ]);

        return $cutFirstVideo;
    }

    /**
     * @param ICommandChain[] $commands
     */
    private function buildChain(array $commands)
    {
        foreach ($commands as $command) {
            $this->previous->setNextCommand($command);
            $this->previous = $command;
        }
    }
}