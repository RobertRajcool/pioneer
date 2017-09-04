<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 19/1/17
 * Time: 12:33 PM
 */

namespace RankingBundle\Services;
use RankingBundle\Entity\RankingLookupData;
use RankingBundle\Entity\ScorecardLookupData;
use Symfony\Component\Console\Output\NullOutput;
use Mmoreram\GearmanBundle\Command\Util\GearmanOutputAwareInterface;
use Mmoreram\GearmanBundle\Driver\Gearman;
use UserBundle\Util\CommonFunctions;

/**
 * @Gearman\Work(
 *     defaultMethod = "doBackground",
 *     service = "executenodefindcolor.worker"
 * )
 *
 * Gearman worker for ExecuteNodeFindColor
 *
 * Class ExecuteNodeFindColor
 * @package RankingBundle\Services
 */
class ExecuteNodeFindColor
{
    private $doctrine;
    private $container;



    /**
     * Constructor
     */
    public function __construct($doctrine,$container)
    {

        $this->doctrine = $doctrine;
        $this->container=$container;



    }
    /**
     * Scorecard Execute Node and Find color
     *
     * @param \GearmanJob $job Scorecard Execute Node and Find color
     *
     * @return boolean
     *
     * @Gearman\Job(
     *     iterations = 1,
     *     name = "scorecard_execute_node_findcolor"
     * )
     */
    public function scorecardLookupDataUpdate(\GearmanJob $job)
    {
        $em= $this->doctrine->getManager();
        $commonfunction_object=new CommonFunctions();
        $parametervalues = json_decode($job->workload());
        $shipid = $parametervalues->{'shipid'};
        $curretshipObject = $em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' => $shipid));
        $dataofmonth = $parametervalues->{'dataofmonth'};
        $time = strtotime($dataofmonth);
        $newformat = date('Y-m-d', $time);
        $dateObject = new \DateTime($newformat);
        $dateObject->modify('last day of this month');
        $lookupstatusData = $em->getRepository('RankingBundle:ScorecardLookupData')->findOneBy(array('monthdetail'=>$dateObject));
        $lookupStatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('monthdetail'=>$dateObject));
        $total_numberofShipsInserted_count=0;
        if($lookupStatus!=null){
            $shipsInString=$lookupStatus->getShipids();
            $total_numberofShipsInserted_count=count(explode(",", $shipsInString));
        }
        else {
            $total_numberofShipsInserted_count=0;
        }
        for($count=0;$count<count($lookupstatusData);$count++)
        {
            $id=$lookupstatusData->getId();
            $qb = $em->createQueryBuilder()
                ->delete('RankingBundle:ScorecardLookupData', 'd')
                ->where('d.id = :lookudataId')
                ->setParameter(':lookudataId', $id)
                ->getQuery()
                ->getResult();
        }
        $userid = $parametervalues->{'userid'};
        $status = $parametervalues->{'status'};
        $datetime=$parametervalues->{'datetime'};
        $currenttime = strtotime($datetime);
        $currentnewformat = date('Y-m-d H:i:s', $currenttime);
        $current_new_date = new \DateTime($currentnewformat);
        if($status==3)
        {
            $monthlyScorecardKpiColorArray = array();
            $ElementColorforKpi = array();
            $scorecardKpiColorArray = array();
            $listofKpiIds = $em->createQueryBuilder()
                ->select('b.kpiName', 'b.id')
                ->from('RankingBundle:RankingKpiDetails', 'b')
                ->where('b.createdDateTime <= :dateTime')
                ->andwhere('b.kpiName != :vesselageValue')
                ->andwhere('b.kpiStatusValue = 2 or b.kpiStatusValue = 3')
                ->setParameter('vesselageValue', 'Vessel age')
                ->setParameter('dateTime', $dateObject)
                ->add('orderBy', 'b.id  ASC ')
                ->groupBy('b.kpiName')
                ->getQuery()
                ->getResult();
            $monthlyScorecardKpiWeightAverageValueTotal = 0;

            for($kpiCount=0;$kpiCount<count($listofKpiIds);$kpiCount++)
            {
                // echo "Forloop Scorecard";
                $scorecardKpiId = $listofKpiIds[0]['id'];
                $scorecardAllKpiId = $listofKpiIds[$kpiCount]['id'];
                // echo "Forloop Scorecard after";
                $scorecardKpiWeight = $listofKpiIds[$kpiCount]['weightage'];
                $scorecardKpiName = $listofKpiIds[$kpiCount]['kpiName'];
                $kpiSumValue=0;
                $ElementColor=array();
                $ElementIds=array();

                $elementList = $em->createQueryBuilder()
                    ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                    ->from('RankingBundle:RankingElementDetails', 'ele')
                    ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                    ->where('ele.dateTime <= :dateTime')
                    ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                    ->setParameter('dateTime', $dateObject)
                    ->setParameter('kpidetailsid', $scorecardKpiId)
                    ->add('orderBy', 'ele.id  DESC ')
                    ->getQuery()
                    ->getResult();

                if(count($elementList)>0)
                {
                    //echo "if condition";
                    for($elementCount=0;$elementCount<count($elementList);$elementCount++)
                    {
                        // print_r($scorecardElementArray);
                        //echo "forloop";
                        $scorecardElementId = $elementList[$elementCount]['id'];
                        array_push($ElementIds,$scorecardElementId);
                        $scorecardElementWeight = $elementList[$elementCount]['weightage'];
                        $scorecardElementSumValue = $elementList[$elementCount]['value'];
                        $vesselWiseTotalStatus = $elementList[$elementCount]['vesselWiseTotal'];
                        $comparisonStatus=$elementList[$elementCount]['comparisonStatus'];
                        //echo  "after for loop";
                        /*if($vesselWiseTotalStatus == "Average") {
                            $averageElementValue = $scorecardElementSumValue / count($TotalShipsInserted);
                        } else if($vesselWiseTotalStatus == "Sum") {
                            $averageElementValue = $scorecardElementSumValue;
                        }
                        else {
                            $averageElementValue = $scorecardElementSumValue / count($TotalShipsInserted);
                        }*/
                        //Find element average value
                        if((int)($comparisonStatus)==1)
                        {
                            $scorecardElementRulesArray = $em->createQueryBuilder()
                                ->select('a.rules')
                                ->from('RankingBundle:ElementComparisonRules', 'a')
                                ->where('a.elementDetailsId = :elementId')
                                ->setParameter('elementId', $scorecardElementId)
                                ->getQuery()
                                ->getResult();
                            $elementResultColor = "";
                            $elementColorValue=0;
                            for($elementRulesCount=0;$elementRulesCount<count($scorecardElementRulesArray);$elementRulesCount++)
                            {
                                $newjson_decodevalue=json_decode((string)$scorecardElementRulesArray[$elementRulesCount]['rules']);
                                $first_ElementId=$newjson_decodevalue->first->id;
                                $second_ElementId=$newjson_decodevalue->second->id;
                                $first_ElementValue= $em->createQueryBuilder()
                                    ->select('sum(a.value) as value')
                                    ->from('RankingBundle:ScorecardMonthlyData', 'a')
                                    ->where('a.elementDetailsId = :elementId and a.monthdetail = :monthName and a.kpiDetailsId = :kpiId')
                                    ->setParameter('elementId', $first_ElementId)
                                    ->setParameter('monthName',$dateObject)
                                    ->setParameter('kpiId',$scorecardAllKpiId)
                                    ->getQuery()
                                    ->getResult();
                                $second_ElementValue=$em->createQueryBuilder()
                                    ->select('sum(a.value) as value')
                                    ->from('RankingBundle:ScorecardMonthlyData', 'a')
                                    ->where('a.elementDetailsId = :elementId and a.monthdetail = :monthName and a.kpiDetailsId = :kpiId')
                                    ->setParameter('elementId', $second_ElementId)
                                    ->setParameter('monthName',$dateObject)
                                    ->setParameter('kpiId',$scorecardAllKpiId)
                                    ->getQuery()
                                    ->getResult();
                                $average_FirstElementValue=$commonfunction_object->find_Avg_Sum_Calculation($vesselWiseTotalStatus,$first_ElementValue[0]['value'],$total_numberofShipsInserted_count);
                                $average_SecondElementValue=$commonfunction_object->find_Avg_Sum_Calculation($vesselWiseTotalStatus,$second_ElementValue[0]['value'],$total_numberofShipsInserted_count);
                                $first_ElementResult=$commonfunction_object->find_options_ComparsionRule($newjson_decodevalue->first->option,$average_FirstElementValue,(int)$newjson_decodevalue->first->value);
                                $second_ElementResult=$commonfunction_object->find_options_ComparsionRule($newjson_decodevalue->second->option,$average_SecondElementValue,(int)$newjson_decodevalue->second->value);
                                if($first_ElementResult==true &&$second_ElementResult==true)
                                {
                                    $elementResultColor=$newjson_decodevalue->action->color;
                                    if ($elementResultColor == "Green") {
                                        $elementColorValue = 3;
                                    } else if ($elementResultColor == "Yellow") {
                                        $elementColorValue = 2;
                                    } else if ($elementResultColor == "Red") {
                                        $elementColorValue = 1;
                                    }
                                    break;

                                }
                                else
                                {
                                    continue;
                                }
                            }

                        }
                        else
                        {
                            $averageElementValue=$commonfunction_object->find_Avg_Sum_Calculation($vesselWiseTotalStatus,$scorecardElementSumValue,$total_numberofShipsInserted_count);
                            $elementRulesQueryResult = $em->createQueryBuilder()
                                ->select('a.rules,a.id')
                                ->from('RankingBundle:RankingRulesDetails', 'a')
                                ->where('a.elementDetailsId=:elementId')
                                ->setParameter('elementId', $scorecardElementId)
                                ->getQuery()
                                ->getResult();
                            $elementResultColor = "";
                            $elementColorValue=0;

                            for($elementRulesCount=0;$elementRulesCount<count($elementRulesQueryResult);$elementRulesCount++)
                            {
                                $elementRule = $elementRulesQueryResult[$elementRulesCount];
                                $elementJsFileDirectory = $this->container->getParameter('kernel.root_dir') . '/../web/business-rules/findcolorfromrules.js \'' . $elementRule['rules'] . ' \' ' . ((float)$averageElementValue);
                                $elementJsFileName = 'node ' . $elementJsFileDirectory;
                                $handle = popen($elementJsFileName, 'r');
                                $elementColor = fread($handle, 2096);
                                $elementResultColor = str_replace("\n", '', $elementColor);
                                if ($elementResultColor == "false") {
                                    continue;
                                }
                                if ($elementResultColor == "Green") {
                                    $elementColorValue = 3;
                                    break;
                                } else if ($elementResultColor == "Yellow") {
                                    $elementColorValue = 2;
                                    break;
                                } else if ($elementResultColor == "Red") {
                                    $elementColorValue = 1;
                                    break;
                                }
                            }
                        }
                        $elementValueWithWeight = $elementColorValue * (((int)$scorecardElementWeight) / 100);
                        $kpiSumValue+=$elementValueWithWeight;
                        array_push($ElementColor,$elementResultColor);

                    }

                }
                $elementKpiQueryResult = $em->createQueryBuilder()
                    ->select('a.rules,a.id')
                    ->from('RankingBundle:RankingKpiRulesDetails', 'a')
                    ->where('a.kpiId=:kpiIds')
                    ->setParameter('kpiIds', $scorecardKpiId)
                    ->getQuery()
                    ->getResult();
                $kpiResultColor='';
                for ($kpiRulesCount = 0; $kpiRulesCount < count($elementKpiQueryResult); $kpiRulesCount++)
                {
                    $kpiRule = $elementKpiQueryResult[$kpiRulesCount];
                    $kpiJsFileDirectory = $this->container->getParameter('kernel.root_dir') . '/../web/business-rules/findcolorfromrules.js \'' . $kpiRule['rules'] . ' \' ' . $kpiSumValue;
                    $kpiJsFileName = 'node ' . $kpiJsFileDirectory;
                    $handle = popen($kpiJsFileName, 'r');
                    $kpiColor = fread($handle, 2096);
                    $kpiResultColor = str_replace("\n", '', $kpiColor);
                    if ($kpiResultColor != "false")
                    {
                        break;
                    }
                }

                for($Elementcolorcount=0;$Elementcolorcount<count($ElementColor);$Elementcolorcount++)
                {
                    $lookupdataobject=new ScorecardLookupData();
                    $lookupdataobject->setShipDetailsId($lookupStatus->getShipids());
                    $lookupdataobject->setElementcolor($ElementColor[$Elementcolorcount]);
                    $lookupdataobject->setKpiColor($kpiResultColor);
                    $lookupdataobject->setMonthdetail($dateObject);
                    $lookupdataobject->setIndividualKpiAverageScore($kpiSumValue);
                    $elementObject = $em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' => $ElementIds[$Elementcolorcount]));
                    $lookupdataobject->setElementDetailsId($elementObject);
                    $lookupdataobject->setKpiDetailsId($elementObject->getKpiDetailsId());
                    $em->persist($lookupdataobject);
                    $em->flush();
                }

            }

        }
        if($lookupStatus!=null) {
            $lookupStatus->setStatus(4);
            $lookupStatus->setDatetime(new \DateTime());
            $em->flush();
        }
        echo "Data inserted";
        return true;


    }

    /**
     * Ranking Execute Node and Find color
     *
     * @param \GearmanJob $job  Ranking Execute Node and Find color
     *
     * @return boolean
     *
     * @Gearman\Job(
     *     iterations = 1,
     *     name = "ranking_execute_node_findcolor"
     * )
     */
    public function rankingLookupDataUpdate(\GearmanJob $job)
    {
        //echo "Hi";
        $em= $this->doctrine->getManager();
        $parametervalues = json_decode($job->workload());
        $shipid = $parametervalues->{'shipid'};
        $newshipid = $em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' => $shipid));
        $dataofmonth = $parametervalues->{'dataofmonth'};
        $time = strtotime($dataofmonth);
        $newformat = date('Y-m-d', $time);
        $new_date = new \DateTime($newformat);
        $new_date->modify('last day of this month');
        $newlookstatus = $em->getRepository('RankingBundle:RankingLookupData')->findBy(array('shipDetailsId' => $newshipid,'monthdetail'=>$new_date));
        $userid = $parametervalues->{'userid'};
        $status = $parametervalues->{'status'};
        $datetime=$parametervalues->{'datetime'};
        $kpistatusValue = $parametervalues->{'kpistatusValue'};
        $currenttime = strtotime($datetime);
        $currentnewformat = date('Y-m-d H:i:s', $currenttime);
        $current_new_date = new \DateTime($currentnewformat);
        if($status==3)
        {/*
            $rankingKpiList = $em->createQueryBuilder()
                ->select('b.kpiName', 'b.id', 'b.weightage')
                ->from('InitialShippingBundle:RankingKpiDetails', 'b')
                ->where('b.shipDetailsId = :shipid')
                ->setParameter('shipid', $shipid)
                ->getQuery()
                ->getResult();*/
            $listofKpiIds = $em->createQueryBuilder()
                ->select('b.kpiName,b.id,b.weightage')
                ->from('RankingBundle:RankingKpiDetails', 'b')
                ->where('b.createdDateTime <= :dateTime')
                ->andwhere('b.kpiName != :vesselageValue')
                ->andwhere('b.shipDetailsId =:currentshipId')
                ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                ->setParameter('currentshipId',$shipid)
                ->setParameter('vesselageValue', 'Vessel age')
                ->setParameter('dateTime', $new_date)
                ->add('orderBy', 'b.id  ASC ')
                ->groupBy('b.kpiName')
                ->getQuery()
                ->getResult();
            for($rankingKpiCount=0;$rankingKpiCount<count($listofKpiIds);$rankingKpiCount++)
            {
                $rankingElementValueTotal = 0;
                $rankingKpiId = $listofKpiIds[$rankingKpiCount]['id'];
                $rankingKpiWeight = $listofKpiIds[$rankingKpiCount]['weightage'];
                $rankingKpiName = $listofKpiIds[$rankingKpiCount]['kpiName'];
               /* $elementForKpiList = $em->createQueryBuilder()
                    ->select('a.elementName', 'a.id', 'a.weightage')
                    ->from('InitialShippingBundle:RankingElementDetails', 'a')
                    ->where('a.kpiDetailsId = :kpiid')
                    ->setParameter('kpiid', $rankingKpiId)
                    ->getQuery()
                    ->getResult();*/
                $elementList = $em->createQueryBuilder()
                    ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                    ->from('RankingBundle:RankingElementDetails', 'ele')
                    ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                    ->where('ele.dateTime <= :dateTime')
                    ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                    ->setParameter('dateTime', $new_date)
                    ->setParameter('kpidetailsid', $rankingKpiId)
                    ->add('orderBy', 'ele.id  ASC ')
                    ->getQuery()
                    ->getResult();
                if(count($elementList)>0)
                {
                    for($elementCount=0;$elementCount<count($elementList);$elementCount++)
                    {
                        $scorecardElementId = $elementList[$elementCount]['id'];
                        $scorecardElementWeight = $elementList[$elementCount]['weightage'];
                        $elementDbValue = $em->createQueryBuilder()
                            ->select('a.value')
                            ->from('RankingBundle:RankingMonthlyData', 'a')
                            ->where('a.elementDetailsId = :elementId and a.monthdetail = :monthName and a.shipDetailsId = :shipId and a.kpiDetailsId = :kpiId and a.status = :statusvalue')
                            ->setParameter('elementId', $scorecardElementId)
                            ->setParameter('monthName',$new_date->format('Y-m-d'))
                            ->setParameter('shipId',$shipid)
                            ->setParameter('statusvalue',3)
                            ->setParameter('kpiId',$rankingKpiId)
                            ->getQuery()
                            ->getResult();
                        $rankingElementRulesArray = $em->createQueryBuilder()
                            ->select('a.rules')
                            ->from('RankingBundle:RankingRulesDetails', 'a')
                            ->where('a.elementDetailsId = :elementId')
                            ->setParameter('elementId', $scorecardElementId)
                            ->getQuery()
                            ->getResult();
                        $elementResultColor = "";
                        $elementColorValue=0;
                        if(count($elementDbValue)!=0)
                        {
                            for($elementRulesCount=0;$elementRulesCount<count($rankingElementRulesArray);$elementRulesCount++)
                            {
                                $elementRule = $rankingElementRulesArray[$elementRulesCount];
                                $elementJsFileDirectory = $this->container->getParameter('kernel.root_dir') . '/../web/business-rules/findcolorfromrules.js \'' . $elementRule['rules'] . ' \' ' . $elementDbValue[0]['value'];
                                $elementJsFileName = 'node ' . $elementJsFileDirectory;
                                $handle = popen($elementJsFileName, 'r');
                                $elementColor = fread($handle, 2096);
                                $elementResultColor = str_replace("\n", '', $elementColor);

                                if ($elementResultColor == "false") {
                                    continue;
                                }

                                if ($elementResultColor == "Green") {
                                    $elementColorValue = $scorecardElementWeight;
                                    break;
                                } else if ($elementResultColor == "Yellow") {
                                    $elementColorValue = $scorecardElementWeight/2;
                                    break;
                                } else if ($elementResultColor == "Red") {
                                    $elementColorValue = 0;
                                    break;
                                }
                            }
                        }
                        else
                        {
                            $elementDbValue[0]['value']=null;
                        }
                        //array_push($kpiElementColorArray,$elementResultColor);
                        //$elementValueWithWeight = $elementColorValue ;
                        //echo $elementResultColor;
                        $lookupdataobject=new RankingLookupData();
                        $lookupdataobject->setShipDetailsId($newshipid);
                        $lookupdataobject->setElementcolor($elementResultColor);
                        $lookupdataobject->setMonthdetail($new_date);
                        $lookupdataobject->setElementdata($elementColorValue);
                        $newkpiid = $em->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('id' =>$rankingKpiId));
                        $newelementid = $em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' => $scorecardElementId));
                        $lookupdataobject->setElementDetailsId($newelementid);
                        $lookupdataobject->setKpiDetailsId($newkpiid);
                        $em->persist($lookupdataobject);
                        $em->flush();
                    }

                }
                if(count($elementList)==0)
                {
                    $findnewkpiList = $em->createQueryBuilder()
                        ->select('b.kpiName,b.id,b.weightage')
                        ->from('RankingBundle:RankingKpiDetails', 'b')
                        ->where('b.kpiName = :kpiName')
                        ->andwhere('b.createdDateTime <= :dateTime')
                        ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                        ->setParameter('dateTime', $new_date)
                        ->setParameter('kpiName', $rankingKpiName)
                        ->add('orderBy', 'b.id  ASC ')
                        ->groupby('b.kpiName')
                        ->getQuery()
                        ->getResult();
                    $newkpiId=0;
                    if(count($findnewkpiList)!=0){
                        $newkpiId = $findnewkpiList[0]['id'];
                        $newkpiName = $findnewkpiList[0]['kpiName'];
                        $elementList = $em->createQueryBuilder()
                            ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                            ->from('RankingBundle:RankingElementDetails', 'ele')
                            ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                            ->where('ele.dateTime <= :dateTime')
                            ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                            ->setParameter('dateTime', $new_date)
                            ->setParameter('kpidetailsid', $newkpiId)
                            ->add('orderBy', 'ele.id  ASC ')
                            ->getQuery()
                            ->getResult();
                    }
                    else{
                        $newkpiId = null;
                        $elementList=array();
                    }

                    for($elementCount=0;$elementCount<count($elementList);$elementCount++)
                    {
                        $scorecardElementId = $elementList[$elementCount]['id'];
                        $scorecardElementWeight = $elementList[$elementCount]['weightage'];
                        $elementDbValue = $em->createQueryBuilder()
                            ->select('a.value')
                            ->from('RankingBundle:RankingMonthlyData', 'a')
                            ->where('a.elementDetailsId = :elementId and a.monthdetail = :monthName and a.shipDetailsId = :shipId and a.kpiDetailsId = :kpiId and a.status = :statusvalue')
                            ->setParameter('elementId', $scorecardElementId)
                            ->setParameter('monthName',$new_date)
                            ->setParameter('shipId',$shipid)
                            ->setParameter('statusvalue',3)
                            ->setParameter('kpiId',$newkpiId)
                            ->getQuery()
                            ->getResult();
                        $rankingElementRulesArray = $em->createQueryBuilder()
                            ->select('a.rules')
                            ->from('RankingBundle:RankingRulesDetails', 'a')
                            ->where('a.elementDetailsId = :elementId')
                            ->setParameter('elementId', $scorecardElementId)
                            ->getQuery()
                            ->getResult();
                        $elementResultColor = "";
                        $elementColorValue=0;
                        if(count($elementDbValue)!=0)
                        {
                            // echo $elementDbValue[0]['value'];
                            for($elementRulesCount=0;$elementRulesCount<count($rankingElementRulesArray);$elementRulesCount++)
                            {
                                $elementRule = $rankingElementRulesArray[$elementRulesCount];
                                $elementJsFileDirectory = $this->container->getParameter('kernel.root_dir') . '/../web/business-rules/findcolorfromrules.js \'' . $elementRule['rules'] . ' \' ' . $elementDbValue[0]['value'];
                                $elementJsFileName = 'node ' . $elementJsFileDirectory;
                                $handle = popen($elementJsFileName, 'r');
                                $elementColor = fread($handle, 2096);
                                $elementResultColor = str_replace("\n", '', $elementColor);

                                if ($elementResultColor == "false") {
                                    continue;
                                }

                                if ($elementResultColor == "Green") {
                                    $elementColorValue = $scorecardElementWeight;
                                    break;
                                } else if ($elementResultColor == "Yellow") {
                                    $elementColorValue = $scorecardElementWeight/2;
                                    break;
                                } else if ($elementResultColor == "Red") {
                                    $elementColorValue = 0;
                                    break;
                                }
                            }
                        }
                        else
                        {
                            $elementDbValue[0]['value']=null;
                        }
                        $lookupdataobject=new RankingLookupData();
                        $lookupdataobject->setShipDetailsId($newshipid);
                        $lookupdataobject->setElementcolor($elementResultColor);
                        $lookupdataobject->setMonthdetail($new_date);
                        $lookupdataobject->setElementdata($elementColorValue);
                        $newkpiidobject = $em->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('id' => $newkpiId));
                        $newelementid = $em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' => $scorecardElementId));
                        $lookupdataobject->setElementDetailsId($newelementid);
                        $lookupdataobject->setKpiDetailsId($newkpiidobject);
                        $em->persist($lookupdataobject);
                        $em->flush();
                    }
                }
            }
        }
        $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findBy(array('shipDetailsId' => $newshipid,'dataofmonth'=>$new_date));
        if(count($lookstatus)>0)
        {
            $newlookupstatus=$lookstatus[0];
            $newlookupstatus->setStatus(4);
            $newlookupstatus->setDatetime(new \DateTime());
            $em->flush();
        }
        return true;


    }
    /**
     * Mailing Reports
     *
     * @param \GearmanJob $job Alll Mailing  Sending
     *
     * @return boolean
     *
     * @Gearman\Job(
     *     iterations = 1,
     *     name = "common_mailfunction"
     * )
     */
    public function common_mail_function(\GearmanJob $job)
    {
        $emClient = $this->doctrine->getManager();
        $mailer = $this->container->get('mailer');
        $parametervalues = json_decode($job->workload());
        $from_emailid = $parametervalues->{'from_emailid'};
        $to_emailids = $parametervalues->{'to_emailids'};
        $filename = $parametervalues->{'filename'};
        $comment = $parametervalues->{'comment'};
        $subject= $parametervalues->{'subject'};
        $pdffilenamefullpath= $this->container->getParameter('kernel.root_dir').'/../web/uploads/brochures/'.$filename;

        for($ma=0;$ma<count($to_emailids);$ma++)
        {
            $message = \Swift_Message::newInstance()
                ->setFrom($from_emailid)
                ->setTo($to_emailids[$ma])
                ->setSubject($subject)
                ->setBody($comment);
            $message->attach(\Swift_Attachment::fromPath($pdffilenamefullpath)->setFilename($filename));
            $mailer->send($message);

        }
        echo "Mail Has Been Send...";
        return true;
    }

}