<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\IBuffer;
use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

abstract class AbstractCommand
{
    /**
     * @var ICommandChain|ICommand $nextCommand
     */
    protected $nextCommand;

    /**
     * @var IBuffer $buffer
     */
    protected $buffer;

    /**
     * @var string $body
     */
    protected $body;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    private $baseRequiredFields = [
        'uniqueKey',
        'workDirPath',
        'outputDirPath'
    ];

    /**
     * @var array
     */
    protected $requiredFields = [];

    /**
     * AbstractCommand constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @param ICommandChain $command
     * @return mixed
     */
    public function setNextCommand(ICommandChain $command) : ICommandChain
    {
        $this->nextCommand = $command;
        return $this;
    }

    /**
     * @param IBuffer $buffer
     * @return mixed
     */
    public function setBuffer(IBuffer $buffer) : ICommandChain
    {
        $this->buffer = $buffer;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $this->checkRequiredFields();
        $this->generate();
        $this->buffer->renew($this);

        if ($this->nextCommand) {
            $this->nextCommand
                ->setBuffer($this->buffer)
                ->setParams($this->params);

            return $this->nextCommand->execute();
        }

        return $this->buffer->get();
    }

    abstract protected function generate();

    /**
     * @param array $params
     * @return mixed
     */
    public function setParams(array $params) : ICommand
    {
        $this->params = array_merge($params, $this->params);
        return $this;
    }

    /**
     * @throws CommandExecutionException
     */
    protected function checkRequiredFields()
    {
        $requiredFields = array_merge($this->baseRequiredFields, $this->requiredFields);

        foreach ($requiredFields as $field) {
            if (!isset($this->params[$field])) {
                throw new CommandExecutionException("\'$field\' should be configured");
            }
        }
    }

    /**
     * @param $name
     * @return string
     */
    protected function workDirPath($name) : string
    {
        return $this->params['workDirPath'] . $this->params['uniqueKey'].'/'. $name;
    }

    /**
     * @param $name
     * @return string
     */
    protected function outputDirPath($name) : string
    {
        return $this->params['outputDirPath'] . $this->params['uniqueKey'] . '_' . $name;
    }

}