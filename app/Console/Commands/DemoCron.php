<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use simple_html_dom;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $url = 'https://itviec.com/jobs-company-index';
        $context = stream_context_create();
        stream_context_set_params($context, array('Set-Cookie'=> '_ITViec_session=TzVNRXVoZ0xacUtrZXNVNms0SVFxV2pHZE1KRWZKRmVPUDRla1JVVGF4ZUNjckdBblUyVWlKd3N3TE9Ddm9BUlduUkUvYno4VllxN0lWMU1hNGlDaHRrdklxbVlabVpRNThFeWlxN0EzTEw2aE1NL3NFczlzY2E1MDl1MEJKU2krS3drM3JjL08xem9aU01SREd4bHVRdTY1U3FNN09SaE5EMS84R29LTnE5dGJ0T2JPSHVFK2NERUR1V0UzZDVyVDZhOHQwSmcyaE5uamZWR0xDZ3dOZCtTVjdIbXV5Mkt6OHVxMzlIbVRiSHROOWFaNS9DRTNjdlVxSVZJWEgvbWtEeTBvUGNSazhDaGlXeHpHV1VESmc9PS0tNDlEQ2hSY29YLzVZNGlZU3QxTDdJdz09--233e7d8fa53c29f0b1d4888b40bea104ebccbe02; path=/; HttpOnly'));
        $html = file_get_html($url, 0, $context);
        // Find all images 
        $result = array();
        foreach($html->find('.skill-tag__link') as $element){
            array_push($result, $element->href);
        }
    }
}
