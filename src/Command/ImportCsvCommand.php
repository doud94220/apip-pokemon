<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCsvCommand extends Command
{
    protected static $defaultName = 'app:import:csv';
    protected $pokemonRepo;

    public function __construct(PokemonRepository $pokemonRepository)
    {
        parent::__construct(null);
        $this->pokemonRepo = $pokemonRepository;
    }

    protected function configure()
    {
        $this->setDescription('Import des pokemons par fichier csv');
        $this->addArgument('csv_file_path', InputArgument::REQUIRED, 'The file path ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filepath = $input->getArgument('csv_file_path');

        $isMatch = preg_match('/.csv$/', $filepath);

        if ($isMatch == false) {
            $output->writeln("Le format du fichier doit être CSV");
            return Command::FAILURE;
        }

        //Lire le fichier csv
        $row = 1;
        $enteteArray = [];

        if (($handle = fopen($filepath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($row == 1) {
                    $enteteArray = $data;
                } else {
                    $pokemonToInsert = new Pokemon;

                    for ($i = 0; $i < count($data); $i++) {
                        switch ($enteteArray[$i]) {
                            case '#':
                                $pokemonToInsert->setId($data[$i]);
                                break;
                            case 'Name':
                                $pokemonToInsert->setName($data[$i]);
                                break;
                            case 'Type 1':
                                $pokemonToInsert->setType1($data[$i]);
                                break;
                            case 'Type 2':
                                $pokemonToInsert->setType2($data[$i]);
                                break;
                            case 'Total':
                                $pokemonToInsert->setTotal($data[$i]);
                                break;
                            case 'HP':
                                $pokemonToInsert->setHp($data[$i]);
                                break;
                            case 'Attack':
                                $pokemonToInsert->setAttack($data[$i]);
                                break;
                            case 'Defense':
                                $pokemonToInsert->setDefense($data[$i]);
                                break;
                            case 'Sp. Atk':
                                $pokemonToInsert->setSpAtk($data[$i]);
                                break;
                            case 'Sp. Def':
                                $pokemonToInsert->setSpDef($data[$i]);
                                break;
                            case 'Speed':
                                $pokemonToInsert->setSpeed($data[$i]);
                                break;
                            case 'Generation':
                                $pokemonToInsert->setGeneration($data[$i]);
                                break;
                            case 'Legendary':
                                $pokemonToInsert->setLegendary($data[$i]);
                                break;
                        }
                    }

                    $this->pokemonRepo->add($pokemonToInsert, true);
                }

                $row++;
            }

            fclose($handle);
        }
        ////PAS UTILISE PAR SF
        // } else {
        //     $output->writeln("Le lien vers le fichier est erroné...");
        //     return Command::FAILURE;
        // }

        return Command::SUCCESS;
    }
}
