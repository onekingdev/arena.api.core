<?php

namespace App\Jobs\Soundblock\Data;

use Auth;
use Util;
use App\Models\BaseModel;
use Illuminate\Bus\Queueable;
use KubAT\PhpSimple\HtmlDomParser;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\Soundblock\Data\ExchangeRates as ExchangeRatesRepository;

class UpdateExchangeRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param ExchangeRatesRepository $exchangeRatesRepo
     * @return void
     */
    public function handle(ExchangeRatesRepository $exchangeRatesRepo)
    {
        $objRates = $exchangeRatesRepo->all();

        foreach ($objRates as $objRate) {
            $objCurl = curl_init();
            curl_setopt_array($objCurl, [
                CURLOPT_URL => "https://www.worlddata.info/currencies/usd-us-dollar.php?to=" . $objRate->data_code ."&amount=1.00",
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
            $workText = $html->find("div.currency.center")[0]->plaintext;
            $newRate = $this->find_between($workText, $objRate->data_currency);
            $boolResult = $exchangeRatesRepo->update(
                $objRate,
                [
                    "data_rate"                 => floatval(str_replace(",", "", $newRate)),
                    BaseModel::UPDATED_AT       => Util::now(),
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => 1,
                ]
            );

            if (!$boolResult) {
                info("Exchange Rates Info: can't update " . $objRate->data_currency . "!");
            }

            sleep(rand(2, 5));
        }
    }

    private function find_between(string $string, string $end) {
        $format = '/(\=)(.*?)(%s)/';
        $pattern = sprintf($format, preg_quote($end, '/'));

        preg_match($pattern, $string, $matches);

        return (trim($matches[2]));
    }
}
