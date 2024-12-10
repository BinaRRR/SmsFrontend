<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    function humanifyContents($smses) {
        $tableContents = [];
        foreach ($smses as $sms) {

            // dd($sms['actuallySent']);
            if ($sms['actuallySent'] != null) {
                $sms['status'] = 'Sent';
                $date = new DateTime($sms['actuallySent']);
                $sms['actuallySent'] = $date->format("d.m.Y | H:i:s");
            }
            else {
                $sms['status'] = 'Planned';
            }
            if ($sms['archiveTime'] != null) {
                $sms['status'] = 'Archived';
            }

            if ($sms['plannedSending'] != null) {
                $date = new DateTime($sms['plannedSending']);
                $sms['plannedSending'] = $date->format("d.m.Y | H:i:s");
            }

            unset($sms['archiveTime']);
            $tableContents[] = $sms;
        }
        return $tableContents;
    }

    public function index(): View
    {
        $json = Http::get("http://localhost:5202/api/sms")->json();

        $tableHeaders = ['ID', 'Message', 'Planned sending', 'Actually sent', 'Status'];
        $tableContents = $this->humanifyContents($json);
        
        return view('smses.smses', [
            "smses" => $tableContents,
            "tableHeaders" => $tableHeaders
        ]);
    }

    // public function specific($smsId) : View
    // {
    //     $json = Http::get("http://localhost:5202/api/sms/$smsId")->json();

    //     $tableHeaders = ['ID', 'Message', 'Planned sending', 'Actually sent', 'Status'];
    //     $tableContents = [];
    // foreach ($json['recipientMemberships'] as $membership) {
    //     $row = $membership['recipientGroup'];
    //     $date = new DateTime($membership['enrollmentDate']);
    //     $row['plannedSending'] = $date->format("d.m.Y | H:i:s");
    //     $row['actuallySent'] = $date->format("d.m.Y | H:i:s");
    //     $row['status']

    //     $tableContents[] = $row;
    // }

    //    $allRecipientGroupsJson = Http::get("http://localhost:5202/api/recipient-group/")->json();

    // dd($json);
    // return view('recipients.single-recipient', [
    //     "recipient" => $json,
    //     "tableHeaders" => $tableHeaders,
    //     "tableContents" => $tableContents,
    //     "allRecipientGroups" => $allRecipientGroupsJson,
    //     "secondTableHeaders" => array_splice($tableHeaders, 0, 3)
    // ]);
    // }
}
