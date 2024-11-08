<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class RecipientController extends Controller
{
    public function index() : View
    {
        $json = Http::get("http://localhost:5202/api/recipient")->json();
        // dd($json);
        return view('recipients.recipients', ["recipients" => $json]);
    }

    public function specific($recipientId) : View
    {
        $json = Http::get("http://localhost:5202/api/recipient/$recipientId")->json();

        $tableHeaders = ['ID', 'Name', 'Description', 'Enrollment Date'];
        $tableContents = [];
        foreach ($json['recipientMemberships'] as $membership) {
            $row = $membership['recipientGroup'];
            $date = new DateTime($membership['enrollmentDate']);
            $row['enrollmentDate'] = $date->format("d.m.Y | H:i:s");

            $tableContents[] = $row;
        }
        // dd($tableContents);
        // dd(array_values($json['recipientMemberships']));

        // dd($json);
        return view('recipients.single-recipient', ["recipient" => $json, "tableHeaders" => $tableHeaders, "tableContents" => $tableContents]);
    }
}
