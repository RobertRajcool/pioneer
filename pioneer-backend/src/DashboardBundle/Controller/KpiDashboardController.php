<?php

namespace DashboardBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use UserBundle\Controller\UserController;
use UserBundle\Util\CommonFunctions;

/**
 * IncidentController.
 * @Route("/kpidashboard")
 */
class KpiDashboardController extends Controller
{
    /**
     * Find all data for kpi dashboardindex
     * @Rest\POST("/indexaction",name="indexaction")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * Find all data for kpi dashboard
     * @Rest\POST("/kpidashboarddata",name="kpidashboard")
     */
    public function findallIncidentswithoutPaginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $role = $userobject->getRoles();
        $year = $request->request->get('year');
        if($year==null){
            $year=date('Y');
        }
        $lastdayofYear='01-12-'.$year;
        $lastMonthdateObject=new \DateTime($lastdayofYear);
        $lastMonthdateObject->modify('last day of this month');
        $firstdayofYear='01-01-'.$year;
        $fistMonthdateObject=new \DateTime($firstdayofYear);
        $fistMonthdateObject->modify('last day of this month');
        if($companyId==null){
            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName,s.manufacturingYear')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->andWhere('YEAR(s.createdDate) <= :currentYear')
                ->setParameter('userObject', $userobject)
                ->setParameter('currentYear',$year)
                ->getQuery()
                ->getResult();
        }
        else{

            $vesselList = $em->createQueryBuilder()
                ->select('s.id,s.shipName,s.manufacturingYear')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->andWhere('YEAR(s.createdDate) <= :currentYear')
                ->setParameter('companyId', $userobject->getCompanyId())
                ->setParameter('currentYear',$year)
                ->getQuery()
                ->getResult();
        }
        $overallShipDetailArray = array();
        $redarea_vessel_shipid=array();
        $greenarea_vessel_shipids=array();
        $yellowarea_vessel_shipid=array();
        $lastMonthvesselpieChart="";
        for ($shipCount = 0; $shipCount < count($vesselList); $shipCount++) {
            $rankingKpiValueCountArray = array();
            $rankingShipName = $vesselList[$shipCount]['shipName'];
            $manufacturingYear = $vesselList[$shipCount]['manufacturingYear'];
            $rankingShipId = $vesselList[$shipCount]['id'];
            $monthlyKpiValue = array();
            $newcategories = array();
            $monthlyKpiAverageScore = array();
            $statusQueryResult = $em->createQueryBuilder()
                ->select('b.dataofmonth,b.status')
                ->from('RankingBundle:RankingLookupStatus', 'b')
                ->where('b.status = 4')
                ->andwhere('b.dataofmonth <= :activeDate')
                ->andwhere('b.dataofmonth >= :startDate')
                ->setParameter('startDate', $fistMonthdateObject)
                ->setParameter('activeDate', $lastMonthdateObject)
                ->groupby('b.dataofmonth')
                ->getQuery()
                ->getResult();
            $currentYear_montharray = array();
            $monthlyKpiValue = array();
            $newcategories = array();
            for ($numberofmonthCount = 0; $numberofmonthCount < count($statusQueryResult); $numberofmonthCount++) {
                $currentDate=$statusQueryResult[$numberofmonthCount]['dataofmonth'];
                array_push($currentYear_montharray, $currentDate->format('Y-m-d'));
            }
            $rankingKpiList = $em->createQueryBuilder()
                ->select('b.kpiName,b.id,b.weightage')
                ->from('RankingBundle:RankingKpiDetails', 'b')
                ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                ->add('orderBy', 'b.id  ASC ')
                ->groupBy('b.kpiName')
                ->getQuery()
                ->getResult();
            if(count($currentYear_montharray) > 0 ) {
                for ($monthCount = 0; $monthCount < count($currentYear_montharray); $monthCount++) {
                    $currentDateObject= new \DateTime($currentYear_montharray[$monthCount]);
                    $currentDateObject->modify('last day of this month');
                    array_push($newcategories, $currentDateObject->format('M'));
                    $rankingKpiValueCountArray = array();
                    $rankingKpiWeightarray = array();
                    for ($rankingKpiCount = 0; $rankingKpiCount < count($rankingKpiList); $rankingKpiCount++) {
                        $rankingElementValueTotal = 0;
                        $rankingKpiId = $rankingKpiList[$rankingKpiCount]['id'];
                        $rankingKpiWeight = $rankingKpiList[$rankingKpiCount]['weightage'];
                        $rankingKpiName = $rankingKpiList[$rankingKpiCount]['kpiName'];
                        array_push($rankingKpiWeightarray, $rankingKpiWeight);
                        if ($rankingKpiName == 'Vessel age') {
                            $Vessage_count=0;
                            if ($manufacturingYear == "") {
                                $yearcount = 0;
                            } else {

                                $man_datestring = $manufacturingYear. '-01';
                                $temp_man_year = new \DateTime($man_datestring);
                                $temp_man_year->modify('last day of this month');
                                $Vessage_count = $temp_man_year->diff($currentDateObject)->y;
                            }
                            $vesselage = ($Vessage_count * $rankingKpiWeight) / 20;
                            array_push($rankingKpiValueCountArray, $vesselage);
                        }
                        else
                        {
                            $rankingElementList = $em->createQueryBuilder()
                                ->select('ele.id,ele.elementName,ele.weightage,ele.vesselWiseTotal,b.value')
                                ->from('RankingBundle:RankingElementDetails', 'ele')
                                ->join('RankingBundle:RankingMonthlyData', 'b', 'with', 'ele.id = b.elementDetailsId')
                                ->where('ele.dateTime <= :dateTime')
                                ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                                ->andWhere('b.monthdetail =:dataofmonth and b.shipDetailsId = :shipId')
                                ->setParameter('dateTime', $currentDateObject)
                                ->setParameter('dataofmonth', $currentDateObject)
                                ->setParameter('kpidetailsid', $rankingKpiId)
                                ->setParameter('shipId', $rankingShipId)
                                ->add('orderBy', 'ele.id  DESC ')
                                ->getQuery()
                                ->getResult();

                            if (count($rankingElementList) > 0) {
                                for ($rankingElementCount = 0; $rankingElementCount < count($rankingElementList); $rankingElementCount++) {
                                    $rankingElementName = $rankingElementList[$rankingElementCount]['elementName'];
                                    $rankingElementId = $rankingElementList[$rankingElementCount]['id'];
                                    $rankingElementWeight = $rankingElementList[$rankingElementCount]['weightage'];
                                    $rankingElementValue = $rankingElementList[$rankingElementCount]['value'];
                                    $rankingElementResultColor = "";
                                    $rankingElementColorValue = 0;
                                    $rankingElementResult = $em->createQueryBuilder()
                                        ->select('b.elementdata, b.elementcolor')
                                        ->from('RankingBundle:RankingLookupData', 'b')
                                        ->where('b.kpiDetailsId = :kpiId and b.shipDetailsId = :shipId and b.elementDetailsId = :elementId and b.monthdetail = :monthDetail')
                                        ->setParameter('kpiId', $rankingKpiId)
                                        ->setParameter('shipId', $rankingShipId)
                                        ->setParameter('elementId', $rankingElementId)
                                        ->setParameter('monthDetail', $currentDateObject)
                                        ->getQuery()
                                        ->getResult();
                                    if (count($rankingElementResult) != 0) {
                                        $rankingElementResultColor = $rankingElementResult[0]['elementcolor'];
                                    }

                                    if ($rankingElementResultColor == "false") {
                                        $rankingElementResultColor = "";
                                    }
                                    if ($rankingElementResultColor == 'Green') {
                                        $rankingElementColorValue = $rankingElementWeight;
                                    } else if ($rankingElementResultColor == 'Yellow') {
                                        $rankingElementColorValue = $rankingElementWeight / 2;
                                    } else if ($rankingElementResultColor == 'Red') {
                                        $rankingElementColorValue = 0;
                                    }
                                    $rankingElementValueTotal += $rankingElementColorValue;
                                }
                            }
                            else if (count($rankingElementList) == 0) {
                                $findnewkpiList = $em->createQueryBuilder()
                                    ->select('b.kpiName', 'b.id')
                                    ->from('RankingBundle:RankingKpiDetails', 'b')
                                    ->where('b.kpiName = :kpiName')
                                    ->andwhere('b.createdDateTime <= :dateTime')
                                    ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                                    ->setParameter('dateTime', $currentDateObject)
                                    ->setParameter('kpiName', $rankingKpiName)
                                    ->add('orderBy', 'b.id  ASC ')
                                    ->groupby('b.kpiName')
                                    ->getQuery()
                                    ->getResult();
                                if(count($findnewkpiList)!=0){
                                    $newkpiId = $findnewkpiList[0]['id'];
                                    $newkpiName = $findnewkpiList[0]['kpiName'];
                                    $rankingElementList = $em->createQueryBuilder()
                                        ->select('ele.id,ele.elementName,ele.weightage,ele.vesselWiseTotal,b.value')
                                        ->from('RankingBundle:RankingElementDetails', 'ele')
                                        ->join('RankingBundle:RankingMonthlyData', 'b', 'with', 'ele.id = b.elementDetailsId')
                                        ->where('ele.dateTime <= :dateTime')
                                        ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                                        ->andWhere('b.monthdetail =:dataofmonth and b.shipDetailsId = :shipId')
                                        ->setParameter('dateTime', $currentDateObject)
                                        ->setParameter('dataofmonth', $currentDateObject)
                                        ->setParameter('kpidetailsid', $newkpiId)
                                        ->setParameter('shipId', $rankingShipId)
                                        ->add('orderBy', 'ele.id  DESC ')
                                        ->getQuery()
                                        ->getResult();
                                    for ($rankingElementCount = 0; $rankingElementCount < count($rankingElementList); $rankingElementCount++) {
                                        $rankingElementName = $rankingElementList[$rankingElementCount]['elementName'];
                                        $rankingElementId = $rankingElementList[$rankingElementCount]['id'];
                                        $rankingElementWeight = $rankingElementList[$rankingElementCount]['weightage'];
                                        $rankingElementValue = $rankingElementList[$rankingElementCount]['value'];
                                        $rankingElementResultColor = "";
                                        $rankingElementColorValue = 0;
                                        $rankingElementResult = $em->createQueryBuilder()
                                            ->select('b.elementdata, b.elementcolor')
                                            ->from('RankingBundle:RankingLookupData', 'b')
                                            ->where('b.kpiDetailsId = :kpiId and b.shipDetailsId = :shipId and b.elementDetailsId = :elementId and b.monthdetail = :monthDetail')
                                            ->setParameter('kpiId', $rankingKpiId)
                                            ->setParameter('shipId', $rankingShipId)
                                            ->setParameter('elementId', $rankingElementId)
                                            ->setParameter('monthDetail', $currentDateObject)
                                            ->getQuery()
                                            ->getResult();
                                        if (count($rankingElementResult) != 0) {
                                            $rankingElementResultColor = $rankingElementResult[0]['elementcolor'];
                                        }

                                        if ($rankingElementResultColor == "false") {
                                            $rankingElementResultColor = "";
                                        }

                                        if ($rankingElementResultColor == 'Green') {
                                            $rankingElementColorValue = $rankingElementWeight;
                                        } else if ($rankingElementResultColor == 'Yellow') {

                                            $rankingElementColorValue = $rankingElementWeight / 2;
                                        } else if ($rankingElementResultColor == 'Red') {
                                            $rankingElementColorValue = 0;
                                        }
                                        $rankingElementValueTotal += $rankingElementColorValue;
                                    }
                                }
                            }
                            array_push($rankingKpiValueCountArray, ($rankingElementValueTotal * $rankingKpiWeight / 100));
                        }
                    }
                    array_push($monthlyKpiValue, $rankingKpiValueCountArray);
                    array_push($monthlyKpiAverageScore, array_sum($rankingKpiValueCountArray));
                    //This is Vessel pie data calculating Starts Here
                    if($monthCount==(count($currentYear_montharray)-1))
                    {
                        $lastMonthvesselpieChart=$currentDateObject->format('M-Y');
                        if(array_sum($rankingKpiValueCountArray)>=80)
                        {
                            array_push($greenarea_vessel_shipids,$rankingShipId);

                        }
                        else if(array_sum($rankingKpiValueCountArray)>=70)
                        {
                            array_push($yellowarea_vessel_shipid,$rankingShipId);
                        }
                        else if(array_sum($rankingKpiValueCountArray)<70)
                        {
                            array_push($redarea_vessel_shipid,$rankingShipId);
                        }

                    }
                }
                $overallShipDetailArray[$shipCount]['y'] = (array_sum($monthlyKpiAverageScore)/(count($currentYear_montharray)));
            }
            else{
                $overallShipDetailArray[$shipCount]['y']=0;
            }
            $overallShipDetailArray[$shipCount]['name'] = $rankingShipName;
            $overallShipDetailArray[$shipCount]['shipId'] = $rankingShipId;
        }
        $response = new Response($this->serialize(['rankinggraphData' =>$overallShipDetailArray , 'currentYear' => $year]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Find findInduivalshipwiseData
     * @Rest\POST("/listallkpiforship_ranking",name="listallkpiforship_ranking")
     */
    public function findInduivalshipwiseDataAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $role = $userobject->getRoles();
        $year = $request->request->get('year');
        $shipId = $request->request->get('shipId');
        $lastdayofYear='01-12-'.$year;
        $lastMonthdateObject=new \DateTime($lastdayofYear);
        $lastMonthdateObject->modify('last day of this month');
        $firstdayofYear='01-01-'.$year;
        $fistMonthdateObject=new \DateTime($firstdayofYear);
        $fistMonthdateObject->modify('last day of this month');
        $curretshipObject=$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipId));
        $shipName = $curretshipObject->getShipName();
        $man_year = $curretshipObject->getManufacturingYear();
        $statusQueryResult = $em->createQueryBuilder()
            ->select('b.dataofmonth,b.status')
            ->from('RankingBundle:RankingLookupStatus', 'b')
            ->where('b.status = 4')
            ->andwhere('b.dataofmonth <= :activeDate')
            ->andwhere('b.dataofmonth >= :startDate')
            ->andwhere('b.shipDetailsId = :shipId')
            ->setParameter('startDate', $fistMonthdateObject)
            ->setParameter('activeDate', $lastMonthdateObject)
            ->setParameter('shipId',$curretshipObject)
            ->getQuery()
            ->getResult();
        $currentYear_montharray = array();
        $monthlyKpiValue = array();
        $newcategories = array();
        $monthlyKpiAverageScore = array();
        for ($numberofmonthCount = 0; $numberofmonthCount < count($statusQueryResult); $numberofmonthCount++) {
            $currentDate=$statusQueryResult[$numberofmonthCount]['dataofmonth'];
            array_push($currentYear_montharray, $currentDate->format('Y-m-d'));
        }
        $rankingKpiList = $em->createQueryBuilder()
            ->select('b.kpiName,b.id,b.weightage')
            ->from('RankingBundle:RankingKpiDetails', 'b')
            ->where('b.createdDateTime <= :dateTime')
            ->andwhere('b.shipDetailsId =:currentshipId')
            ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
            ->setParameter('currentshipId',$curretshipObject)
            ->setParameter('dateTime', $lastMonthdateObject)
            ->add('orderBy', 'b.id  ASC ')
            ->groupBy('b.kpiName')
            ->getQuery()
            ->getResult();
        for ($shipwisemonthCount = 0; $shipwisemonthCount < count($currentYear_montharray); $shipwisemonthCount++) {
            $currentDateObject = new \DateTime($currentYear_montharray[$shipwisemonthCount]);
            $currentDateObject->modify('last day of this month');
            array_push($newcategories, $currentDateObject->format('M'));
            $rankingKpiValueCountArray = array();
            $rankingKpiWeightarray = array();
            for ($rankingKpiCount = 0; $rankingKpiCount < count($rankingKpiList); $rankingKpiCount++) {
                $rankingElementValueTotal = 0;
                $rankingKpiId = $rankingKpiList[$rankingKpiCount]['id'];
                $rankingKpiWeight = $rankingKpiList[$rankingKpiCount]['weightage'];
                $rankingKpiName = $rankingKpiList[$rankingKpiCount]['kpiName'];
                array_push($rankingKpiWeightarray, $rankingKpiWeight);
                $vessage_count=0;
                if ($rankingKpiName=='Vessel age')
                {
                    if ($man_year == "")
                    {
                        $yearcount = 0;
                    }
                    else
                    {

                        $man_datestring = $man_year . '-01-' . '01';
                        $temp_man_year = new \DateTime($man_datestring);
                        $temp_man_year->modify('last day of this month');
                        $vessage_count= $temp_man_year->diff($currentDateObject)->y;
                    }
                    $vesselage=($vessage_count*$rankingKpiWeight)/20;
                    array_push($rankingKpiValueCountArray,$vesselage);

                }
                else
                {
                    $rankingElementList = $em->createQueryBuilder()
                        ->select('ele.id,ele.elementName,ele.weightage,ele.vesselWiseTotal,b.value')
                        ->from('RankingBundle:RankingElementDetails', 'ele')
                        ->join('RankingBundle:RankingMonthlyData', 'b', 'with', 'ele.id = b.elementDetailsId')
                        ->where('ele.dateTime <= :dateTime')
                        ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                        ->andWhere('b.monthdetail =:dataofmonth and b.shipDetailsId = :shipId')
                        ->setParameter('dateTime', $currentDateObject)
                        ->setParameter('dataofmonth', $currentDateObject)
                        ->setParameter('kpidetailsid', $rankingKpiId)
                        ->setParameter('shipId', $curretshipObject)
                        ->add('orderBy', 'ele.id  DESC ')
                        ->getQuery()
                        ->getResult();

                    if (count($rankingElementList) > 0) {
                        for ($rankingElementCount = 0; $rankingElementCount < count($rankingElementList); $rankingElementCount++) {
                            $rankingElementName = $rankingElementList[$rankingElementCount]['elementName'];
                            $rankingElementId = $rankingElementList[$rankingElementCount]['id'];
                            $rankingElementWeight = $rankingElementList[$rankingElementCount]['weightage'];
                            $rankingElementValue = $rankingElementList[$rankingElementCount]['value'];
                            $rankingElementResultColor = "";
                            $rankingElementColorValue = 0;
                            $rankingElementResult = $em->createQueryBuilder()
                                ->select('b.elementdata, b.elementcolor')
                                ->from('RankingBundle:RankingLookupData', 'b')
                                ->where('b.kpiDetailsId = :kpiId and b.shipDetailsId = :shipId and b.elementDetailsId = :elementId and b.monthdetail = :monthDetail')
                                ->setParameter('kpiId', $rankingKpiId)
                                ->setParameter('shipId', $curretshipObject)
                                ->setParameter('elementId', $rankingElementId)
                                ->setParameter('monthDetail', $currentDateObject)
                                ->getQuery()
                                ->getResult();
                            if (count($rankingElementResult) != 0) {
                                $rankingElementResultColor = $rankingElementResult[0]['elementcolor'];
                            }

                            if ($rankingElementResultColor == "false") {
                                $rankingElementResultColor = "";
                            }
                            if ($rankingElementResultColor == 'Green') {
                                $rankingElementColorValue = $rankingElementWeight;
                            } else if ($rankingElementResultColor == 'Yellow') {
                                $rankingElementColorValue = $rankingElementWeight / 2;
                            } else if ($rankingElementResultColor == 'Red') {
                                $rankingElementColorValue = 0;
                            }
                            $rankingElementValueTotal += $rankingElementColorValue;
                        }
                    }
                    else if (count($rankingElementList) == 0) {
                        $findnewkpiList = $em->createQueryBuilder()
                            ->select('b.kpiName', 'b.id')
                            ->from('RankingBundle:RankingKpiDetails', 'b')
                            ->where('b.kpiName = :kpiName')
                            ->andwhere('b.createdDateTime <= :dateTime')
                            ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                            ->setParameter('dateTime', $currentDateObject)
                            ->setParameter('kpiName', $rankingKpiName)
                            ->add('orderBy', 'b.id  ASC ')
                            ->groupby('b.kpiName')
                            ->getQuery()
                            ->getResult();
                        if(count($findnewkpiList)!=0){
                            $newkpiId = $findnewkpiList[0]['id'];
                            $newkpiName = $findnewkpiList[0]['kpiName'];
                            $rankingElementList = $em->createQueryBuilder()
                                ->select('ele.id,ele.elementName,ele.weightage,ele.vesselWiseTotal,b.value')
                                ->from('RankingBundle:RankingElementDetails', 'ele')
                                ->join('RankingBundle:RankingMonthlyData', 'b', 'with', 'ele.id = b.elementDetailsId')
                                ->where('ele.dateTime <= :dateTime')
                                ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                                ->andWhere('b.monthdetail =:dataofmonth and b.shipDetailsId = :shipId')
                                ->setParameter('dateTime', $currentDateObject)
                                ->setParameter('dataofmonth', $currentDateObject)
                                ->setParameter('kpidetailsid', $newkpiId)
                                ->setParameter('shipId', $curretshipObject)
                                ->add('orderBy', 'ele.id  DESC ')
                                ->getQuery()
                                ->getResult();
                            for ($rankingElementCount = 0; $rankingElementCount < count($rankingElementList); $rankingElementCount++) {
                                $rankingElementName = $rankingElementList[$rankingElementCount]['elementName'];
                                $rankingElementId = $rankingElementList[$rankingElementCount]['id'];
                                $rankingElementWeight = $rankingElementList[$rankingElementCount]['weightage'];
                                $rankingElementValue = $rankingElementList[$rankingElementCount]['value'];
                                $rankingElementResultColor = "";
                                $rankingElementColorValue = 0;
                                $rankingElementResult = $em->createQueryBuilder()
                                    ->select('b.elementdata, b.elementcolor')
                                    ->from('RankingBundle:RankingLookupData', 'b')
                                    ->where('b.kpiDetailsId = :kpiId and b.shipDetailsId = :shipId and b.elementDetailsId = :elementId and b.monthdetail = :monthDetail')
                                    ->setParameter('kpiId', $rankingKpiId)
                                    ->setParameter('shipId', $curretshipObject)
                                    ->setParameter('elementId', $rankingElementId)
                                    ->setParameter('monthDetail', $currentDateObject)
                                    ->getQuery()
                                    ->getResult();
                                if (count($rankingElementResult) != 0) {
                                    $rankingElementResultColor = $rankingElementResult[0]['elementcolor'];
                                }

                                if ($rankingElementResultColor == "false") {
                                    $rankingElementResultColor = "";
                                }

                                if ($rankingElementResultColor == 'Green') {
                                    $rankingElementColorValue = $rankingElementWeight;
                                } else if ($rankingElementResultColor == 'Yellow') {

                                    $rankingElementColorValue = $rankingElementWeight / 2;
                                } else if ($rankingElementResultColor == 'Red') {
                                    $rankingElementColorValue = 0;
                                }
                                $rankingElementValueTotal += $rankingElementColorValue;
                            }
                        }
                    }
                    array_push($rankingKpiValueCountArray, ($rankingElementValueTotal * $rankingKpiWeight / 100));
                }
            }
            array_push($monthlyKpiValue, $rankingKpiValueCountArray);
            array_push($monthlyKpiAverageScore, array_sum($rankingKpiValueCountArray));
        }
        if ($man_year == "") {
            $yearcount = 0;
        } else {
            $currentdatestring = date('Y-m-d');
            $currentdatetime = new \DateTime($currentdatestring);
            // $man_datestring = $man_year . '-01-' . '01';
            // $d2 = new \DateTime($man_datestring);
            //$diff = $d2->diff($d1);
            //$yearcount = $diff->y;
            $man_datestring = $man_year . '-01-' . '01';
            $temp_man_year = new \DateTime($man_datestring);
            $temp_man_year->modify('last day of this month');
            $currentdatetime->modify('last day of this month');
            $yearcount= $temp_man_year->diff($currentdatetime)->y;
        }
        $response = new Response($this->serialize([
            'listofkpi' => $rankingKpiList,
            'kpiweightage' => $rankingKpiWeightarray,
            'montharray' => $newcategories,
            'shipname' => $shipName,
            'countmonth' => count($newcategories),
            'avgscore' => $monthlyKpiAverageScore,
            'kpimonthdata' => $monthlyKpiValue,
            'currentyear' => $year,
            'ageofvessel' => $yearcount
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Set base HTTP headers.
     *
     * @param Response $response
     *
     * @return Response
     */
    public function setBaseHeaders(Response $response)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
    /**
     * Data serializing via JMS serializer.
     *
     * @param mixed $data
     *
     * @return string JSON string
     */
    public function serialize($data)
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get('jms_serializer')
            ->serialize($data, 'json', $context);
    }
}
