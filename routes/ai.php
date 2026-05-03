<?php

use App\Mcp\Servers\HtrackServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp', HtrackServer::class)
    ->middleware('auth:sanctum');
