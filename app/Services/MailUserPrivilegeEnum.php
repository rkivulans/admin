<?php

namespace App\Services;

enum MailUserPrivilegeEnum: string
{
    case ADMIN = 'admin';
    case USER = '';
}
