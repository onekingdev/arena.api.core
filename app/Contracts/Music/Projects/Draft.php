<?php


namespace App\Contracts\Music\Projects;

use App\Models\Users\User;
use Illuminate\Http\UploadedFile;
use App\Models\Music\Project\ProjectDraft;
use App\Models\Music\Project\ProjectDraftVersion;

interface Draft {
    public function findDraft(string $strDraft);
    public function saveDraft(array $draftData, User $objUser);
    public function saveDraftVersion(ProjectDraft $objDraft, array $draftData);
    public function getDrafts(?int $perPage = 10);
    public function findDraftVersion(ProjectDraft $objDraft, ?string $strDraftVersion = null);
    public function deleteDraft(ProjectDraft $objDraft): bool;

    public function saveDraftFile(ProjectDraft $objDraft, ProjectDraftVersion $objDraftVersion, UploadedFile $file);
    public function publishDraft(ProjectDraft $objDraft, ProjectDraftVersion $objDraftVersion);

}
