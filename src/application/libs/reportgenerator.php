<?php

class ReportGenerator
{
    private $report_type;
    private $show_old_bookings;

    public function __construct(int $report_type, bool $show_old_bookings = false)
    {
        $this->report_type = $report_type;
        $this->show_old_bookings = $show_old_bookings;
    }

    public function generatePDF()
    {
        // Generate report header infos
        $report_type = "";

        switch ($this->report_type){
            case ReportType::DAY:
                $report_type = "Giornaliero";
                break;
            case ReportType::WEEK:
                $report_type = "Settimanale";
                break;
            case ReportType::MONTH:
                $report_type = "Mensile";
                break;
            case ReportType::YEAR:
                $report_type = "Annuale";
                break;
            case ReportType::ALL:
                $report_type = "Tutto";
                break;
        }

        // Create PDF object with custom header
        $pdf = new PDF("Report aula riunioni");
        // Add page to PDF
        $pdf->AddPage();

        $date = new DateTime();
        $pdf->SetTitle("Report CPTMRS " . $date->format("d/m/Y H:i"));

        // Add info related to the report
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(100, 5, "Data: " . $date->format("d/m/Y"));
        $pdf->Ln(10);
        $pdf->Cell(100, 5, "Generato da: " . $_SESSION["user"]->getUsername());
        $pdf->Ln(10);
        $pdf->Cell(100, 5, "Tipo: " . $report_type);
        $pdf->Ln(30);

        // Create Table
        $pdf->Table(DB::get(),$this->_generate_query());

        // Show output
        $pdf->Output("I", $date->format("Y_m_d_H_i") . "_Report_CPTMRS");
    }

    private function _generate_query(): string
    {
        $_base_query = "SELECT utente,
                        DATE_FORMAT(data, '%d/%m/%Y') as 'Data' ,
                        TIME_FORMAT(ora_inizio, '%H:%i') as 'Ora inizio',
                        TIME_FORMAT(ora_fine, '%H:%i') as 'Ora fine'
                        FROM riservazione";

        $_order_by_date = " ORDER BY data, ora_inizio, ora_fine ASC";

        // Check report type
        switch ($this->report_type) {
            case ReportType::DAY:
                // Report with daily bookings
                if ($this->show_old_bookings) {
                    // Show all daily bookings
                    return $_base_query . " WHERE data=CURRENT_DATE()" . $_order_by_date;
                } else {
                    // Show only queue bookings
                    return $_base_query . " WHERE data=CURRENT_DATE() AND TIMESTAMP(CONCAT(data,' ', ora_inizio)) > NOW()". $_order_by_date;
                }
                break;
            case ReportType::WEEK:
                // Report with weekly bookings
                if ($this->show_old_bookings) {
                    // Show all weekly bookings
                    return $_base_query . " WHERE yearweek(data) = yearweek(CURRENT_DATE())". $_order_by_date;
                } else {
                    // Show only weekly bookings
                    return $_base_query . " WHERE yearweek(data) = yearweek(CURRENT_DATE()) AND TIMESTAMP(CONCAT(data,' ', ora_inizio)) > NOW()". $_order_by_date;
                }
                break;
            case ReportType::MONTH:
                // Report with monthly bookings
                if ($this->show_old_bookings) {
                    return $_base_query . " WHERE MONTH(data) = MONTH(CURRENT_DATE())". $_order_by_date;
                } else {
                    return $_base_query . " WHERE MONTH(data) = MONTH(CURRENT_DATE()) AND TIMESTAMP(CONCAT(data,' ', ora_inizio)) > NOW()". $_order_by_date;
                }
                break;
            case ReportType::YEAR:
                // Report with yearly bookings
                if ($this->show_old_bookings) {
                    // Show all yearly bookings
                    return $_base_query . " WHERE YEAR(data) = YEAR(CURRENT_DATE())". $_order_by_date;
                } else {
                    // Show only yearly bookings
                    return $_base_query . " WHERE YEAR(data) = YEAR(CURRENT_DATE()) AND TIMESTAMP(CONCAT(data,' ', ora_inizio)) > NOW()". $_order_by_date;
                }
                break;
            case ReportType::ALL:
                // Report all the bookings
                if ($this->show_old_bookings) {
                    // Show all bookings
                    return $_base_query . $_order_by_date;
                } else {
                    // Show only queue bookings
                    return $_base_query . " WHERE TIMESTAMP(CONCAT(data,' ', ora_inizio)) > NOW()" . $_order_by_date;
                }
                break;
            default:
                return false;
                break;
        }
    }
}

// http://www.fpdf.org/en/script/script14.php
class PDF_MySQL_Table extends \Fpdf\Fpdf
{
    protected $ProcessingTable = false;
    protected $aCols = array();
    protected $TableX;
    protected $HeaderColor;
    protected $RowColors;
    protected $ColorIndex;

    function Header()
    {
        // Print the table header if necessary
        if ($this->ProcessingTable)
            $this->TableHeader();
    }

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY($this->h - 10);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,5,'Pagina '.$this->PageNo(),0,0,'R');
    }


    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 18);
        $this->SetX($this->TableX);
        $fill = !empty($this->HeaderColor);
        if ($fill)
            $this->SetFillColor($this->HeaderColor[0], $this->HeaderColor[1], $this->HeaderColor[2]);
        foreach ($this->aCols as $col)
            $this->Cell($col['w'], 12, $col['c'], 1, 0, 'C', $fill);
        $this->Ln();
    }

    function Table($link, $query, $prop = array())
    {
        // Execute query
        $res = mysqli_query($link, $query) or die("<h1>C'è stato un errore durante la generazione del PDF. Contattare un amministratore</h1> <br><br><br> Error: " . mysqli_error($link) . "<br><br>Query: $query");
        // Add all columns if none was specified
        if (count($this->aCols) == 0) {
            $nb = mysqli_num_fields($res);
            for ($i = 0; $i < $nb; $i++)
                $this->AddCol();
        }
        // Retrieve column names when not specified
        foreach ($this->aCols as $i => $col) {
            if ($col['c'] == '') {
                if (is_string($col['f']))
                    $this->aCols[$i]['c'] = ucfirst($col['f']);
                else
                    $this->aCols[$i]['c'] = ucfirst(mysqli_fetch_field_direct($res, $col['f'])->name);
            }
        }
        // Handle properties
        if (!isset($prop['width']))
            $prop['width'] = 0;
        if ($prop['width'] == 0)
            $prop['width'] = $this->w - $this->lMargin - $this->rMargin;
        if (!isset($prop['align']))
            $prop['align'] = 'C';
        if (!isset($prop['padding']))
            $prop['padding'] = $this->cMargin;
        $cMargin = $this->cMargin;
        $this->cMargin = $prop['padding'];
        if (!isset($prop['HeaderColor']))
            $prop['HeaderColor'] = array();
        $this->HeaderColor = $prop['HeaderColor'];
        if (!isset($prop['color1']))
            $prop['color1'] = array();
        if (!isset($prop['color2']))
            $prop['color2'] = array();
        $this->RowColors = array($prop['color1'], $prop['color2']);
        // Compute column widths
        $this->CalcWidths($prop['width'], $prop['align']);
        // Print header
        $this->TableHeader();
        // Print rows
        $this->SetFont('Arial', '', 11);
        $this->ColorIndex = 0;
        $this->ProcessingTable = true;

        // Check if there is data or not
        if(mysqli_num_rows($res) > 0){
            while ($row = mysqli_fetch_array($res))
                $this->Row($row);
        }
        else{
            $this->CustomTextRow
            (
                "Non sono state trovate prenotazioni che soddisfano la richiesta.",
                $prop["width"],
                20
            );
        }

        $this->ProcessingTable = false;
        $this->cMargin = $cMargin;
        $this->aCols = array();
    }

    function AddCol($field = -1, $width = -1, $caption = '', $align = 'L')
    {
        // Add a column to the table
        if ($field == -1)
            $field = count($this->aCols);
        $this->aCols[] = array('f' => $field, 'c' => $caption, 'w' => $width, 'a' => $align);
    }

    function CalcWidths($width, $align)
    {
        // Compute the widths of the columns
        $TableWidth = 0;
        foreach ($this->aCols as $i => $col) {
            $w = $col['w'];
            if ($w == -1)
                $w = $width / count($this->aCols);
            elseif (substr($w, -1) == '%')
                $w = $w / 100 * $width;
            $this->aCols[$i]['w'] = $w;
            $TableWidth += $w;
        }
        // Compute the abscissa of the table
        if ($align == 'C')
            $this->TableX = max(($this->w - $TableWidth) / 2, 0);
        elseif ($align == 'R')
            $this->TableX = max($this->w - $this->rMargin - $TableWidth, 0);
        else
            $this->TableX = $this->lMargin;
    }

    function Row($data)
    {
        $this->SetX($this->TableX);
        $ci = $this->ColorIndex;
        $fill = !empty($this->RowColors[$ci]);
        if ($fill)
            $this->SetFillColor($this->RowColors[$ci][0], $this->RowColors[$ci][1], $this->RowColors[$ci][2]);
        foreach ($this->aCols as $col)
            $this->Cell($col['w'], 5, $data[$col['f']], 1, 0, $col['a'], $fill);
        $this->Ln();
        $this->ColorIndex = 1 - $ci;
    }

    function CustomTextRow($text,$w,$h=5){
        $this->SetX($this->TableX);
        $ci = $this->ColorIndex;
        $fill = !empty($this->RowColors[$ci]);
        if ($fill)
            $this->SetFillColor($this->RowColors[$ci][0], $this->RowColors[$ci][1], $this->RowColors[$ci][2]);

        $this->Cell($w, $h, $text, 1, 0, 'C', $fill);
        $this->Ln();

        $this->ColorIndex = 1 - $ci;
    }
}

// http://www.fpdf.org/en/script/script14.php
class PDF extends PDF_MySQL_Table {

    private $_title;

    public function __construct($header_text,$orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        $this->_title = $header_text;
        parent::__construct($orientation, $unit, $size);
    }

    function Header()
    {
        // Title
        $this->SetFont('Arial','b',24);
        $this->Cell(0,6,$this->_title,0,1,'C');
        $this->Ln(10);
        // Ensure table header is printed
        parent::Header();
    }
    /*
    function Footer(){
        parent::Footer();
    }
    */
}

abstract class ReportType
{
    const DAY = 0;
    const WEEK = 1;
    const MONTH = 2;
    const YEAR = 3;
    const ALL = 4;
}

