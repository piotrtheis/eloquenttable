<?php

namespace Tysdever\EloquentTable\Traits;

use Excel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Session;
use Tysdever\EloquentAttachment\Attachment;

trait TableStreamerTrait
{

    /**
     * Export table rows.
     *
     * @return \Illuminate\Http\Response exported file
     */
    public function export()
    {
        $model = Session::get('eloquenttable_model');

        if (!($model instanceof Model)) {
            throw new Exception("Error Processing Request", 1);
        }

        $visibleColumns = array_keys($model->getVisible());

        //only visible columns
        $items = $model->get($visibleColumns);

        //map model field locale labels
        $header = array_map(function ($value) use ($model) {
            return $model->getFieldLabel($value);
        }, $visibleColumns);

        Excel::create('Filename', function ($excel) use ($items, $header) {

            $excel->sheet('Sheetname', function ($sheet) use ($items, $header) {
                $sheet->fromModel($items);

                $sheet->row(1, $header);

                $this->setSheetStyle($sheet);
            });
        })->export('xls');
    }

    
    /**
     * Import store action.
     * 
     * @return void
     */
    public function importStore()
    {

    }

    /**
     * Get file upload form with template file sample.
     * 
     * @return Form
     */
    protected function getUploadForm()
    {

    }

    /**
     * Handle imported file.
     * 
     * @return \Tysdever\EloquentAttachment\Attachment
     */
    protected function handleFileUpload()
    {

    }

    /**
     * Helper action for 
     * 
     * @param \Tysdever\EloquentAttachment\Attachment $name
     * @return void
     */
    protected function handleFielImport(Attachment $file)
    {

    }

    /**
     * Default sheet style.
     *
     * @param LaravelExcelWorksheet $sheet
     * @return void
     */
    protected function setSheetStyle(LaravelExcelWorksheet $sheet)
    {
        // Set black background
        $sheet->row(1, function ($row) {

            // call cell manipulation methods
            $row->setBackground('#EAF6EE');

            $row->setFont([
                'name' => 'Calibri',
                'size' => 12,
                'bold' => true,
            ]);
        });

        $sheet->setStyle([
            'font' => [
                'name' => 'Calibri',
                'size' => 10,
            ],
        ]);

        // Set height for a single row
        $sheet->setHeight(1, 30);

        // Set auto size for sheet
        $sheet->setAutoSize(true);

        // Sets all borders
        $sheet->setAllBorders('thin');
    }

}
