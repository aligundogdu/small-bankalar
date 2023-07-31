<?php

namespace User\Infrastructure\Command;

use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use User\Application\Queries\User\FindUserById\FindUserByIdQuery;

class DetailUserCommand extends Command
{
    protected static $defaultName = 'app:user:detail';

    public function __construct(private readonly MessengerQueryBus $queryBus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('id', null, InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->queryBus->handle(new FindUserByIdQuery($input->getOption('id')));

        dump($user);

        return Command::SUCCESS;
    }
}