<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Excel;
use App\Exports\test;


/**
 * Class ExtractController
 * @package App\Http\Controllers
 */
class ExtractController extends Controller
{
    //
    /**
     * @return mixed
     */
    public function Extract(){

        $users = User::select('firstname', 'lastname', 'email', 'bio')
            ->where('role', '=', 'client')
            ->get();


//        // Generate and return the spreadsheet
//        Excel::export('payments', function($excel) use ($users) {
//
//            // Set the spreadsheet title, creator, and description
//            $excel->setTitle('Emails');
//            $excel->setCreator('Laravel')->setCompany('Chirchir and sons tech company');
//            $excel->setDescription('Emails');
//
//            // Build the spreadsheet, passing in the payments array
//            $excel->sheet('sheet1', function($sheet) use ($users) {
//                $sheet->fromArray($users, null, 'A1', false, false);
//            });
//
//        })->download('xlsx');

        return Excel::download(new test, 'final.xlsx');
    }

    /**
     * @return mixed
     */
    public function send(Request $request)
    {
        if ($request->hasFile('import_file')) {
            Excel::load($request->file('import_file')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    $data['Firstname'] = $row['Firstname'];
                    $data['Email'] = $row['Email'];

                    if (!empty($data)) {
                        $name = $data['Firstname'];
                        Mail::to($data['Email'])->send(new SendMailable($name));

                        return 'Email was sent';

                    }

                }
            });
        }}
    }
