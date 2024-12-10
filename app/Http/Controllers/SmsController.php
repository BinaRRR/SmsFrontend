<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    function humanifySmsContents($smses) {
        $tableContents = [];
        // dd($smses);
        foreach ($smses as $sms) {
            $tableContents[] = $this->processSingleSms($sms);
        }
        return $tableContents;
    }

    function processSingleSms($sms) {
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

        return $sms;
    }

    public function index(Request $request): View
    {
        if ($request->has('archived')) {
            $json = Http::get("http://localhost:5202/api/sms?showArchived=true")->json();
        }
        else {
            $json = Http::get("http://localhost:5202/api/sms")->json();
        }

        $tableHeaders = ['ID', 'Message', 'Planned sending', 'Actually sent', 'Status'];
        $tableContents = $this->humanifySmsContents($json);
        
        return view('smses.smses', [
            "smses" => $tableContents,
            "tableHeaders" => $tableHeaders
        ]);
    }

    public function specific($smsId) : View
    {
        $json = Http::get("http://localhost:5202/api/sms/$smsId")->json();

        $tableHeaders = ['ID', 'Name', 'Description'];
        $tableContents = $json['recipientGroups'];
        $allRecipientGroupsJson = Http::get("http://localhost:5202/api/recipient-group/")->json();
        return view('smses.single-sms', [
            "sms" => $json,
            "tableHeaders" => $tableHeaders,
            "tableContents" => $tableContents,
            "allRecipientGroups" => $allRecipientGroupsJson,
        ]);
    }
}
