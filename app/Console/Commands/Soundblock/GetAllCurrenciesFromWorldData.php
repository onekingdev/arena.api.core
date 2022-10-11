<?php

namespace App\Console\Commands\Soundblock;

use Util;
use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;
use App\Repositories\Soundblock\Data\ExchangeRates as ExchangeRatesRepository;

class GetAllCurrenciesFromWorldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:extract:all';

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
     * @param ExchangeRatesRepository $exchangeRatesRepo
     * @return int
     */
    public function handle(ExchangeRatesRepository $exchangeRatesRepo)
    {
        $objCurl = curl_init();
        curl_setopt_array($objCurl, [
            CURLOPT_URL => "https://www.worlddata.info/currencies/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authority: www.worlddata.info",
                "cache-control: max-age=0",
                "dnt: 1",
                "upgrade-insecure-requests: 1",
                "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
                "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36",
                "content-type: application/x-www-form-urlencoded; charset=UTF-8",
                "origin: https://www.worlddata.info",
                "sec-fetch-site: same-origin",
                "sec-fetch-mode: navigate",
                "sec-fetch-dest: document",
                "accept-language: en-US,en;q=0.9,ru;q=0.8,uk;q=0.7",
                "cookie: grfz=pmhgyrvhzofgrhza1625136281"
            ),
        ]);

        $strCurl = curl_exec($objCurl);
        curl_close($objCurl);

        $html = HtmlDomParser::str_get_html($strCurl);
        $arrInsert = [];

        foreach ($html->find("table>tr") as $key => $tableRaw) {
            if ($key > 0) {
                $arrInsert[$key]["code"] = $tableRaw->find("td", 0)->plaintext;
                $arrInsert[$key]["currency"] = $tableRaw->find("td", 1)->find("a")[0]->plaintext;
            }
        }

        foreach ($arrInsert as $currency) {
            $exchangeRatesRepo->create([
                "data_uuid" => Util::uuid(),
                "data_code" => $currency["code"],
                "data_currency" => $currency["currency"],
                "data_rate" => 0,
            ]);
        }

        return 0;
    }
}
