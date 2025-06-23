<?php

namespace Modules\PkgSanction\App\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Core\App\Controllers\BaseController;
use Modules\PkgSanction\App\Services\NotificationService;

class NotificationController extends BaseController
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function markAsRead(Request $request, $id)
    {
        $this->notificationService->markAsRead($id);

        return Inertia::location($request->input('redirect_url', route('learner.sanction.index')));
    }
}
