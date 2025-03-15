<?php

namespace App\Exports;

use App\PlantillaContent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaExport implements FromCollection, WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */

    protected $plantilla_id;

    public function __construct($plantilla_id)
    {
        $this->plantilla_id = $plantilla_id;
    }

    public function collection()
    {
        return PlantillaContent::leftJoin('positions', 'plantilla_contents.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'positions.department_id', '=', 'departments.id')
                ->leftJoin('plantilla_depts', function ($join) {
                    $join->on('departments.id', '=', 'plantilla_depts.department_id');
                    $join->on('plantilla_contents.plantilla_id', '=', 'plantilla_depts.plantilla_id');
                })
            ->where('plantilla_contents.plantilla_id', $this->plantilla_id)
            ->orderBy('plantilla_depts.order_number')->orderBy('plantilla_contents.order_number')
            ->get()
            ->map(function($item){
                return [
                    'department' => $item->position->department->address,
                    'old_number' => $item->old_number,  
                    'new_number' => $item->new_number,
                    'position_title' => $item->position->title,
                    'employee' => $item->personalinformation ? $item->personalinformation->surname.($item->personalinformation->nameextension ? ' '.$item->personalinformation->nameextension : '').', '.$item->personalinformation->firstname.' '.$item->personalinformation->middlename : 'VACANT',
                    'current_year_salary' => $item->salaryauthorized ? $item->salaryauthorized->grade . '/' . $item->salaryauthorized->step : '',
                    'current_year_salary_amount' => $item->salaryauthorized ? $item->salaryauthorized->amount : '',
                    'budget_year_salary' => $item->salaryproposed ? $item->salaryproposed->grade . '/' . $item->salaryproposed->step : '',
                    'budget_year_salary_amount' => $item->salaryproposed ? $item->salaryproposed->amount : '',
                    'date_of_birth' => $item->personalinformation ? $item->personalinformation->birthdate : '',
                    'date_of_original_appointment' => $item->original_appointment,
                    'date_of_last_promotion' => $item->last_promotion,
                    'nosi_schedule' => $item->personalinformation ? ($item->personalinformation->benefitschedule ? $item->personalinformation->benefitschedule->nosi : '') : '',
                    'loyalty_schedule' => $item->personalinformation ? ($item->personalinformation->benefitschedule ? $item->personalinformation->benefitschedule->loyalty : '') : '',
                    'appointment_status' => $item->appointment_status,
                    'working_time' => $item->working_time,
                    'csc_level' => $item->csc_level,
                    'civilstatus' => $item->personalinformation ? $item->personalinformation->civilstatus : '',
                ];
            });
            // ->sortBy('order_number')
            // ->sortBy('department');
    }

    public function headings(): array
    {
        $row1 = [
            'Department',
            'Old Number',
            'New Number',
            'Position Title',
            'Employee',
            'Current Year Authorized',
            '',
            'Budget Year Proposed',
            '',
            'Date of Birth',
            'Date of Original Appointment',
            'Date of Last Promotion',
            'NOSI Schedule',
            'Loyalty Schedule',
            'Appointment Status',
            'Working Time',
            'CSC Level',
            'Civil Status',
        ];

        $row2 = [
            '',
            '',
            '',
            '',
            '',
            'Grade/Step',
            'Amount',
            'Grade/Step',
            'Amount',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

        return [$row1, $row2];
    }
}
