<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnnouncementMail;


class SendAnnouncement extends Command
{
    protected $signature = 'send:announcement';

    protected $description = 'Send Email For New Announcement';

    public function handle()
    {
        try {
            $announcements = Announcement::where('announcement_type','!=',0)->where('is_mail_sent', 0)->get();

            foreach ($announcements as $announcement) {
                if($announcement->announcement_type == 1){
                    $users = Student::pluck('email')->toArray();
                } elseif($announcement->announcement_type == 2){
                    $users = ParentModel::pluck('email')->toArray();
                } elseif($announcement->announcement_type == 3){
                    $studentEmails = Student::pluck('email')->toArray();
                    $parentEmails = ParentModel::pluck('email')->toArray();
                    $users = array_merge($studentEmails, $parentEmails);
                }
                foreach($users as $user){
                    Mail::to($user)->send(new AnnouncementMail($announcement));
                    $announcement->is_mail_sent = 1;
                    $announcement->save();
                    sleep(1); //IT CAN BE REMOVE AS PER REQUIREMENT
                }
            }
        } catch (\Exception $e) {
            dd($e);
            Log::error('Failed to send mail', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
