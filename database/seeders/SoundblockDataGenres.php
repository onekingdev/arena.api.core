<?php

namespace Database\Seeders;

use Util;
use Illuminate\Database\Seeder;
use App\Models\Soundblock\Data\Genre;

class SoundblockDataGenres extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $primaryGenres = '
            <option value="ALTERNATIVE">Alternative</option>
            <option value="AUDIOBOOKS">Audiobooks</option>
            <option value="BLUES">Blues</option>
            <option value="CHILDRENS_MUSIC">Children\'s Music</option>
            <option value="CLASSICAL">Classical</option>
            <option value="COMEDY">Comedy</option>
            <option value="COUNTRY">Country</option>
            <option value="DANCE">Dance</option>
            <option value="ELECTRONIC">Electronic</option>
            <option value="FOLK">Folk</option>
            <option value="HIP_HOP_RAP">Hip Hop/Rap</option>
            <option value="HOLIDAY">Holiday</option>
            <option value="INSPIRATIONAL">Inspirational</option>
            <option value="JAZZ">Jazz</option>
            <option value="LATIN">Latin</option>
            <option value="NEW_AGE">New Age</option>
            <option value="OPERA">Opera</option>
            <option value="POP">Pop</option>
            <option value="R_B_SOUL">R&amp;B/Soul</option>
            <option value="REGGAE">Reggae</option>
            <option value="ROCK">Rock</option>
            <option value="SPOKEN_WORD">Spoken Word</option>
            <option value="SOUNDTRACK">Soundtrack</option>
            <option value="VOCAL">Vocal</option>
            <option value="WORLD">World</option>
        ';

        $secondaryGenres = '
            <option value="7672307">Anime</option>
            <option value="7672308">Big Band</option>
            <option value="46419871">Blues</option>
            <option value="46529583">Children\'s Music</option>
            <option value="45304890">Classical</option>
            <option value="46523813">Comedy</option>
            <option value="48268175">Contemporary Jazz</option>
            <option value="29002779">Country</option>
            <option value="46599285">Dance</option>
            <option value="45258381">Electronic</option>
            <option value="7672309">Enka</option>
            <option value="7672310">Fitness &amp; Workout</option>
            <option value="46521065">Folk</option>
            <option value="7672311">French Pop</option>
            <option value="7672312">German Folk</option>
            <option value="7672313">German Pop</option>
            <option value="48556730">Gospel</option>
            <option value="7672314">Heavy Metal</option>
            <option value="7672315">High Classical</option>
            <option value="6196645">Indutrial/Metal</option>
            <option value="7672317">Instrumental</option>
            <option value="7672318">J-Pop</option>
            <option value="7672319">K-Pop</option>
            <option value="7672320">Karaoke</option>
            <option value="7672322">Kayokyoku</option>
            <option value="46520657">Latin</option>
            <option value="6314599">Metal</option>
            <option value="46416571">Reggae</option>
            <option value="7681373">Rock</option>
            <option value="7672557">Singer/Songwriter</option>
            <option value="46413999">World</option>
        ';

        $arrPrimaryGenres = explode("</option>", $primaryGenres);
        $arrSecondaryGenres = explode("</option>", $secondaryGenres);
        $insertData = [];

        foreach ($arrPrimaryGenres as $strPrimaryGenre) {
            $regexResult = preg_match('/"(.*?)">(.*?)$/', $strPrimaryGenre, $regexResultData);

            if ($regexResult) {
                $insertData[] = [
                    "code" => $regexResultData[1],
                    "genre" => $regexResultData[2],
                    "primary" => true,
                    "secondary" => false,
                ];
            }
        }

        foreach ($arrSecondaryGenres as $strSecondaryGenre) {
            $regexResult = preg_match('/"(.*?)">(.*?)$/', $strSecondaryGenre, $regexResultData);

            if ($regexResult) {
                $insertData[] = [
                    "code" => $regexResultData[1],
                    "genre" => $regexResultData[2],
                    "primary" => false,
                    "secondary" => true,
                ];
            }
        }

        foreach ($insertData as $record) {
            Genre::create([
                "data_uuid" => Util::uuid(),
                "data_code" => $record["code"],
                "data_genre" => $record["genre"],
                "flag_primary" => $record["primary"],
                "flag_secondary" => $record["secondary"],
            ]);
        }
    }
}
