<?php
Route::middleware(['auth'])->prefix('external-apps/teams')->group(function () {
    Route::post('/create-meeting', 'Controllers\TeamsController@createMeeting');
    Route::get('/meeting/{id}', 'Controllers\TeamsController@showMeeting');
    Route::post('/test-connection', 'Controllers\TeamsController@testConnection');
});
?>
