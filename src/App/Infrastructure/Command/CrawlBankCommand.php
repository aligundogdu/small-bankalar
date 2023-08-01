<?php

namespace App\Infrastructure\Command;

use App\Application\Utils\Validator;
use GuzzleHttp\Client;
use Spekulatius\PHPScraper\PHPScraper;
use Symfony\Component\DomCrawler\Crawler;
use User\Domain\Entities\User;
use User\Infrastructure\Repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use function Symfony\Component\String\u;


#[AsCommand(
    name: 'crawl:banks',
    description: 'X'
)]
class CrawlBankCommand extends Command
{
    private SymfonyStyle $io;
    private PHPScraper $scraper;
    private Crawler $crawler;
    private Client $client;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {


    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }


    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->client = new Client([
            'base_uri' => 'https://www.trbanka.com/',
            // You can set any number of default request options.
            'timeout' => 5.0,
        ]);
        $response = $this->client->get('/');

        $this->crawler = new Crawler($response->getBody());

        $list = $this->crawler->filter('a.plain')
            ->each(function (Crawler $node, $i) {

                $img = $node->filter('img')
                    ->each(function (Crawler $imgNode) {
                        return $imgNode->attr('src');
                    });

                return [
                    'title' => $node->attr('title'),
                    'href' => $node->attr('href'),
                    'img' => count($img) > 0 ? $img[0] : null
                ];
                
            });

        dump($list);


        return Command::SUCCESS;
    }

}
