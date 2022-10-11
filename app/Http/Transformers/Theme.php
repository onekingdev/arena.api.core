<?php
namespace App\Http\Transformers;

use App\Models\Soundblock\Projects\Metadata\Theme as ThemeModel;
use League\Fractal\TransformerAbstract;

class Theme extends TransformerAbstract
{
    public function transform(ThemeModel $theme)
    {
        return([
            "theme_uuid" => $theme->theme_uuid,
            "theme_name" => $theme->theme_name,
        ]);
    }
}
