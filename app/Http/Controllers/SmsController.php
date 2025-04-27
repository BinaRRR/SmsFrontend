<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    function humanifySmsContents($smses) {
        $tableContents = [];
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
            $json = ApiClient::request('get', '/sms')->json();
        }
        else {
            $json = ApiClient::request('get', '/sms')->json();
        }

        $tableHeaders = ['Message', 'Planned sending', 'Actually sent', 'Status'];
        $tableContents = $this->humanifySmsContents($json);
        
        return view('smses.smses', [
            "smses" => $tableContents,
            "tableHeaders" => $tableHeaders
        ]);
    }

    public function specific($smsId) : View
    {
        $json = ApiClient::request('get', "/sms/$smsId")->json();
        // dd($json);
        $tableHeaders = ['Name', 'Description', 'Recipient count'];
        $tableContents = $json['recipientGroups'];
        foreach ($tableContents as &$row) {
            unset($row['isAutomatic']);
        }
        // dd($tableContents);

        $allRecipientGroupsJson = ApiClient::request('get', '/recipient-group')->json();
        // dd($allRecipientGroupsJson);
        foreach ($allRecipientGroupsJson as &$row) {
            unset($row['isAutomatic']);
        }
        return view('smses.single-sms', [
            "sms" => $json,
            "tableHeaders" => $tableHeaders,
            "tableContents" => $tableContents,
            "allRecipientGroups" => $allRecipientGroupsJson,
        ]);
    }
}
