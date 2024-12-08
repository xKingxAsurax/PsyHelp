<?php

namespace App\Services;

use App\Models\UserData;
use Illuminate\Support\Str;

class DataCollectionService
{
    public function logUserAction($userId, $dataType, $value, $metadata = [])
    {
        return UserData::create([
            'user_id' => $userId,
            'data_type' => $dataType,
            'value' => $value,
            'timestamp' => now(),
            'session_id' => session()->getId(),
            'metadata' => $metadata
        ]);
    }

    public function logPageView($userId, $page, $metadata = [])
    {
        return $this->logUserAction($userId, 'page_view', $page, $metadata);
    }

    public function logInteraction($userId, $interactionType, $details, $metadata = [])
    {
        return $this->logUserAction($userId, 'interaction', $interactionType, array_merge([
            'details' => $details
        ], $metadata));
    }

    public function logError($userId, $errorType, $errorMessage, $metadata = [])
    {
        return $this->logUserAction($userId, 'error', $errorType, array_merge([
            'message' => $errorMessage
        ], $metadata));
    }
} 