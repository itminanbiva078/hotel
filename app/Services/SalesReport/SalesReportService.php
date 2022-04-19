<?php

namespace App\Services\SalesReport;
use App\Repositories\SalesReport\SalesReportRepositories;


class SalesReportService
{

    /**
     * @var SalesReportRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param SalesReportRepositories $salesReportRepositories
     */
    public function __construct(SalesReportRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

  
    /**
     * @param $request
     * @return mixed
     */
    public function getCustomerLedger($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerLedger($customer_id,$from_date,$to_date);
    }
    
    
    
    public function getCustomerPayment($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerPayment($customer_id,$from_date,$to_date);
    }



    public function getCustomerCashPayment($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerCashPayment($customer_id,$from_date,$to_date);
    }


     
    public function getCustomerChequePayment($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerChequePayment($customer_id,$from_date,$to_date);
    }



    public function getCustomerPendingChequePayment($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerPendingChequePayment($customer_id,$from_date,$to_date);
    }



    public function getCustomerSalesVoucher($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerSalesVoucher($customer_id,$from_date,$to_date);
    }



    public function getCustomerDueSalesVoucher($customer_id,$from_date,$to_date)
    {
        return $this->systemRepositories->getCustomerDueSalesVoucher($customer_id,$from_date,$to_date);
    }
     

   
 

}