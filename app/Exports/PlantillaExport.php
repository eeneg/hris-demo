<?php

namespace App\Exports;

use App\PlantillaContent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlantillaExport implements FromCollection, WithHeadings, WithStyles
{

    /**
    * @return \Illuminate\Support\Collection
    */

    protected $plantilla_id;

    public function __construct($plantilla_id)
    {
        $this->plantilla_id = $plantilla_id;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:AE2')->getFont()->setBold(true);
        $sheet->getStyle('A1:AE2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:AE2')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:AE2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:AE2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:AE2')->getFill()->getStartColor()->setARGB('FFCCFFCC');
        $sheet->getStyle('A1:AE2')->getFont()->setSize(12);

        // Merge cells for the header
        $sheet->mergeCells('A1:A2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('B1:B2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('C1:C2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('D1:D2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('E1:E2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('F1:F2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('G1:G2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('H1:H2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('I1:I2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('J1:J2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('K1:K2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('L1:L2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('M1:M2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('N1:N2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('O1:O2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('P1:P2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('Q1:S1', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('T1:V1', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('W1:W2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('X1:X2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('Y1:Y2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('Z1:Z2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('AA1:AA2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('AB1:AB2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('AC1:AC2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('AD1:AD2', Worksheet::MERGE_CELL_CONTENT_MERGE);
        $sheet->mergeCells('AE1:AE2', Worksheet::MERGE_CELL_CONTENT_MERGE);
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
                    'last_name' => $item->personalinformation ? $item->personalinformation->surname : '',
                    'first_name' => $item->personalinformation ? $item->personalinformation->firstname : '',
                    'middle_name' => $item->personalinformation ? $item->personalinformation->middlename : '',
                    'name_extension' => $item->personalinformation ? $item->personalinformation->nameextension : '',
                    'sex' => $item->personalinformation ? $item->personalinformation->sex : '',
                    'tin' => $item->personalinformation ? $item->personalinformation->tin : '',
                    'level' => $item->level,
                    'first_eligibility' => $item->personalinformation ? (count($item->personalinformation->eligibilities) > 0 ? $item->personalinformation->eligibilities[0]->careerService : '') : '',
                    'regligion' => $item->personalinformation ? ($item->personalinformation->religion == 'Others' ? $item->personalinformation->other_religion : $item->personalinformation->religion) : '',
                    'indigenous_people' => $item->personalinformation ? ($item->personalinformation->indigenous_people == 'Others' ? $item->personalinformation->other_indigenous_people : $item->personalinformation->indigenous_people) : '',
                    'disability' => $item->personalinformation ? ($item->personalinformation->disability == 'Others' ? $item->personalinformation->other_disability : $item->personalinformation->disability) : '',
                    'solo_parent_number' => $item->personalinformation ? $item->personalinformation->solo_parent_number : '',
                    // 'employee' => $item->personalinformation ? $item->personalinformation->surname.($item->personalinformation->nameextension ? ' '.$item->personalinformation->nameextension : '').', '.$item->personalinformation->firstname.' '.$item->personalinformation->middlename : 'VACANT',
                    'current_year_grade' => $item->salaryauthorized ? $item->salaryauthorized->grade : '',
                    'current_year_step' => $item->salaryauthorized ? $item->salaryauthorized->step : '',
                    'current_year_salary_amount' => $item->salaryauthorized ? $item->salaryauthorized->amount : '',
                    'budget_year_grade' => $item->salaryproposed ? $item->salaryproposed->grade : '',
                    'budget_year_step' => $item->salaryproposed ? $item->salaryproposed->step : '',
                    'budget_year_salary_amount' => $item->salaryproposed ? $item->salaryproposed->amount : '',
                    'date_of_birth' => $item->personalinformation ? date("m/d/Y", strtotime($item->personalinformation->birthdate)) : '',
                    'date_of_original_appointment' => date("m/d/Y", strtotime($item->original_appointment)),
                    'date_of_last_promotion' => date("m/d/Y", strtotime($item->last_promotion)),
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
            'Last name',
            'First name',
            'Middle name',
            'Name Extension',
            'Sex',
            'TIN',
            'Level',
            'Eligibility',
            'Religion',
            'Indigenous People',
            'Disability',
            'Solo Parent Number',
            'Current Year Authorized',
            '',
            '',
            'Budget Year Proposed',
            '',
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
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Grade',
            'Step',
            'Amount',
            'Grade',
            'Step',
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
