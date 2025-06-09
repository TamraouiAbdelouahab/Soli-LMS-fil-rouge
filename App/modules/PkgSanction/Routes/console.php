<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('sanction:daily-check')->daily();
