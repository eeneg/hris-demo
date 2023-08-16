<?php

namespace App\Exports;

use App\Publication;
use App\SalaryGrade;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Writer;

class PublicationExport implements FromArray, WithHeadings
{
    public function __construct(
        protected Publication $publication
    ) {


        $publication->load('contents.plantillaContent.position.qs');
    }

    public function headings(): array
    {
        return [
            'position_title',
            'plantilla_item_no',
            'salary_grade',
            'annual_salary',
            'monthly_salary',
            'education',
            'training',
            'experience',
            'eligibility',
            'competency',
            'place_of_assignment',
        ];
    }

    public function array(): array
    {
        $ss = $this->publication->contents->first()->plantillaContent->first()->salaryproposed->salarySchedule;

        $sg = SalaryGrade::query()
            ->whereStep(1)
            ->whereIn('grade', $this->publication->contents->map->plantillaContent->map->salaryproposed->map->grade->unique()->values())
            ->whereHas('salaryschedule', fn ($q) => $q->whereYear('effective_date', $ss->effective_date))
            ->get();

        return $this->publication->contents->map(fn($content) => [
            $content->plantillaContent->position->title,
            (int) ($content->plantillaContent->new_number ?? $content->plantillaContent->old_number),
            $content->plantillaContent->salaryproposed->grade,
            $sg->first(fn ($sg) => $sg->grade === $content->plantillaContent->salaryproposed->grade)?->annual,
            $sg->first(fn ($sg) => $sg->grade === $content->plantillaContent->salaryproposed->grade)?->monthly,
            $content->plantillaContent->position->qs?->education,
            $content->plantillaContent->position->qs?->training,
            $content->plantillaContent->position->qs?->experience,
            $content->plantillaContent->position->qs?->eligibility,
            $content->plantillaContent->position->qs?->competency,
            $content->plantillaContent->position->department->title,
        ])->toArray();
    }
}
