<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Traits\RaveBase;

class SampleAppsCommand extends Command
{
    //Add Trait
    use RaveBase {
        RaveBase::__construct as RaveConstruct;
    }

    /**
     * Call parent constructor
     */
    public function __construct()
    {
        parent::__construct();
        self::RaveConstruct();
    }

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'generate:sampleapp {type?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generates a specified sample app for you.';

    /**
     * initialize inputs
     * @var string
     */
    protected $type;

    /**
     * Get type of sample app
     * @var String
     */
    public function getSampleType()
    {
        $this->type = $this->argument('type');

        //list sample supported
        $this->info("");
        $this->info("SUPPORTED SAMPLE APPS");
        $this->info("========================");
        // $this->info("");
        
        $this->line("[charge] <comment>Card and Account Charge Sample App</comment>");
        $this->line("[3dsecure] <comment>3DSecure Payment Sample App</comment>");
        $this->line("[transfer] <comment>Single and Bulk Transfer Sample App</comment>");
        $this->line("[webhook] <comment>Recieving Response in Webhook</comment>");
        $this->line("[splitpayment] <comment>Split Payments to Different Merchants</comment>");
        $this->line("[subscription] <comment>Subscription Payment using Rave</comment>");
        $this->line("[bills_services] <comment>Bills and Services with Rave</comment>");
        $this->line("[extra_info] <comment>Passing Extra Information to Rave</comment>");
        $this->line("[tokenized_charges] <comment>How to Tokenize a Card</comment>");
        $this->line("[preauth_service] <comment>How to use the Preauth Services</comment>");

        //ask questions for details
        if (!$this->type){
            $this->type = $this->ask('Type sample app (choose from the block above)');
        }

        //switch case
        switch ($this->type) {
            case 'charge':
                //run a function here and return 'app created'
                $res = $this->createSampleApp($this->type);
                return $res;
                break;
            
            default:
                return 'Oops! sample app not supported yet.';
                break;
        }
    }

    /**
     * create the sample app for user
     */
    public function createSampleApp($app)
    {
        $source = getcwd().'\\sample_apps\\'.$app; //source path
        $dest = ''; //destination path

        //ask for destination path
        $path = $this->ask('Enter destination path (eg: C:\xampp\htdocs)');
        $dest = $path.'\\'.$app;

        // Start copying
        $res = $this->xcopy($source, $dest);
        return $res;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = $this->getSampleType();
        dd($result);
    }

}