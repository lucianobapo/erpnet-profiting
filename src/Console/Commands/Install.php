<?php

namespace ErpNET\Profiting\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Install extends Command
{
    protected $progressBar;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erpnet:profiting:install
                                {--timeout=300} : How many seconds to allow each process to run.
                                {--debug} : Show process output or not. Useful for debugging.';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ErpNET\Profiting install and execute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        //$this->info(" Backpack\Base installation started. Please wait...");
        $this->progressBar = $this->output->createProgressBar(14);
        $this->progressBar->start();
        $this->info(" ErpNET\\Profiting installation started. Please wait...");
        $this->progressBar->advance();

        //step 1
        //$this->line(' Installing Backpack\\Base');
        //$this->executeProcess('php artisan backpack:base:install'.($this->option('debug')?' --debug':''));

        //step 2
        //$this->line(' Installing Backpack\\Crud');
        //$this->executeProcess('php artisan backpack:crud:install'.($this->option('debug')?' --debug':''));

        //step 3
        //$this->line(' Installing Backpack\\Settings');
        //$this->line(' Publishing Files...');
        //$this->executeProcess('php artisan vendor:publish --provider="Backpack\Settings\SettingsServiceProvider"');
        //step 4
        $this->line(' Migrate DB...');
        //$this->executeProcess('php artisan migrate');
        //step 5
        $this->line(' Db seed...');
        //$this->executeProcess('php artisan db:seed --class="Backpack\Settings\database\seeds\SettingsTableSeeder"');
        //step 6
        $this->line(' Add menu...');
        //$this->executeProcess('php artisan backpack:base:add-sidebar-content "<li><a href=\'{{ url(config(\'backpack.base.route_prefix\', \'admin\') . \'/setting\') }}\'><i class=\'fa fa-cog\'></i> <span>Settings</span></a></li>"');




        //step 13
        $this->line(' Installing ErpNET\\Permissions');
        //$this->executeProcess('php artisan erpnet:permissions:install');

        //step 14
        $this->progressBar->finish();
        $this->info(" ErpNET\\Profiting installation finished.");
    }

    /**
     * Run a SSH command.
     *
     * @param string $command      The SSH command that needs to be run
     * @param bool   $beforeNotice Information for the user before the command is run
     * @param bool   $afterNotice  Information for the user after the command is run
     *
     * @return mixed Command-line output
     */
    public function executeProcess($command, $beforeNotice = false, $afterNotice = false):void
    {
        $this->echo('info', $beforeNotice ? ' '.$beforeNotice : $command);

        $process = new Process($command, null, null, null, $this->option('timeout'), null);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->echo('comment', $buffer);
            } else {
                $this->echo('line', $buffer);
            }
        });

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            $this->executeProcess('php artisan migrate:reset');
            throw new ProcessFailedException($process);
        }

        if ($this->progressBar) {
            $this->progressBar->advance();
        }

        if ($afterNotice) {
            $this->echo('info', $afterNotice);
        }
    }

    /**
     * Write text to the screen for the user to see.
     *
     * @param [string] $type    line, info, comment, question, error
     * @param [string] $content
     */
    public function echo($type, $content)
    {
        if ($this->option('debug') == false) {
            return;
        }

        // skip empty lines
        if (trim($content)) {
            $this->{$type}($content);
        }
    }

}
