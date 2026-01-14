<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CandidateProfile;
use App\Models\Skill;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

echo "=== DEBUG: Skills & Languages ===\n\n";

// Check Skills table
echo "--- Skills Table ---\n";
$skills = Skill::all();
foreach ($skills as $s) {
    echo "ID: {$s->id}, Name: {$s->name}\n";
}
echo "Total: " . $skills->count() . "\n\n";

// Check Languages table
echo "--- Languages Table ---\n";
$languages = Language::all();
foreach ($languages as $l) {
    echo "ID: {$l->id}, Name: {$l->name}\n";
}
echo "Total: " . $languages->count() . "\n\n";

// Check Pivot tables
echo "--- Pivot: candidate_profile_skill ---\n";
$pivotSkills = DB::table('candidate_profile_skill')->get();
foreach ($pivotSkills as $p) {
    echo "Profile ID: {$p->candidate_profile_id}, Skill ID: {$p->skill_id}\n";
}
echo "Total: " . count($pivotSkills) . "\n\n";

echo "--- Pivot: candidate_profile_language ---\n";
$pivotLanguages = DB::table('candidate_profile_language')->get();
foreach ($pivotLanguages as $p) {
    echo "Profile ID: {$p->candidate_profile_id}, Language ID: {$p->language_id}\n";
}
echo "Total: " . count($pivotLanguages) . "\n\n";

// Check Profiles with relationships
echo "--- Profiles with Skills & Languages ---\n";
$profiles = CandidateProfile::with(['skills', 'languages', 'user'])->get();
foreach ($profiles as $profile) {
    echo "Profile ID: {$profile->id}\n";
    echo "  User: " . ($profile->user ? $profile->user->name : 'N/A') . "\n";
    echo "  Skills: " . ($profile->skills->count() > 0 ? $profile->skills->pluck('name')->implode(', ') : 'NONE') . "\n";
    echo "  Languages: " . ($profile->languages->count() > 0 ? $profile->languages->pluck('name')->implode(', ') : 'NONE') . "\n";
    echo "\n";
}
echo "Total profiles: " . $profiles->count() . "\n";
