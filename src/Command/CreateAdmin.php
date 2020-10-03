<?php

namespace Snowdog\Academy\Command;

use Snowdog\Academy\Model\UserManager;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateAdmin
{
    private QuestionHelper $questionHelper;
    private UserManager $userManager;

    public function __construct(QuestionHelper $questionHelper, UserManager $userManager)
    {
        $this->questionHelper = $questionHelper;
        $this->userManager = $userManager;
    }

    public function __invoke(InputInterface $input, OutputInterface $output)
    {
        $loginQuestion = new Question('Please provide login: ');
        $passwordQuestion = new Question('Please provide password: ');

        $login = $this->questionHelper->ask($input, $output, $loginQuestion);
        $password = $this->questionHelper->ask($input, $output, $passwordQuestion);

        $this->userManager->create($login, $password, true, true);
    }
}
