<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['announcement', 'announcement_type', 'is_mail_sent'];
    public function getAnnouncementTypeLabelAttribute()
    {
        switch ($this->announcement_type) {
            case 0:
                return "Teacher";
            case 1:
                return "Student";
            case 2:
                return "Parent";
            case 3:
                return "Both";
            default:
                return "Unknown";
        }
    }
}
