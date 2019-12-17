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

            if (Auth::getAuthType() == AuthType::AUTH_LOCAL && !$_SESSION["user"]->isDefaultPasswordChanged()) {
                // Change password model
                RedirectManager::redirect("changepassword");
            }
            else{
                if(PermissionManager::getPermissions()->canGenerareReport()){
                    // Load view
                    ViewLoader::load("report/templates/header");
                    ViewLoader::load("report/index", array("types" => $this->available_types));
                    ViewLoader::load("report/templates/footer");
                }
                else{
                    // Show error page
                    ViewLoader::load("_templates/no_permission",
                        array("msg" => "Non hai i permessi necessari per generare dei report. "));
                }
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