<?php

namespace App\Models\Music\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRating extends Model
{
    use HasFactory;

    protected $connection = "mysql-music";

    protected $table = "projects_ratings";

    protected $hidden = ["row_id", "project_id"];

    protected $primaryKey = "row_id";

    const CREATED_AT = "stamp_created_at";
    const UPDATED_AT = "stamp_updated_at";
}
