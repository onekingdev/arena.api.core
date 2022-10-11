<?php

namespace Database\Seeders;

use Util;
use Illuminate\Database\Seeder;
use App\Models\Soundblock\Data\Language;

class SoundblockDataLanguages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = '
            <option value="AA">Afar</option>
            <option value="AB">Abkhazian</option>
            <option value="AE">Avestan</option>
            <option value="AF">Afrikaans</option>
            <option value="AK">Akan</option>
            <option value="AM">Amharic</option>
            <option value="AN">Aragonese</option>
            <option value="AR">Arabic</option>
            <option value="AS">Assamese</option>
            <option value="AV">Avaric</option>
            <option value="AY">Aymara</option>
            <option value="AZ">Azerbaijani</option>
            <option value="BA">Bashkir</option>
            <option value="BE">Belarusian</option>
            <option value="BG">Bulgarian</option>
            <option value="BHO">Bhojpuri</option>
            <option value="BI">Bislama</option>
            <option value="BM">Bambara</option>
            <option value="BN">Bengali</option>
            <option value="BO">Tibetan</option>
            <option value="BR">Breton</option>
            <option value="BS">Bosnian</option>
            <option value="CA">Catalan</option>
            <option value="CE">Chechen</option>
            <option value="CH">Chamorro</option>
            <option value="CO">Corsican</option>
            <option value="CPE">Creole, English</option>
            <option value="CPF">Creole, French</option>
            <option value="CPP">Creole, Portuguese</option>
            <option value="CR">Cree</option>
            <option value="CS">Czech</option>
            <option value="CU">Slavic, Church</option>
            <option value="CV">Chuvash</option>
            <option value="CY">Welsh</option>
            <option value="DA">Danish</option>
            <option value="DE">German</option>
            <option value="DV">Divehi</option>
            <option value="DZ">Dzongkha</option>
            <option value="EE">Ewe</option>
            <option value="EL">Greek</option>
            <option value="EN">English</option>
            <option value="EO">Esperanto</option>
            <option value="ES">Spanish</option>
            <option value="ET">Estonian</option>
            <option value="EU">Basque</option>
            <option value="FA">Persian</option>
            <option value="FF">Fulah</option>
            <option value="FI">Finnish</option>
            <option value="FJ">Fijian</option>
            <option value="FO">Faroese</option>
            <option value="FR">French</option>
            <option value="FY">Frisian, Western</option>
            <option value="GA">Irish</option>
            <option value="GD">Gaelic</option>
            <option value="GL">Galician</option>
            <option value="GN">Guarani</option>
            <option value="GU">Gujarati</option>
            <option value="GV">Manx</option>
            <option value="HA">Hausa</option>
            <option value="HAT">Creole, Haitian</option>
            <option value="HE">Hebrew</option>
            <option value="HI">Hindi</option>
            <option value="HO">Hiri Motu</option>
            <option value="HR">Croatian</option>
            <option value="HT">Haitian</option>
            <option value="HU">Hungarian</option>
            <option value="HY">Armenian</option>
            <option value="HZ">Herero</option>
            <option value="IA">Interlingua</option>
            <option value="ID">Indonesian</option>
            <option value="IE">Interlingue</option>
            <option value="IG">Igbo</option>
            <option value="II">Sichuan Yi</option>
            <option value="IK">Inupiaq</option>
            <option value="IO">Ido</option>
            <option value="IS">Icelandic</option>
            <option value="IT">Italian</option>
            <option value="IU">Inuktitut</option>
            <option value="JA">Japanese</option>
            <option value="JV">Javanese</option>
            <option value="KA">Georgian</option>
            <option value="KG">Kongo</option>
            <option value="KI">Kikuyu</option>
            <option value="KJ">Kuanyama</option>
            <option value="KK">Kazakh</option>
            <option value="KL">Kalaallisut</option>
            <option value="KM">Khmer, Central</option>
            <option value="KN">Kannada</option>
            <option value="KO">Korean</option>
            <option value="KR">Kanuri</option>
            <option value="KS">Kashmiri</option>
            <option value="KU">Kurdish</option>
            <option value="KV">Komi</option>
            <option value="KW">Cornish</option>
            <option value="KY">Kirghiz</option>
            <option value="LA">Latin</option>
            <option value="LB">Luxembourgish</option>
            <option value="LG">Luganda</option>
            <option value="LI">Limburgan</option>
            <option value="LN">Lingala</option>
            <option value="LO">Lao</option>
            <option value="LT">Lithuanian</option>
            <option value="LU">Luba-Katanga</option>
            <option value="LV">Latvian</option>
            <option value="MAG">Magahi</option>
            <option value="MAI">Maithili</option>
            <option value="MG">Malagasy</option>
            <option value="MH">Marshallese</option>
            <option value="MI">Maori</option>
            <option value="MK">Macedonian</option>
            <option value="ML">Malayalam</option>
            <option value="MN">Mongolian</option>
            <option value="MR">Marathi</option>
            <option value="MS">Malay</option>
            <option value="MT">Maltese</option>
            <option value="MY">Burmese</option>
            <option value="NA">Nauru</option>
            <option value="NB">Norwegian, Bokmål</option>
            <option value="ND">Ndebele, North</option>
            <option value="NE">Nepali</option>
            <option value="NG">Ndonga</option>
            <option value="NL">Dutch</option>
            <option value="NN">Norwegian, Nynorsk</option>
            <option value="NO">Norwegian</option>
            <option value="NR">Ndebele, South</option>
            <option value="NV">Navajo</option>
            <option value="NY">Chichewa</option>
            <option value="OC">Occitan</option>
            <option value="OJ">Ojibwa</option>
            <option value="OM">Oromo</option>
            <option value="OR">Oriya</option>
            <option value="OS">Ossetian</option>
            <option value="PA">Punjabi</option>
            <option value="PI">Pali</option>
            <option value="PL">Polish</option>
            <option value="PS">Pushto</option>
            <option value="PT">Portuguese</option>
            <option value="QU">Quechua</option>
            <option value="RM">Romansh</option>
            <option value="RN">Rundi</option>
            <option value="RO">Romanian</option>
            <option value="RU">Russian</option>
            <option value="RW">Kinyarwanda</option>
            <option value="SA">Sanskrit</option>
            <option value="SC">Sardinian</option>
            <option value="SD">Sindhi</option>
            <option value="SE">Sami, Northern</option>
            <option value="SG">Sango</option>
            <option value="SI">Sinhala</option>
            <option value="SK">Slovak</option>
            <option value="SL">Slovene</option>
            <option value="SM">Samoan</option>
            <option value="SN">Shona</option>
            <option value="SO">Somali</option>
            <option value="SQ">Albanian</option>
            <option value="SR">Serbian</option>
            <option value="SS">Swati</option>
            <option value="ST">Sotho, Southern</option>
            <option value="SU">Sundanese</option>
            <option value="SV">Swedish</option>
            <option value="SW">Swahili</option>
            <option value="TA">Tamil</option>
            <option value="TE">Telugu</option>
            <option value="TG">Tajik</option>
            <option value="TH">Thai</option>
            <option value="TI">Tigrinya</option>
            <option value="TK">Turkmen</option>
            <option value="TL">Tagalog</option>
            <option value="TN">Tswana</option>
            <option value="TO">Tonga (Islands)</option>
            <option value="TR">Turkish</option>
            <option value="TS">Tsonga</option>
            <option value="TT">Tatar</option>
            <option value="TW">Twi</option>
            <option value="TY">Tahitian</option>
            <option value="UG">Uighur</option>
            <option value="UK">Ukrainian</option>
            <option value="UR">Urdu</option>
            <option value="UZ">Uzbek</option>
            <option value="VE">Venda</option>
            <option value="VI">Vietnamese</option>
            <option value="VO">Volapük</option>
            <option value="WA">Walloon</option>
            <option value="WO">Wolof</option>
            <option value="XH">Xhosa</option>
            <option value="YI">Yiddish</option>
            <option value="YUE">Cantonese</option>
            <option value="YO">Yoruba</option>
            <option value="ZA">Zhuang</option>
            <option value="ZH">Chinese</option>
            <option value="ZU">Zulu</option>
        ';

        $arrLanguages = explode("</option>", $languages);
        $insertData = [];

        foreach ($arrLanguages as $strLanguage) {
            $regexResult = preg_match('/"(.*?)">(.*?)$/', $strLanguage, $regexResultData);

            if ($regexResult) {
                $insertData[$regexResultData[1]] = $regexResultData[2];
            }
        }

        foreach ($insertData as $code => $lang) {
            Language::create([
                "data_uuid" => Util::uuid(),
                "data_code" => $code,
                "data_language" => $lang,
            ]);
        }
    }
}
