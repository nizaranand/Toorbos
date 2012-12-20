<?php

require_once (".citadel.config.conf");

$statusses = $__APPLICATION_['database']->fetcharray("select * from mod_debtorStatus where mod_debtorStatus_id!=1 and mod_debtorStatus_id!=10 and mod_debtorStatus_id!=6");

$htmlemail = '<table cellpadding="5" cellspacing="0">';
$excelFile = '<table cellpadding="5" cellspacing="0"><tr><td><b>Loan amount</b></td><td><b>Source</b></td><td><b>Referral</b></td><td><b>Practitioner</b></td><td><b>Industry</b></td><td><b>Region</b></td><td><b>Status</b></td><td><b>Last Status change</b></td></tr>';

foreach( $statusses as $key=>$value ){

        $count = $__APPLICATION_['database']->fetchrownamed("select count(*) from mod_debtor where debtorStatus=".$value['mod_debtorStatus_id']." and debtorStatus!=5 and mod_debtor.name!=\"\"".($value['mod_debtorStatus_id']==4 ? " and MONTH(now())=MONTH(mod_debtor.contractStartDate) " : "" )." order by mod_debtor.name");
                
        $htmlemail .= '<tr><td><b>'.$value['name'].'</b></td><td>'.$count['count(*)'].'</td>';
        
        $debtors = $__APPLICATION_['database']->fetcharray("select * from mod_debtor where debtorStatus=".$value['mod_debtorStatus_id']." and debtorStatus!=5 and mod_debtor.name!=\"\"".($value['mod_debtorStatus_id']==4 ? " and MONTH(now())=MONTH(mod_debtor.contractStartDate) " : "" )." order by mod_debtor.name");
        
        $totalLoan = 0;
        
        foreach( $debtors as $key2=>$value2 ){
        	$lastStatusChange = $__APPLICATION_['database']->fetchrownamed("select max(eventDate) from mod_auditTrailEvent where eventDescription like \"%debtorStatus=%\" and mod_auditTrailEvent.debtor=\"".$value2['mod_debtor_id']."\"");

       		$totalLoan += (float)(str_replace('R','',str_replace(' ','',$value2['loanAmountRequired'])));

       		$excelFile .= '<tr><td>R'.(str_replace('R','',str_replace(' ','',$value2['loanAmountRequired']))).'</td><td>Source</td><td>Referral</td><td>'.$value2['practiceClinicName'].'</td><td>'.$value2['practiceIndustry'].'</td><td>Region</td><td>'.$value['name'].'</td><td>'.$lastStatusChange['max(eventDate)'].'</td></tr>';

        }
        
        $htmlemail .= '<td>R'.$totalLoan.'</td></tr>';
        
}

$excelFile .= '</table>';

file_put_contents('/tmp/dailyReport-'.date('Ymd').'.xls', $excelFile);

$htmlemail .= '</table>';

$__APPLICATION_['utilities']->sendhtmlemailembedded('mare@sourceline.co.za,rika@sourceline.co.za', 'dynafin@fhf.co.za', 'FHF Dynafin', "Debtor status report", "HTML not supported", $htmlemail,array(),'/tmp/dailyReport-'.date('Ymd').'.xls');


?>
