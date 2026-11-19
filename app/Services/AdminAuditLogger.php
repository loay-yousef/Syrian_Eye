<?php

namespace App\Services;

use App\Models\AdminAuditLog;
use Illuminate\Http\Request;

final class AdminAuditLogger
{
    public function __construct(private readonly Request $request)
    {
    }

    public function record(string $action, ?string $reportType = null, ?int $reportId = null, array $metadata = []): void
    {
        AdminAuditLog::create([
            'user_id' => $this->request->user()?->id,
            'action' => $action,
            'report_type' => $reportType,
            'report_id' => $reportId,
            'metadata' => $metadata,
            'ip_address' => $this->request->ip(),
        ]);
    }
}
