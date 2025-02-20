<?php

namespace App\Command;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Band; 


#[AsCommand(
    name: 'ImportBandsCommand',
    description: 'Imports bands from an Excel file',
)]
class ImportBandsCommand extends Command
{
    // protected static $defaultName = 'app:import-bands';
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Imports bands from an Excel file.')
             ->addArgument('file', InputArgument::REQUIRED, 'Path to the Excel file.');
    }

 protected function execute(InputInterface $input, OutputInterface $output): int
{
    $filePath = $input->getArgument('file');

    // Verify the file exists
    if (!file_exists($filePath)) {
        $output->writeln('<error>File not found: ' . $filePath . '</error>');
        return Command::FAILURE;
    }

    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Process each row
        foreach ($rows as $row) {
            $band = new Band();
            $band->setName($row[0] ?? ''); // Nom du groupe (default to empty string if null)
            $band->setOrigin($row[1] ?? ''); // Origine (default to empty string if null)
            $band->setCity($row[2] ?? ''); // Ville (default to empty string if null)
            $band->setStartYear((int)($row[3] ?? 0)); // Année début (default to 0 if null)
            $band->setSeparationYear((int)($row[4] ?? null)); 
            $band->setFounders($row[5] ?? ''); 
            $band->setMembers($row[6] ?? ''); 
            $band->setMusicalStyle($row[7] ?? ''); 
            $band->setPresentation($row[8] ?? ''); 

            $this->entityManager->persist($band);
        }

        $this->entityManager->flush();
        $output->writeln('<info>Bands imported successfully!</info>');
        return Command::SUCCESS;

    } catch (\Exception $e) {
        $output->writeln('<error>Error importing bands: ' . $e->getMessage() . '</error>');
        return Command::FAILURE;
    }
}
}
