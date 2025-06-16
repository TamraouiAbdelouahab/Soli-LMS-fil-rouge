<?php

namespace Modules\PkgSanction\App\Controllers;

use Illuminate\Http\Request;
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
        $redirectUrl = $this->notificationService->markAsRead(
            $id,
            $request->input('redirect_url')
        );

        return redirect($redirectUrl);
    }
}
