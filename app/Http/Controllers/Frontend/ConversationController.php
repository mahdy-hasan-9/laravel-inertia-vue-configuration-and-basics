<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function index()
    {
        return Inertia("conversation/Conversation", [
            'message' => 'this is conversation'
        ]);
    }
}
