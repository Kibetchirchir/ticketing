<?php
namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class test implements FromCollection, WithHeadings
{
    public function collection()
    {
        $users = User::select('firstname', 'lastname', 'email')
            ->where('role', '=', 'client')
            ->get();
        return $users;
    }

    public function headings(): array
    {
        return [
            'Firstname',
            'Secondname',
            'Email'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
