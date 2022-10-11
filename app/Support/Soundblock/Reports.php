<?php


namespace App\Support\Soundblock;

use Carbon\Carbon;

class Reports
{
    /**
     * @var array|string[][]
     */
    private array $platformsHeaders = [
        "Anghami" => [
            "Service Name",
            "Start Date",
            "End Date",
            "DPID",
            "Member Name",
            "Label Name",
            "Release Title",
            "Artist Name",
            "Track Title",
            "Release ID",
            "ISRC",
            "Genre",
            "Country of Sale",
            "Service Tier",
            "Service Plan",
            "Type of Play",
            "Quantity",
            "Currency",
            "Total Payable"
        ],
        "Apple Music" => [
            "Provider",
            "Provider Country",
            "Vendor Identifier",
            "UPC",
            "ISRC",
            "Artist / Show",
            "Title",
            "Label/Studio/Network",
            "Product Type Identifier",
            "Units",
            "Royalty Price",
            "Download Date (PST)",
            "Order Id",
            "Postal Code",
            "Customer Identifier",
            "Report Date (Local)",
            "Sale/Return",
            "Customer Currency",
            "Country Code",
            "Royalty Currency",
            "PreOrder",
            "ISAN",
            "Customer Price",
            "Apple Identifier",
            "CMA",
            "Asset/Content Flavor",
            "Vendor Offer Code",
            "Grid",
            "Promo Code",
            "Parent Identifier",
            "Parent Type Id",
            "Attributable Purchase",
            "Primary Genre"
        ],
        "Boomplay" => [
            "Service",
            "Start_Date",
            "End_Date",
            "DPID",
            "Member_Name",
            "Label_Name",
            "Release_Title",
            "Artist_Name",
            "Track_Title",
            "Release_ID",
            "GRID",
            "ISRC",
            "Genre",
            "Country_Of_Sale",
            "Commercial_Model",
            "Sound_Quality",
            "Service_Type",
            "Type_Of_Play",
            "Price_Code",
            "Retail_Price",
            "Retail_Currency",
            "Unit_Price",
            "Quantity",
            "Total_Payable",
            "Total_Payable_USD"
        ],
        "Deezer" => [
            "Start Report",
            "End Report",
            "ISRC",
            "Artist",
            "Title",
            "Album",
            "UPC",
            "Country",
            "Nb of plays",
            "Royalties",
            "Service",
            "Provider",
            "provider_id",
            "Label"
        ],
        "Dubset" => [
            "Reporting start date",
            "Reporting end date",
            "DSP",
            "Territory",
            "Service type",
            "Content type",
            "Track ISRC",
            "Track title",
            "Album UPC",
            "Album title",
            "Artist name",
            "Label owner name",
            "Label name",
            "Quantity",
            "Net royalty in local currency",
            "Net royalty total in local currency",
            "Local currency",
            "Net royalty in payment currency",
            "Net royalty total in payment currency",
            "Payment owed to label owner in payment currency",
            "Payment currency",
            "Exchange rate",
            "Offline indicator",
            "MixBANK track ID",
            "Remix ID",
            "Merlin member ID",
            "Merlin member DPID"
        ],
        "Google Play" => [
            "Partner_Name",
            "Reporting_Region",
            "Reporting_Currency",
            "Start_Date",
            "End_Date",
            "Plays_Partner",
            "Money_Due_Partner"
        ],
        "iHeartRadio" => [
            "ReportStartDt",
            "ReportEndDt",
            "EntityName",
            "Merlin Member",
            "Label Code",
            "Artist Name",
            "Album Name",
            "UPC",
            "# Discs",
            "Album Sequence",
            "Track Name",
            "ISRC",
            "# Streams",
            "Album ID",
            "Track ID",
            "Country",
            "Price",
            "Curr",
            "ProductTier"
        ],
        "Pandora" => [
            "MessageVersionId",
            "MessageSender",
            "MessageRecipient",
            "MessageCreatedDateTime",
            "MessageNotificationStartDate",
            "MessageNotificationEndDate",
            "UnitsSoldTotal",
            "TotalSalesForMarketShareCalculation",
            "CurrencyCode",
            "NumberOfSalesLines",
            "DspGrossRevenue",
            "DspDeductionsAmount",
            "TotalAmountPayable",
            "CommercialModelType"
        ],
        "Slacker Radio" => [
            "Accounted Period",
            "Date of Report",
            "Total Royalties Payable",
            "Currency",
            "Licensee"
        ],
        "Soundcloud" => [
            "Partner ID",
            "Partner Name",
            "Label Name",
            "Account ID",
            "Account Name",
            "Artist Name",
            "Album Title",
            "Track Name",
            "Track ID",
            "Track Classification",
            "ISRC",
            "UPC",
            "Reporting Period",
            "Territory",
            "Total Plays",
            "Total Revenue",
            "Revenue Currency",
            "Monetisation Type",
            "Usage Type",
            "Version"
        ],
        "Spotify" => [
            "Format version",
            "Start date",
            "End date",
            "Sender",
            "DPID",
            "Recipient",
            "Disclaimer"
        ],
        "Uma Music" => [
            "Digital Service Code",
            "start date",
            "end date",
            "Member_id",
            "Label_name",
            "Artist",
            "release_title",
            "release_id",
            "Track_title",
            "ISRC",
            "Type",
            "User Type",
            "quantity",
            "customer_price",
            "minimum fee",
            "Net Royalty Total",
            "territory_code",
            "price_foreign",
            "DSP_currency",
            "Total in USD"
        ]
    ];

    public function readFile($file){
        $filePath = "file.csv";

        if ($file->getClientOriginalExtension() != "csv") {
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $fp = fopen('file.csv', 'w');
            foreach ($lines as $line) {
                fputcsv($fp, explode("\t", $line));
            }

            fclose($fp);
        } else {
            $filePath = $file->getPathName();
        }

        $handle = fopen($filePath, "r");

        $arrFIleData = [];
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $arrFIleData[] = $data;
        }

        fclose($handle);
        unlink($filePath);

        $platformName = $this->defineReportPlatform($arrFIleData[0]);

        return ([$arrFIleData, $platformName]);
    }

    public function getDateStartAndEnd(string $format, string $startDate, string $endDate = null){
        if ($endDate) {
            return ([
                Carbon::createFromFormat($format, $startDate)->toDateString(),
                Carbon::createFromFormat($format, $endDate)->toDateString()
            ]);
        } else {
            return ([
                Carbon::createFromFormat($format, $startDate)->firstOfMonth()->toDateString(),
                Carbon::createFromFormat($format, $startDate)->lastOfMonth()->toDateString()
            ]);
        }
    }

    private function defineReportPlatform(array $arrFileHeaders)
    {
        foreach ($arrFileHeaders as $key => $header) {
            $arrFileHeaders[$key] = str_replace('"', '', trim($header));
        }

        foreach ($this->platformsHeaders as $platformName => $platformHeaders) {
            if ($platformHeaders === $arrFileHeaders) {
                return ($platformName);
            }
        }

        return (false);
    }
}
