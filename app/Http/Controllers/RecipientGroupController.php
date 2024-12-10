<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\put;

class RecipientGroupController extends Controller
{
    public function index() : View
    {
        $json = Http::get("http://localhost:5202/api/recipient-group")->json();
        // dd($json);
        return view('recipient-groups.recipient-groups', ["recipientGroups" => $json]);
    }

    public function specific($recipientGroupId) : View
    {
        $json = Http::get("http://localhost:5202/api/recipient-group/$recipientGroupId")->json();

        $tableHeaders = ['ID', 'Name', 'Phone number', 'Enrollment Date'];
        // dd($json['recipientMemberships']);
        $tableContents = [];
        foreach ($json['recipientMemberships'] as $membership) {
            $row = $membership['recipient'];
            $date = new DateTime($membership['enrollmentDate']);
            $row['enrollmentDate'] = $date->format("d.m.Y | H:i:s");

            $tableContents[] = $row;
        }
        // dd(array_values($json['recipientMemberships']));
        $allRecipientsJson = Http::get("http://localhost:5202/api/recipient")->json();

        // dd($json);
        return view('recipient-groups.single-recipient-group', [
            "recipientGroup" => $json,
            "tableHeaders" => $tableHeaders,
            "tableContents" => $tableContents,
            "allRecipients" => $allRecipientsJson,
            "secondTableHeaders" => array_splice($tableHeaders, 0, 3)
        ]);
    }
}
