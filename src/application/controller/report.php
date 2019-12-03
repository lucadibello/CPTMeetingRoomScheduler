<?php


class Report
{
    public function index(){
        if(Auth::isAuthenticated()){
            $report = new ReportGenerator(ReportType::YEAR);
            $report->generatePDF();
        }
        else{
            RedirectManager::redirect("");
        }
    }
}