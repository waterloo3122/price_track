<?php

namespace App\Console\Commands;

use App\ProductInfo;
use Illuminate\Console\Command;

class SandiskTrack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track:sandisk
                {--url=http://www.amazon.cn/SanDisk-Ultra-II-480GB-SATA-III-2-5-Inch-7mm-Height-Solid-State-Drive-With-Read-Up-To-550MB-s-SDSSDHII-480G-G25/dp/B00M8ABFX6}
         ';

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
        require_once ('App\Libraries\simple_html_dom.php');
        $model = new ProductInfo();

        $url = $this->option('url');
        $html = file_get_html($url);
        //$this->info($html);

        $title = $html->find('span[id=productTitle]',0)->innertext;
        $this->info($title);
        $model->name = $title;

        $type = $html->find('span[class=selection]', 0)->innertext;
        $this->info(ltrim($type));
        $model->type = ltrim($type);

        $model->type_detail = '0000';

        $price = $html->find('span[id=priceblock_ourprice]', 0)->innertext;
        $price = $this->getRealPrice($price);
        $model->price = $price;
        $this->info($price);

        $model->trans_fee = '0';

        $status = $html->find('div[id=dynamicDeliveryMessage_feature_div]',0)->find('span',0)->innertext;
        $this->info($status);
        $model->status = $status;

        $model->url = $url;

        $model->save();
    }
    function getRealPrice($price){
        $price = mb_substr($price,1);
        $price = str_replace(',', '', $price);

        return $price;

    }
}
