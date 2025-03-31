<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class RecipientController extends Controller
{
    public function index() : View
    {
        $json = ApiClient::request('get', '/recipient')->json();
        // dd($json);
        return view('recipients.recipients', ["recipients" => $json]);
    }

    public function specific($recipientId) : View
    {
        $json = ApiClient::request('recipient', "/sms/$recipientId")->json();

        $tableHeaders = ['Name', 'Description', 'Enrollment Date'];
        $tableContents = [];
        foreach ($json['recipientMemberships'] as $membership) {
            $row = $membership['recipientGroup'];
            $date = new DateTime($membership['enrollmentDate']);
            $row['enrollmentDate'] = $date->format("d.m.Y | H:i:s");

            $tableContents[] = $row;
        }

       $allRecipientGroupsJson = ApiClient::request('get', '/recipient-group')->json();

        // dd($json);
        return view('recipients.single-recipient', [
            "recipient" => $json,
            "tableHeaders" => $tableHeaders,
            "tableContents" => $tableContents,
            "allRecipientGroups" => $allRecipientGroupsJson,
            "secondTableHeaders" => array_splice($tableHeaders, 0, 3)
        ]);
    }
}
