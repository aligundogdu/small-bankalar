<?php

namespace App\Infrastructure\Command;

use App\Application\Utils\Validator;
use App\Domain\Entities\Bank;
use Common\Application\Traits\Slugify;
use GuzzleHttp\Client;
use Spekulatius\PHPScraper\PHPScraper;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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
use function _PHPStan_d55c4f2c2\RingCentral\Psr7\stream_for;
use function Symfony\Component\String\u;


#[AsCommand(
    name: 'crawl:banks',
    description: 'X'
)]
class CrawlBankCommand extends Command
{
    use Slugify;

    private SymfonyStyle $io;
    private PHPScraper $scraper;
    private Crawler $crawler;
    private Client $client;

    public function __construct(
        private ParameterBagInterface $parameterBag,
        private EntityManagerInterface $entityManager
    ) {
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

        $logoPath = $this->parameterBag->get('kernel.project_dir') . '/public/images/banks/';


        $this->client = new Client([
            'base_uri' => 'https://www.trbanka.com/',
            // You can set any number of default request options.
            'timeout' => 5.0,
        ]);
        $response = $this->client->get('/');

        $this->crawler = new Crawler($response->getBody());

        $list = $this->crawler->filter('a.plain')
            ->each(function (Crawler $node, $i) use ($logoPath) {

                $img = $node->filter('img')
                    ->each(function (Crawler $imgNode) {
                        return $imgNode->attr('src');
                    });

                $imgUrl = count($img) > 0 ? $img[0] : null;

                if ($imgUrl) {
//                    $resource = fopen($logoPath . basename($imgUrl), 'w');
                    $this->client->get($imgUrl, ['sink' => $logoPath . basename($imgUrl)]);
                }

                $slug = $this->makeSlug($node->attr('title'));


                $entity = $this->entityManager->getRepository(Bank::class)->findOneBy(['bankSlug' => $slug]);
                if (!$entity instanceof Bank) {
                    $bank = new Bank();
                    $bank->setBankName($node->attr('title'));
                    $bank->setBankSlug($slug);
                    $bank->setImageUrl(basename($imgUrl));

                    $this->entityManager->persist($bank);
                    $this->entityManager->flush();
                    echo $node->attr('title') . PHP_EOL;
                }


//                return [
//                    'title' => $node->attr('title'),
//                    'href' => $node->attr('href'),
//                    'img' => $imgUrl,
//                    'slug' =>,
//                    'imgName' => basename($imgUrl)
//                ];

            });

        dump($list);

        return Command::SUCCESS;
    }

}
