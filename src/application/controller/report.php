<?php


class Report
{
    private $available_types = [
        "Giornaliero" => ReportType::DAY,
        "Settimanale" => ReportType::WEEK,
        "Mensile" => ReportType::MONTH,
        "Annuale" => ReportType::YEAR,
        "Completo" => ReportType::ALL
    ];

    public function index()
    {
        if (Auth::isAuthenticated()) {
            if(PermissionManager::getPermissions()->canGenerareReport()){
                // Load view
                ViewLoader::load("report/templates/header");
                ViewLoader::load("report/index", array("types" => $this->available_types));
                ViewLoader::load("report/templates/footer");
            }
            else{
                // TODO: NEW NO PERMISSION PAGE
                echo "Non hai i permessi per generare report";
            }
        } else {
            RedirectManager::redirect("");
        }
    }

    public function generate()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $type = (int)$_POST["type"];
            $all_rows_flag = isset($_POST["all"]) && $_POST["all"] == true;

            if (in_array($type, $this->available_types)) {
                // Generate pdf
                $report = new ReportGenerator($type, $all_rows_flag);
                $report->generatePDF();
            } else {
                RedirectManager::redirect("report");
            }
        } else {
            RedirectManager::redirect("report");
        }
    }
}