<?php

namespace DeGraciaMathieu\Clike;

class Terminal {

    /**
     * @param array $availableCommands
     */
    public function __construct(array $availableCommands)
    {
        $this->availableCommands = $availableCommands;
    }

    /**
     * try to launch a command class from a command line
     * @param  string $commandLine
     * @throws \DeGraciaMathieu\Clike\Exceptions\UnknowCommand
     * @return array
     */
    public function execute(string $commandLine) :array
    {
        $command = $this->retrieveCommand($commandLine);

        return (new Command)->execute($command);
    }

    /**
     * Make Command class from binding
     * @param  string $binding
     * @throws \DeGraciaMathieu\Clike\Exceptions\UnknowCommand
     * @return \DeGraciaMathieu\Clike\Contracts\Command
     */
    protected function retrieveCommand(string $binding) :Contracts\Command
    {
        $command = array_filter($this->availableCommands, function($availableCommand) use($binding) {
            return (new $availableCommand)->binding() === $binding;
        });

        if (! $command[0]) {
            throw new Exceptions\UnknowCommand();
        }

        return new $command[0];
    }
}