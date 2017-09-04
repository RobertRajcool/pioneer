<?php

namespace RankingBundle\Controller;

use RankingBundle\Entity\ElementComparisonRules;
use RankingBundle\Entity\ElementSymbols;
use RankingBundle\Entity\RankingElementDetails;
use RankingBundle\Entity\RankingLookupStatus;
use RankingBundle\Entity\RankingMonthlyData;
use RankingBundle\Entity\ScorecardLookupStatus;
use RankingBundle\Entity\ScorecardMonthlyData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
/**
 * RankingKpiDetailsController.
 * @Route("/dataverification")
 */
class DataVerficationController extends Controller
{
    /**
     * @Route("/indexaction")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * Ranking Monhtly Data Function
     * @Rest\Post("/rankingIndexaction",name="addDataRanking")
     */
    public function rankinDataverificationAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userObject=$this->getUser();
        $dataofMonth=$request->request->get('dataofmonth');
        $companyId=$userObject->getCompanyId();
        $role = $userObject->getRoles();
        if($dataofMonth!=null){
            $dateObject = new \DateTime($dataofMonth);
            $dateObject->modify('last day of this month');
        }
        else{
            $dateObject = new \DateTime();
            $dateObject->modify('last day of this month');
        }
        if($companyId==null){
            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->andWhere('s.createdDate <= :activeDate')
                ->setParameter('activeDate', $dateObject)
                ->setParameter('userObject', $userObject)
                ->getQuery()
                ->getResult();
        }
        else{

            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->andWhere('s.createdDate <= :activeDate')
                ->setParameter('activeDate', $dateObject)
                ->setParameter('companyId', $userObject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        $statusQueryResult = $em->createQueryBuilder()
            ->select('s.id,s.shipName, b.rejections, b.status')
            ->from('RankingBundle:RankingLookupStatus', 'b')
            ->join('VesselBundle:Shipdetails', 's', 'with', 's.id = b.shipDetailsId')
            ->Where('b.dataofmonth =:dataofmonth')
            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
            ->addOrderBy('b.shipDetailsId', 'ASC')
            ->getQuery()
            ->getResult();
        $shipOverallStatus = "";
        $elementValues = array();
        $overallShipStatusarray=array();
        $currentShipId = "";
        $currentShipName = "";
        if (count($vesselList) == count($statusQueryResult)) {
            $shipdetailswithStatus=$this->findRankingOverallStatus($vesselList,$statusQueryResult);
            if ($role[0] == 'ROLE_ADMIN') {
                foreach ($shipdetailswithStatus as $key => $val)
                {
                    if ($val['status'] == 2 && $val['rejections'] ==false)
                    {
                        $currentShipId = $val['id'];
                        $currentShipName=$val['shipName'];
                        $shipOverallStatus = "no";
                        break;
                    }
                }
                if($currentShipName==""){
                    foreach ($shipdetailswithStatus as $key => $val)
                    {
                        if ($val['status'] == 2 && $val['rejections'] ==true)
                        {
                            $currentShipId = $val['id'];
                            $currentShipName=$val['shipName'];
                            $shipOverallStatus = "no";
                            break;
                        }
                    }
                }

                if($currentShipName==""){
                    $shipOverallStatus = "yes";
                }

            }
            if ($role[0] == 'ROLE_MANAGER') {
                foreach ($shipdetailswithStatus as $key => $val)
                {
                    if ($val['status'] == 5 && $val['rejections'] ==false)
                    {
                        $currentShipId = $val['id'];
                        $currentShipName=$val['shipName'];
                        $shipOverallStatus = "no";
                        break;
                    }
                }
                if($currentShipName==""){
                    foreach ($shipdetailswithStatus as $key => $val)
                    {
                        if ($val['status'] == 2 && $val['rejections'] ==true)
                        {
                            $currentShipId = $val['id'];
                            $currentShipName=$val['shipName'];
                            $shipOverallStatus = "no";
                            break;
                        }
                    }
                }
                if($currentShipName==""){
                    foreach ($shipdetailswithStatus as $key => $val)
                    {
                        if ($val['status'] == 1 && $val['rejections'] ==true)
                        {
                            $currentShipId = $val['id'];
                            $currentShipName=$val['shipName'];
                            $shipOverallStatus = "no";
                            break;
                        }
                    }
                }
                if($currentShipName==""){
                    $shipOverallStatus = "yes";
                }

            }
            if ($role[0] == 'ROLE_DATAPROVIDER') {
                if($currentShipName==""){
                    foreach ($shipdetailswithStatus as $key => $val)
                    {
                        if ($val['status'] == 1 && $val['rejections'] ==true)
                        {
                            $currentShipId = $val['id'];
                            $currentShipName=$val['shipName'];
                            $shipOverallStatus = "no";
                            break;
                        }
                    }
                }
                if($currentShipName==""){
                    $shipOverallStatus = "yes";
                }

            }
            for ($shipCount = 0; $shipCount < count($vesselList); $shipCount++) {
                $vesselList[$shipCount]['rejections']=$statusQueryResult[$shipCount]['rejections'];
                $vesselList[$shipCount]['status']=$statusQueryResult[$shipCount]['status'];
            }
        }
        else {
            $shipOverallStatus = "no";
            for ($shipCount = 0; $shipCount < count($vesselList); $shipCount++) {
                $arraySerarchValueStatus=array_key_exists($shipCount, $statusQueryResult);
                if($arraySerarchValueStatus){
                    $vesselList[$shipCount]['rejections']=$statusQueryResult[$shipCount]['rejections'];
                    $vesselList[$shipCount]['status']=$statusQueryResult[$shipCount]['status'];
                }
                else{
                    $vesselList[$shipCount]['rejections']=null;
                    $vesselList[$shipCount]['status']=0;
                }

            }
            $shipStatuswithCurrentshipDetail=$this->findRankingShipStatus($vesselList,$dateObject);
            $currentShipId=$shipStatuswithCurrentshipDetail['currentshipId'];
            $currentShipName=$shipStatuswithCurrentshipDetail['currentShipName'];
            $overallShipStatusarray=$shipStatuswithCurrentshipDetail['shipStatus'];
            if ($role[0] == 'ROLE_MANAGER' || $role[0] == 'ROLE_ADMIN') {
                $currentShipId="";
                $currentShipName="";
            }

        }
        $curretshipObject=$em->getRepository('VesselBundle:ShipDetails')->findOneBy(array('id' =>$currentShipId));
        $kpiRejectionIds=array();
        if($currentShipId==""){
            $listofKpiIds = $em->createQueryBuilder()
                ->select('b.kpiName', 'b.id')
                ->from('RankingBundle:RankingKpiDetails', 'b')
                ->where('b.createdDateTime <= :dateTime')
                ->andwhere('b.kpiName != :vesselageValue')
                ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                ->setParameter('vesselageValue', 'Vessel age')
                ->setParameter('dateTime', $dateObject)
                ->add('orderBy', 'b.id  ASC ')
                ->groupBy('b.kpiName')
                ->getQuery()
                ->getResult();
        }
        else
        {
            $listofKpiIds = $em->createQueryBuilder()
                ->select('b.kpiName', 'b.id')
                ->from('RankingBundle:RankingKpiDetails', 'b')
                ->where('b.createdDateTime <= :dateTime')
                ->andwhere('b.kpiName != :vesselageValue')
                ->andwhere('b.shipDetailsId =:currentshipId')
                ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                ->setParameter('currentshipId',$curretshipObject)
                ->setParameter('vesselageValue', 'Vessel age')
                ->setParameter('dateTime', $dateObject)
                ->add('orderBy', 'b.id  ASC ')
                ->groupBy('b.kpiName')
                ->getQuery()
                ->getResult();
            if(count($statusQueryResult)==count($vesselList)){
                $rejections=$statusQueryResult[$currentShipId-1]['rejections'];
                if($rejections!=null && $rejections!=-1){
                    $kpiRejectionIds=json_decode($rejections);
                }
                else{
                    if($rejections==-1){
                        $kpiRejectionIds[0]=-1;
                    }
                }
            }


        }
        for ($kpiCount = 0; $kpiCount < count($listofKpiIds); $kpiCount++) {
            $kpiId = $listofKpiIds[$kpiCount]['id'];
            $kpiName = $listofKpiIds[$kpiCount]['kpiName'];
            if(count($kpiRejectionIds)==1){
                $rejectionTemp=$kpiRejectionIds[0];
                if($rejectionTemp==-1){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                    if($rejectionStatusField!=""){
                        $listofKpiIds[$kpiCount]['rejections']=true;
                    }
                    else{
                        $listofKpiIds[$kpiCount]['rejections']=false;
                    }
                }
            }
            else{
                $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                if($rejectionStatusField!=""){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $listofKpiIds[$kpiCount]['rejections']=false;
                }
            }
            $elementList = $em->createQueryBuilder()
                ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                ->from('RankingBundle:RankingElementDetails', 'ele')
                ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                ->where('ele.dateTime <= :dateTime')
                ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                ->setParameter('dateTime', $dateObject)
                ->setParameter('kpidetailsid', $kpiId)
                ->add('orderBy', 'ele.id  DESC ')
                ->getQuery()
                ->getResult();
            if (count($elementList) == 0) {
                $findnewkpiList = $em->createQueryBuilder()
                    ->select('b.kpiName', 'b.id')
                    ->from('RankingBundle:RankingKpiDetails', 'b')
                    ->where('b.kpiName = :kpiName')
                    ->andwhere('b.createdDateTime <= :dateTime')
                    ->andwhere('b.kpiStatusValue = 1 or b.kpiStatusValue = 3')
                    ->setParameter('dateTime', $dateObject)
                    ->setParameter('kpiName', $kpiName)
                    ->add('orderBy', 'b.id  ASC ')
                    ->groupby('b.kpiName')
                    ->getQuery()
                    ->getResult();
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
                        ->setParameter('dateTime', $dateObject)
                        ->setParameter('kpidetailsid', $newkpiId)
                        ->add('orderBy', 'ele.id  DESC ')
                        ->getQuery()
                        ->getResult();
                    for($elementCount=0;$elementCount<count($elementList);$elementCount++){
                        $kpielementValueQuery = $em->createQueryBuilder()
                            ->select('b.value')
                            ->from('RankingBundle:RankingMonthlyData', 'b')
                            ->where('b.elementDetailsId = :elementDetailsId')
                            ->andWhere('b.monthdetail =:dataofmonth')
                            ->setParameter('elementDetailsId',$elementList[$elementCount]['id'])
                            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'));
                        if($currentShipId!=""){
                            $kpielementValueQuery
                                ->andWhere('b.shipDetailsId =:shipDetailsId')
                                ->setParameter('shipDetailsId',$curretshipObject);

                        }
                        $kpielementValue=$kpielementValueQuery
                            ->add('orderBy', 'b.shipDetailsId  ASC ')
                            ->getQuery()
                            ->getResult();
                        $elementList[$elementCount]['elementValues']=$kpielementValue;
                    }
                    $listofKpiIds[$kpiCount]['elementList']=$elementList;
                }
                else{
                    $listofKpiIds[$kpiCount]['elementList']=array();
                }
            }
            else {
                for($elementCount=0;$elementCount<count($elementList);$elementCount++){
                    $kpielementValueQuery = $em->createQueryBuilder()
                        ->select('b.value')
                        ->from('RankingBundle:RankingMonthlyData', 'b')
                        ->where('b.elementDetailsId = :elementDetailsId')
                        ->andWhere('b.monthdetail =:dataofmonth')
                        ->setParameter('elementDetailsId',$elementList[$elementCount]['id'])
                        ->setParameter('dataofmonth', $dateObject->format('Y-m-d'));
                    if($currentShipId!=""){
                        $kpielementValueQuery
                            ->andWhere('b.shipDetailsId =:shipDetailsId')
                            ->setParameter('shipDetailsId',$curretshipObject);

                    }
                    $kpielementValue=$kpielementValueQuery
                        ->add('orderBy', 'b.shipDetailsId  ASC ')
                        ->getQuery()
                        ->getResult();
                    $elementList[$elementCount]['elementValues']=$kpielementValue;
                }
                $listofKpiIds[$kpiCount]['elementList']=$elementList;

            }
        }
        if($requestMode!=''){
            return array(
                'vesselList' => $vesselList,
                'totalShipCount' => count($vesselList),
                'currentshipid' => $currentShipId,
                'currentshipname' => $currentShipName,
                'statusQueryResult' => $statusQueryResult,
                'shipoverallStatus' => $shipOverallStatus,
                'shipwiseElementValues' => $elementValues,
                'shipwiseStatuscount'=>$overallShipStatusarray,
                'kpiandelementList'=>$listofKpiIds,
                'currentDatTime'=>$dateObject
            );
        }
        $response = new Response($this->serialize([
            'vesselList' => $vesselList,
            'totalShipCount' => count($vesselList),
            'currentshipid' => $currentShipId,
            'currentshipname' => $currentShipName,
            'statusQueryResult' => $statusQueryResult,
            'shipoverallStatus' => $shipOverallStatus,
            'shipwiseElementValues' => $elementValues,
            'shipwiseStatuscount'=>$overallShipStatusarray,
            'kpiandelementList'=>$listofKpiIds,
            'currentDatTime'=>$dateObject,
            'currentdateandMonthOnly'=>$dateObject->format('Y-m-d')
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    private function findRankingOverallStatus($listofShips,$statusQueryResult)
    {
        $returnshipwithStaus=$listofShips;
        for($shipLimitCount=0;$shipLimitCount<count($listofShips);$shipLimitCount++){
            $returnshipwithStaus[$shipLimitCount]['status']=$statusQueryResult[$shipLimitCount]['status'];
            if($statusQueryResult[$shipLimitCount]['rejections']!=null){
                $returnshipwithStaus[$shipLimitCount]['rejections']=true;
            }
            else{
                $returnshipwithStaus[$shipLimitCount]['rejections']=false;
            }

        }
        return $returnshipwithStaus;

    }
    /**
     * Ranking Monhtly Data Function
     * @Rest\Post("/gotoshipWiseRankingData",name="shipWiseRankingData")
     */
    public function gotoshipWiseDataRankingAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $dataofMonth=$request->request->get('dataofmonth');
        $shipId=$request->request->get('shipId');
        $userObject=$this->getUser();
        $role = $userObject->getRoles();
        if($dataofMonth!=null){
            $dateObject = new \DateTime($dataofMonth);
            $dateObject->modify('last day of this month');
        }
        else{
            $dateObject = new \DateTime();
            $dateObject->modify('last day of this month');
        }
        $elementIdsandkpiIds=$this->rankinDataverificationbyShipWiseAction($request, $shipId,$dateObject,1);
        $curretshipObject=$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipId));
        $response = new Response($this->serialize([
            'shipStatus'=>$elementIdsandkpiIds['shipStatus'],
            'rejections' => $elementIdsandkpiIds['shiprejections'],
            'currentshipid' => $shipId,
            'status'=>true,
            'currentshipname' => $curretshipObject->getShipName(),
            'kpiandelementList'=> $elementIdsandkpiIds['kpiandelementList'],
            'elementValues'=>$elementIdsandkpiIds['elementsValues'],
            'dateObject'=>$dateObject,
            'currentdateandMonthOnly'=>$dateObject->format('M-Y')
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * Ranking Monhtly Data Function
     * @Rest\Post("/gotoshipWiseScorecardData",name="shipWiseScorecardData")
     */
    public function gotoshipWiseDataScorecardAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $dataofMonth=$request->request->get('dataofmonth');
        $shipId=$request->request->get('shipId');
        $userObject=$this->getUser();
        $role = $userObject->getRoles();
        if($dataofMonth!=null){
            $dateObject = new \DateTime($dataofMonth);
            $dateObject->modify('last day of this month');
        }
        else{
            $dateObject = new \DateTime();
            $dateObject->modify('last day of this month');
        }
        $elementIdsandkpiIds=$this->scorecardDataverificationbyShipWiseAction($request, $shipId,$dateObject,2);
        $curretshipObject=$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipId));
        $response = new Response($this->serialize([
            'shipStatus'=>$elementIdsandkpiIds['shipStatus'],
            'rejections' => $elementIdsandkpiIds['shiprejections'],
            'currentshipid' => $shipId,
            'status'=>true,
            'currentshipname' => $curretshipObject->getShipName(),
            'kpiandelementList'=> $elementIdsandkpiIds['kpiandelementList'],
            'elementValues'=>$elementIdsandkpiIds['elementsValues'],
            'dateObject'=>$dateObject,
            'currentdateandMonthOnly'=>$dateObject->format('M-Y')
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    public function scorecardDataverificationbyShipWiseAction(Request $request,$shipDetails,$dateObject,$kpiStatusValue)
    {
        $em = $this->getDoctrine()->getManager();
        $userObject=$this->getUser();
        $role=$userObject->getRoles();
        $curretshipObject=$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipDetails));
        $entityName="";
        $lookupstatusentityName="";
        if($kpiStatusValue==1){
            $entityName='RankingBundle:RankingMonthlyData';
            $lookupstatusentityName="RankingBundle:RankingLookupStatus";
        }
        elseif ($kpiStatusValue==2){
            $entityName='RankingBundle:ScorecardMonthlyData';
            $lookupstatusentityName="RankingBundle:ScorecardLookupStatus";
        }

        $elementValueQuery = $em->createQueryBuilder()
            ->select('b.value')
            ->from($entityName, 'b')
            ->where('b.shipDetailsId = :shipdetailsid')
            ->andWhere('b.monthdetail =:dataofmonth')
            ->setParameter('shipdetailsid',$curretshipObject)
            ->setParameter('dataofmonth',  $dateObject->format('Y-m-d'));
        if ($role[0] == 'ROLE_ADMIN') {
            $elementValueQuery->andWhere('b.status  = 3 OR b.status  = 4');
        }
        elseif ($role[0] == 'ROLE_MANAGER'){
            $elementValueQuery->andWhere('b.status  = 2 OR b.status  = 3');
        }
        elseif ($role[0] == 'ROLE_DATAPROVIDER'){
            $elementValueQuery->andWhere('b.status = 1 OR b.status  = 2 OR b.status  = 3 OR b.status  = 5');
        }
        $elementValues=$elementValueQuery
            ->getQuery()
            ->getResult();
        $listofKpiIds = $em->createQueryBuilder()
            ->select('b.kpiName', 'b.id')
            ->from('RankingBundle:RankingKpiDetails', 'b')
            ->where('b.createdDateTime <= :dateTime')
            ->andwhere('b.kpiName != :vesselageValue')
            ->andwhere('b.shipDetailsId =:currentshipId')
            ->andwhere('b.kpiStatusValue =:kpiStatusValue or b.kpiStatusValue = 3')
            ->setParameter('currentshipId',$curretshipObject)
            ->setParameter('vesselageValue', 'Vessel age')
            ->setParameter('kpiStatusValue',$kpiStatusValue)
            ->setParameter('dateTime', $dateObject)
            ->add('orderBy', 'b.id  ASC ')
            ->groupBy('b.kpiName')
            ->getQuery()
            ->getResult();
        $kpiRejectionIds=array();
        $shipStatus=0;
        $shiprejections=null;
        $statusQueryResult = $em->createQueryBuilder()
            ->select('b.shipids, b.rejections, b.rejectionsStatus, b.status, b.temp_rejections')
            ->from('RankingBundle:ScorecardLookupStatus', 'b')
            ->Where('b.dataofmonth =:dataofmonth')
            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
            ->getQuery()
            ->getResult();
        $currentMonthsRejectionsArray=array();
        if (count($statusQueryResult) == 0) {
        }
        else
        {
            $shipidinString = $statusQueryResult[0]['shipids'];
            $currentMonthrejectionsInString=$statusQueryResult[0]['rejections'];
            $currentMonthTemprejectionsInString=$statusQueryResult[0]['temp_rejections'];
            if($currentMonthrejectionsInString!=null){
                $currentMonthsRejectionsArray=json_decode($currentMonthrejectionsInString,true);
            }
            $currentMonthstatus=$statusQueryResult[0]['status'];
            $shipidinArray = explode(",", $shipidinString);
            $tempcurrentshipId=(String)$shipDetails;
            if (in_array($tempcurrentshipId, $shipidinArray)) {
                $arrayValueExitstStatus=true;
            }
            else{
                $arrayValueExitstStatus=false;
            }
            if($arrayValueExitstStatus)
            {
                $checkRejectionsExists=array_key_exists($shipDetails,$currentMonthsRejectionsArray);
                if($checkRejectionsExists){
                    $shipStatus=$statusQueryResult[0]['status'];
                    $shiprejections=$statusQueryResult[0]['rejections'];
                }
                else{
                    $shiprejections=false;
                    if($currentMonthstatus==2 && $currentMonthrejectionsInString==null){
                        $shipStatus=2;
                    }
                    else if($currentMonthstatus==3){
                        $shipStatus=3;
                    }
                    else if($currentMonthstatus==1 &&$currentMonthrejectionsInString!=null && $checkRejectionsExists==false){
                        $shipStatus=2;
                    }
                    else if($currentMonthstatus==1 &&$currentMonthrejectionsInString!=null && $currentMonthTemprejectionsInString!=null){
                        $shipStatus=2;
                    }
                    else if($currentMonthstatus==1 &&$currentMonthrejectionsInString==null && $currentMonthTemprejectionsInString!=null){
                        $shipStatus=2;
                    }
                    else if($currentMonthstatus==1 &&$currentMonthrejectionsInString==null && $currentMonthTemprejectionsInString==null){
                        $shipStatus=1;
                    }
                    else if($currentMonthstatus==2 &&$currentMonthrejectionsInString!=null){
                        $shipStatus=3;
                    }
                    else if($currentMonthstatus==5 &&$currentMonthrejectionsInString==null){
                        $shipStatus=5;
                    }
                }

            }
            else{
                if($currentMonthstatus==2 &&  $currentMonthrejectionsInString==null){
                    $shipStatus=5;
                    $shiprejections=false;
                }
                else if($currentMonthstatus==3){
                    $shipStatus=2;
                    $shiprejections=false;
                }
                else if($currentMonthstatus==2 && $currentMonthrejectionsInString!=null){
                    $checkRejectionsExists=array_key_exists($shipDetails,$currentMonthsRejectionsArray);
                    if($checkRejectionsExists){
                        $shipStatus=2;
                        $shiprejections=$currentMonthsRejectionsArray[$shipDetails];
                    }
                    else{
                        $shipStatus=2;
                        $shiprejections=false;
                    }
                }
                else if($currentMonthstatus==1 &&$currentMonthrejectionsInString!=null){
                    $checkRejectionsExists=array_key_exists($shipDetails,$currentMonthsRejectionsArray);
                    if($checkRejectionsExists){
                        $shiprejections=$currentMonthsRejectionsArray[$shipDetails];
                        $shipStatus=1;
                    }
                    else{
                        $shiprejections=false;
                        $shipStatus=5;
                    }
                }
                else if($currentMonthstatus==2 &&$currentMonthrejectionsInString!=null){
                    $shipStatus=2;
                    $shiprejections=false;
                }
                else if($currentMonthstatus==1 &&$currentMonthTemprejectionsInString!=null&&$currentMonthrejectionsInString==null){
                    $shipStatus=1;
                    $shiprejections=false;
                }
                else if($currentMonthstatus==1 &&$currentMonthTemprejectionsInString==null&&$currentMonthrejectionsInString==null){
                    $shipStatus=0;
                    $shiprejections=false;
                }
            }
        }
        if(count($currentMonthsRejectionsArray)!=0){
            $checkRejectionsExistsStatus=array_key_exists($shipDetails,$currentMonthsRejectionsArray);
            if($checkRejectionsExistsStatus){
                $kpiRejectionIds=$currentMonthsRejectionsArray[$shipDetails];
            }
        }
        for ($kpiCount = 0; $kpiCount < count($listofKpiIds); $kpiCount++) {
            $kpiId = $listofKpiIds[$kpiCount]['id'];
            $kpiName = $listofKpiIds[$kpiCount]['kpiName'];
            if(count($kpiRejectionIds)==1){
                $rejectionTemp=$kpiRejectionIds[0];
                if($rejectionTemp==-1){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                    if($rejectionStatusField!=""){
                        $listofKpiIds[$kpiCount]['rejections']=true;
                    }
                    else{
                        $listofKpiIds[$kpiCount]['rejections']=false;
                    }
                }
            }
            else{
                $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                if($rejectionStatusField!=""){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $listofKpiIds[$kpiCount]['rejections']=false;
                }
            }
            $elementList = $em->createQueryBuilder()
                ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                ->from('RankingBundle:RankingElementDetails', 'ele')
                ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                ->where('ele.dateTime <= :dateTime')
                ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                ->setParameter('dateTime', $dateObject)
                ->setParameter('kpidetailsid', $kpiId)
                ->add('orderBy', 'ele.id  DESC ')
                ->getQuery()
                ->getResult();
            if (count($elementList) == 0) {
                $findnewkpiList = $em->createQueryBuilder()
                    ->select('b.kpiName', 'b.id')
                    ->from('RankingBundle:RankingKpiDetails', 'b')
                    ->where('b.kpiName = :kpiName')
                    ->andwhere('b.createdDateTime <= :dateTime')
                    ->andwhere('b.kpiStatusValue =:kpiStatusValue or b.kpiStatusValue = 3')
                    ->setParameter('dateTime', $dateObject)
                    ->setParameter('kpiName', $kpiName)
                    ->setParameter('kpiStatusValue',$kpiStatusValue)
                    ->add('orderBy', 'b.id  ASC ')
                    ->groupby('b.kpiName')
                    ->getQuery()
                    ->getResult();
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
                        ->setParameter('dateTime', $dateObject)
                        ->setParameter('kpidetailsid', $newkpiId)
                        ->add('orderBy', 'ele.id  DESC ')
                        ->getQuery()
                        ->getResult();
                    $listofKpiIds[$kpiCount]['elementList']=$elementList;
                }
                else{
                    $listofKpiIds[$kpiCount]['elementList']=array();
                }
            }
            else {
                $listofKpiIds[$kpiCount]['elementList']=$elementList;
            }
        }
        return array(
            'kpiandelementList'=>$listofKpiIds,
            'elementsValues'=>$elementValues,
            'shiprejections'=>$shiprejections,
            'shipStatus'=>$shipStatus
        );
    }

    public function rankinDataverificationbyShipWiseAction(Request $request,$shipDetails,$dateObject,$kpiStatusValue)
    {
        $em = $this->getDoctrine()->getManager();
        $userObject=$this->getUser();
        $role=$userObject->getRoles();
        $curretshipObject=$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipDetails));
        $entityName="";
        if($kpiStatusValue==1){
            $entityName='RankingBundle:RankingMonthlyData';
        }
        elseif ($kpiStatusValue==2){
            $entityName='RankingBundle:ScorecardMonthlyData';
        }
        $elementValueQuery = $em->createQueryBuilder()
            ->select('b.value')
            ->from($entityName, 'b')
            ->where('b.shipDetailsId = :shipdetailsid')
            ->andWhere('b.monthdetail =:dataofmonth')
            ->setParameter('shipdetailsid',$curretshipObject)
            ->setParameter('dataofmonth',  $dateObject->format('Y-m-d'));
        $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findOneBy(array('shipDetailsId' =>$curretshipObject, 'dataofmonth' => $dateObject));
        $lookstatusFieldValue=$lookstatus->getStatus();
        if ($role[0] == 'ROLE_ADMIN') {
            $elementValueQuery->andWhere('b.status  = 3 OR b.status  = 4 OR b.status  = 2');
        }
        elseif ($role[0] == 'ROLE_MANAGER'){
            if($lookstatusFieldValue==5){
                $elementValueQuery->andWhere('b.status  = 2 OR b.status  = 3 OR b.status  = 5 OR b.status  = 1');

            }else{
                $elementValueQuery->andWhere('b.status  = 2 OR b.status  = 3 OR b.status  = 5');

            }
        }
        elseif ($role[0] == 'ROLE_DATAPROVIDER'){
            $elementValueQuery->andWhere('b.status = 1 OR b.status  = 2 OR b.status  = 3 OR b.status  = 5');
        }
        $elementValues=$elementValueQuery
            ->getQuery()
            ->getResult();
        $listofKpiIds = $em->createQueryBuilder()
            ->select('b.kpiName', 'b.id')
            ->from('RankingBundle:RankingKpiDetails', 'b')
            ->where('b.createdDateTime <= :dateTime')
            ->andwhere('b.kpiName != :vesselageValue')
            ->andwhere('b.shipDetailsId =:currentshipId')
            ->andwhere('b.kpiStatusValue =:kpiStatusValue or b.kpiStatusValue = 3')
            ->setParameter('currentshipId',$curretshipObject)
            ->setParameter('vesselageValue', 'Vessel age')
            ->setParameter('kpiStatusValue',$kpiStatusValue)
            ->setParameter('dateTime', $dateObject)
            ->add('orderBy', 'b.id  ASC ')
            ->groupBy('b.kpiName')
            ->getQuery()
            ->getResult();
        $statusQueryResult = $em->createQueryBuilder()
            ->select('identity(b.shipDetailsId) as shipId, b.rejections, b.status')
            ->from('RankingBundle:RankingLookupStatus', 'b')
            ->Where('b.dataofmonth =:dataofmonth')
            ->andwhere('b.shipDetailsId =:shipDetailsId')
            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
            ->setParameter('shipDetailsId',$shipDetails)
            ->getQuery()
            ->getResult();
        $kpiRejectionIds=array();
        $shipStatus=0;
        $shiprejections=null;
        if(count($statusQueryResult)!=0){
            $rejections=$statusQueryResult[0]['rejections'];
            $shipStatus =$statusQueryResult[0]['status'];
            $shiprejections=true;
            if($rejections==null){
                $shiprejections=false;
            }
            else if($rejections!=null && $rejections!=-1){
                $kpiRejectionIds=json_decode($rejections);
            }
            else{
                if($rejections==-1){
                    $kpiRejectionIds[0]=-1;
                }
            }
        }
        else{
            $shiprejections=false;
        }
        for ($kpiCount = 0; $kpiCount < count($listofKpiIds); $kpiCount++) {
            $kpiId = $listofKpiIds[$kpiCount]['id'];
            $kpiName = $listofKpiIds[$kpiCount]['kpiName'];
            if(count($kpiRejectionIds)==1){
                $rejectionTemp=$kpiRejectionIds[0];
                if($rejectionTemp==-1){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                    if($rejectionStatusField!=""){
                        $listofKpiIds[$kpiCount]['rejections']=true;
                    }
                    else{
                        $listofKpiIds[$kpiCount]['rejections']=false;
                        $shiprejections=false;
                    }
                }
            }
            else{
                $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                if($rejectionStatusField!=""){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $listofKpiIds[$kpiCount]['rejections']=false;
                }
            }
            $elementList = $em->createQueryBuilder()
                ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                ->from('RankingBundle:RankingElementDetails', 'ele')
                ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                ->where('ele.dateTime <= :dateTime')
                ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                ->setParameter('dateTime', $dateObject)
                ->setParameter('kpidetailsid', $kpiId)
                ->add('orderBy', 'ele.id  DESC ')
                ->getQuery()
                ->getResult();
            if (count($elementList) == 0) {
                $findnewkpiList = $em->createQueryBuilder()
                    ->select('b.kpiName', 'b.id')
                    ->from('RankingBundle:RankingKpiDetails', 'b')
                    ->where('b.kpiName = :kpiName')
                    ->andwhere('b.createdDateTime <= :dateTime')
                    ->andwhere('b.kpiStatusValue =:kpiStatusValue or b.kpiStatusValue = 3')
                    ->setParameter('dateTime', $dateObject)
                    ->setParameter('kpiName', $kpiName)
                    ->setParameter('kpiStatusValue',$kpiStatusValue)
                    ->add('orderBy', 'b.id  ASC ')
                    ->groupby('b.kpiName')
                    ->getQuery()
                    ->getResult();
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
                        ->setParameter('dateTime', $dateObject)
                        ->setParameter('kpidetailsid', $newkpiId)
                        ->add('orderBy', 'ele.id  DESC ')
                        ->getQuery()
                        ->getResult();
                    $listofKpiIds[$kpiCount]['elementList']=$elementList;
                }
                else{
                    $listofKpiIds[$kpiCount]['elementList']=array();
                }
            }
            else {
                $listofKpiIds[$kpiCount]['elementList']=$elementList;
            }
        }
        return array(
            'kpiandelementList'=>$listofKpiIds,
            'elementsValues'=>$elementValues,
            'shiprejections'=>$shiprejections,
            'shipStatus'=>$shipStatus
        );
    }
    private function findRankingShipStatus($listofShips,$dateObject){
        $em = $this->getDoctrine()->getManager();
        $shipStatusArray=array();
        $currentShipId=0;
        $currentShipName="";
        $tempCountValue=0;
        for($outerLoopStatusCount=0;$outerLoopStatusCount<count($listofShips);$outerLoopStatusCount++){
            $statusandRejectionarray=array();
            $currentMonthStatusQueryResult = $em->createQueryBuilder()
                ->select('identity(b.shipDetailsId) as shipId, b.rejections, b.status')
                ->from('RankingBundle:RankingLookupStatus', 'b')
                ->Where('b.dataofmonth =:dataofmonth')
                ->andwhere('b.shipDetailsId =:loopshipObject')
                ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
                ->setParameter('loopshipObject',$listofShips[$outerLoopStatusCount]['id'])
                ->getQuery()
                ->getResult();
            if(count($currentMonthStatusQueryResult)!=0){
                $statuValue=$currentMonthStatusQueryResult[0]['status'];
                $rejectionvalue=$currentMonthStatusQueryResult[0]['rejections'];
                $statusandRejectionarray['status']=$statuValue;
                $statusandRejectionarray['rejections']=$rejectionvalue;
                if($rejectionvalue!=null){
                    for($innerLoopCount=$outerLoopStatusCount+1;$innerLoopCount<count($listofShips);$innerLoopCount++){
                        $innterLoopStatusQueryResult = $em->createQueryBuilder()
                            ->select('identity(b.shipDetailsId) as shipId, b.rejections, b.status')
                            ->from('RankingBundle:RankingLookupStatus', 'b')
                            ->Where('b.dataofmonth =:dataofmonth')
                            ->andwhere('b.shipDetailsId =:loopshipObject')
                            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
                            ->setParameter('loopshipObject',$listofShips[$innerLoopCount]['id'])
                            ->getQuery()
                            ->getResult();
                        if($innterLoopStatusQueryResult==0){
                            $statusCheckFiled=false;
                            if($tempCountValue==0){
                                $currentShipId=$listofShips[$innerLoopCount]['id'];
                                $currentShipName=$listofShips[$innerLoopCount]['shipName'];
                                $tempCountValue++;
                            }
                            break;
                        }
                        else{
                            continue;
                        }
                    }
                }

            }
            else{
                if($tempCountValue==0){
                    $currentShipId=$listofShips[$outerLoopStatusCount]['id'];
                    $currentShipName=$listofShips[$outerLoopStatusCount]['shipName'];
                    $tempCountValue++;
                }
            }
            $shipStatusArray[$listofShips[$outerLoopStatusCount]['id']]=$statusandRejectionarray;
        }
        return array('currentshipId'=>$currentShipId,'currentShipName'=>$currentShipName,'shipStatus'=>$shipStatusArray);
    }
    /**
     * Adding Kpi Values Ranking.
     *
     *@Rest\Post("/saveRankingData",name="saveRankingData")
     */
    public function saveRankingDataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($user == null) {
            return $this->redirectToRoute('fos_user_security_login');
        } else {
            $userid = $user->getId();
            $role = $user->getRoles();
            $shipid = $request->request->get('shipId');
            $dataofmonth = $request->request->get('dataofmonth');
            $dateObject=new \DateTime($dataofmonth);
            $dateObject->modify('last day of this month');
            $tempdate = date_format($dateObject, "d-M-Y");
            $datasaveOption=$request->request->get('datasaveOption');
            $elementDetails=$request->request->get('elementDetails');
            $kpiDetailsGroup=$request->request->get('kpiDetailsGroup');
            $returnmsg = '';
            $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipid));
            $elementDetailskeyValue=array_keys($elementDetails);
            $kpiDetailskeyValue=array_keys($kpiDetailsGroup);
            /*if ($datasaveOption == 'updatebuttonid' || $buttonid == 'adminbuttonid' || $buttonid == 'verfiybuttonid')*/
            if ($datasaveOption == 1 || $datasaveOption ==2 || $datasaveOption == 3) {
                for ($elementCount = 0; $elementCount < count($elementDetailskeyValue); $elementCount++) {
                    $arraykeyValue=$elementDetailskeyValue[$elementCount];
                    $currentelementValue=$elementDetails[$arraykeyValue];
                    $elementarrayfromString=explode("_",$arraykeyValue);
                    $elemenId=$elementarrayfromString[1];
                    $entityobject = $em->getRepository('RankingBundle:RankingMonthlyData')->findOneBy(array('elementDetailsId' =>  (int)$elemenId,'shipDetailsId'=>$shipObject,'monthdetail'=>$dateObject));
                    if ($datasaveOption == 3) {
                        $entityobject->setValue($currentelementValue);
                        $entityobject->setStatus(3);
                    }
                    if ($datasaveOption == 2) {
                        $entityobject->setValue($currentelementValue);
                        $entityobject->setStatus(2);
                    }
                    if ($datasaveOption == 1) {
                        $entityobject->setValue($currentelementValue);
                        $entityobject->setStatus(1);
                    }
                    $em->flush();

                }
                $returnmsg = $shipObject->getShipName().' Data Updated...';

                if ($datasaveOption == 3) {
                    $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findBy(array('shipDetailsId' => $shipObject, 'dataofmonth' => $dateObject));
                    $newlookupstatus = $lookstatus[0];
                    $rankinglookuptable = array('shipid' => $shipid, 'dataofmonth' => $tempdate, 'userid' => $userid, 'status' => 3,'kpistatusValue'=>1, 'datetime' => date('Y-m-d H:i:s'));
                    $newlookupstatus->setStatus(3);
                    $newlookupstatus->setDatetime(new \DateTime());
                    $em->flush();
                    $gearman = $this->get('gearman');
                    $gearman->doBackgroundJob('RankingBundleServicesExecuteNodeFindColor~ranking_execute_node_findcolor', json_encode($rankinglookuptable));
                }

                if ($datasaveOption == 2) {
                    $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findBy(array('shipDetailsId' => $shipObject, 'dataofmonth' => $dateObject));
                    $newlookupstatus = $lookstatus[0];
                    $newlookupstatus->setStatus(2);
                    $newlookupstatus->setRejections(null);
                    $newlookupstatus->setDatetime(new \DateTime());
                    $em->flush();

                }
                if ($datasaveOption == 1) {
                    $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findBy(array('shipDetailsId' => $shipObject, 'dataofmonth' => $dateObject));
                    $newlookupstatus = $lookstatus[0];
                    $newlookupstatus->setStatus(1);
                    $newlookupstatus->setRejections(null);
                    $newlookupstatus->setDatetime(new \DateTime());
                    $em->flush();
                }

            }
            if ($datasaveOption == 0) {
                /*    foreach ($kpiandelementids as $element) {
                        for ($elementCount = 0; $elementCount < count($element); $elementCount++) {
                            $baseValueQuery = $em->createQueryBuilder()
                                ->select('a.baseValue')
                                ->from('InitialShippingBundle:RankingElementDetails', 'a')
                                ->where('a.id=:elementId')
                                ->setParameter('elementId', $element[$elementCount])
                                ->getQuery()
                                ->getResult();
                            $baseValue = $baseValueQuery[0]['baseValue'];
                            if ($baseValue != 0) {
                                $currentMonth = date('m');
                                $monthlyCount = $baseValue / 12;
                                $currentMonthValue = (int)$currentMonth * $monthlyCount;
                                $elementRulesQuery = $em->createQueryBuilder()
                                    ->select('a.rules,a.id')
                                    ->from('InitialShippingBundle:RankingRules', 'a')
                                    ->where('a.elementDetailsId=:elementId')
                                    ->setParameter('elementId', $element[$elementCount])
                                    ->getQuery()
                                    ->getResult();
                                foreach ($elementRulesQuery as $rules) {
                                    $ruleObj = json_decode($rules['rules']);
                                    $ruleObj->conditions->all[0]->value = $currentMonthValue;
                                    $ruleString = json_encode($ruleObj);
                                    $rulesDetailObject = $em->getRepository('InitialShippingBundle:RankingRules')->find($rules['id']);
                                    $rulesDetailObject->setRules($ruleString);
                                    $em->flush();
                                }
                            }
                        }
                    }*/
                for ($elementCount = 0; $elementCount < count($elementDetailskeyValue); $elementCount++) {
                    $arraykeyValue=$elementDetailskeyValue[$elementCount];
                    $currentelementValue=$elementDetails[$arraykeyValue];
                    $elementarrayfromString=explode("_",$arraykeyValue);
                    $elemenId=$elementarrayfromString[1];
                    $elementidObject = $em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' => $elemenId));
                    $kpiObject=$elementidObject->getKpiDetailsId();
                    //Change Element Rule Based on Base Value
                    $baseValue=$elementidObject->getBaseValue();
                    if ($baseValue != 0) {
                        $currentMonth = (int) date_format($dateObject, "m");
                        $monthlyCount = $baseValue / 12;
                        $currentMonthValue = (int)$currentMonth * $monthlyCount;
                        $elementRulesQuery = $em->createQueryBuilder()
                            ->select('a.rules,a.id')
                            ->from('RankingBundle:RankingRulesDetails', 'a')
                            ->where('a.elementDetailsId=:elementId')
                            ->setParameter('elementId', $elementidObject)
                            ->getQuery()
                            ->getResult();
                        foreach ($elementRulesQuery as $rules) {
                            $ruleObj = json_decode($rules['rules']);
                            $ruleObj->conditions->all[0]->value = $currentMonthValue;
                            $ruleString = json_encode($ruleObj);
                            $rulesDetailObject = $em->getRepository('RankingBundle:RankingRulesDetails')->find($rules['id']);
                            $rulesDetailObject->setRules($ruleString);
                            $em->flush();
                        }
                    }
                    //Change Element Rule Based on Base Value
                    $readingkpivalue = new RankingMonthlyData();
                    $readingkpivalue->setKpiDetailsId($kpiObject);
                    $readingkpivalue->setElementDetailsId($elementidObject);
                    $readingkpivalue->setShipDetailsId($shipObject);
                    $readingkpivalue->setMonthdetail($dateObject);
                    $readingkpivalue->setValue($currentelementValue);
                    $readingkpivalue->setStatus(1);
                    $em->persist($readingkpivalue);
                    $em->flush();
                }
                $lookupstatusobject = new RankingLookupStatus();
                $lookupstatusobject->setShipDetailsId($shipObject);
                $lookupstatusobject->setStatus(1);
                $lookupstatusobject->setDataofmonth($dateObject);
                $lookupstatusobject->setDatetime(new \DateTime());
                $lookupstatusobject->setUserid($userid);
                $em->persist($lookupstatusobject);
                $em->flush();
                $returnmsg = $shipObject->getShipName().' Data Saved...';

            }
            if ($datasaveOption == 5) {
                if($user->getCompanyId() ==null ){
                    $vesselList = $em->createQueryBuilder()
                        ->select('s.id', 's.shipName')
                        ->from('VesselBundle:Shipdetails', 's')
                        ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                        ->where('cu.userId = :userObject ')
                        ->andWhere('s.createdDate <= :activeDate')
                        ->setParameter('activeDate', $dateObject)
                        ->setParameter('userObject', $user)
                        ->getQuery()
                        ->getResult();
                }
                else{

                    $vesselList = $em->createQueryBuilder()
                        ->select('s.id', 's.shipName')
                        ->from('VesselBundle:Shipdetails', 's')
                        ->where('s.companyName = :companyId ')
                        ->andWhere('s.createdDate <= :activeDate')
                        ->setParameter('activeDate', $dateObject)
                        ->setParameter('companyId', $user->getCompanyId())
                        ->getQuery()
                        ->getResult();
                }
                foreach ($vesselList as $vessel) {
                    $check_empty_value_query = $em->createQueryBuilder()
                        ->select('a.value')
                        ->from('RankingBundle:RankingMonthlyData', 'a')
                        ->where('a.shipDetailsId = :shipdetailsid')
                        ->andWhere('a.monthdetail =:dataofmonth')
                        ->setParameter('shipdetailsid', $vessel['id'])
                        ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
                        ->getQuery()
                        ->getResult();
                    foreach ($check_empty_value_query as $check_empty_values) {
                        if ($check_empty_values['value'] != null && $check_empty_values['value'] !=" ") {
                            continue;
                        }
                        else
                        {
                            $return_msg = $vessel['shipName'] . ' data is not completed !';
                            $elementIdsandkpiIds=$this->rankinDataverificationbyShipWiseAction($request, $vessel['id'],$dateObject,1);
                            $response = new Response($this->serialize([
                                'return_msg' => $return_msg,
                                'status' => -1,
                                'currentshipid' => $vessel['id'],
                                'currentshipname' => $vessel['shipName'],
                                'kpiandelementList'=> $elementIdsandkpiIds['kpiandelementList'],
                                'elementValues'=>$elementIdsandkpiIds['elementsValues'],
                                'dateObject'=>$dateObject,
                                'currentdateandMonthOnly'=>$dateObject->format('M-Y')
                            ]), Response::HTTP_CREATED);
                            return $this->setBaseHeaders($response);
                        }
                    }
                }

                foreach ($vesselList as $vessel) {
                    //$lookstatus = $em->getRepository('InitialShippingBundle:Ranking_LookupStatus')->findBy(array('shipid' => $vessel['id'], 'dataofmonth' => $dateObject));
                    $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findBy(array('shipDetailsId' =>$vessel['id'], 'dataofmonth' => $dateObject));
                    if (count($lookstatus) != 0) {
                        $newlookupstatus = $lookstatus[0];
                        if($newlookupstatus->getStatus()==1){
                            $newlookupstatus->setStatus(5);
                            $newlookupstatus->setDatetime(new \DateTime());
                            $em->flush();
                        }
                    }
                }
                $returnmsg =$shipObject->getShipName().' Data Uploaded...';

            }
            if ($datasaveOption == -1) {
                $rejectionkpiId=array();
                for ($kpiCount = 0; $kpiCount < count($kpiDetailskeyValue); $kpiCount++) {
                    $kpiarraykeyValue=$kpiDetailskeyValue[$kpiCount];
                    $currentkpiValue=$kpiDetailsGroup[$kpiarraykeyValue];
                    $kpiarrayfromString=explode("_",$kpiarraykeyValue);
                    $kpiId=$kpiarrayfromString[1];
                    if($currentkpiValue){
                        array_push($rejectionkpiId,$kpiId);
                    }
                }
                $lookstatus = $em->getRepository('RankingBundle:RankingLookupStatus')->findBy(array('dataofmonth' => $dateObject, 'shipDetailsId' => $shipid));
                if (count($lookstatus) != 0) {
                    $newlookupstatus = $lookstatus[0];
                    $newlookupstatus->setStatus(1);
                    if(count($rejectionkpiId)!=0){
                        $newlookupstatus->setRejections(json_encode($rejectionkpiId));
                    }
                    else{
                        $newlookupstatus->setRejections(-1);
                    }
                    $newlookupstatus->setDatetime(new \DateTime());
                    $em->flush();
                }
                $returnmsg = $shipObject->getShipName().' rejected...';

            }
            $findStattus=$this->rankinDataverificationAction($request,$reuseMode="rebuildcode");
            $response = new Response($this->serialize([
                'vesselList' => $findStattus['vesselList'],
                'totalShipCount' => count( $findStattus['vesselList']),
                'currentshipid' =>  $findStattus['currentshipid'],
                'currentshipname' =>  $findStattus['currentshipname'],
                'statusQueryResult' =>  $findStattus['statusQueryResult'],
                'shipoverallStatus' =>  $findStattus['shipoverallStatus'],
                'shipwiseElementValues' =>  $findStattus['shipwiseElementValues'],
                'shipwiseStatuscount'=> $findStattus['shipwiseStatuscount'],
                'kpiandelementList'=> $findStattus['kpiandelementList'],
                'currentDatTime'=>$dateObject,
                'currentdateandMonthOnly'=>$dateObject->format('M-Y'),
                'return_msg' => $returnmsg,
                'status' => 1,
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
    }
    /**
     * Ajax Call For change of Prev monthdata of Scorecard
     *
     * @Route("/gotoscorecardmonthdata", name="adddataScorecard")
     */
    public function gotoScorecardMonthDataAction(Request $request, $requestMode='')
    {
        $em = $this->getDoctrine()->getManager();
        $userObject = $this->getUser();
        $dataofmonth = $request->request->get('dataofmonth');
        $companyId=$userObject->getCompanyId();
        $role = $userObject->getRoles();
        if($dataofmonth!=null){
            $dateObject = new \DateTime($dataofmonth);
            $dateObject->modify('last day of this month');
        }
        else{
            $dateObject = new \DateTime();
            $dateObject->modify('last day of this month');
        }
        if($companyId==null){
            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->andWhere('s.createdDate <= :activeDate')
                ->setParameter('activeDate', $dateObject)
                ->setParameter('userObject', $userObject)
                ->getQuery()
                ->getResult();
        }
        else{

            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->andWhere('s.createdDate <= :activeDate')
                ->setParameter('activeDate', $dateObject)
                ->setParameter('companyId', $userObject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        $currentShipId="";
        $currentShipName="";
        $shipStatucount=0;
        /* $statusQueryResult = $em->createQueryBuilder()
             ->select('b.shipids, b.rejections, b.rejectionsStatus, b.status, b.temp_rejections')
             ->from('RankingBundle:ScorecardLookupStatus', 'b')
             ->Where('b.dataofmonth =:dataofmonth')
             ->setParameter('dataofmonth', $dateObject)
             ->getQuery()
             ->getResult();*/
        $statusQueryResult = $em->createQueryBuilder()
            ->select('b.shipids, b.rejections, b.rejectionsStatus, b.status, b.temp_rejections')
            ->from('RankingBundle:ScorecardLookupStatus', 'b')
            ->Where('b.dataofmonth =:dataofmonth')
            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
            ->getQuery()
            ->getResult();
        $shipOverallStatus = "no";
        $elementValues=array();
        $currentMonthsRejectionsArray=array();
        if (count($statusQueryResult) == 0) {
            $shipOverallStatus = "no";
            for($shipCount=0;$shipCount<count($vesselList);$shipCount++){
                $vesselList[$shipCount]['rejections']=null;
                $vesselList[$shipCount]['status']=0;
            }
            if ($role[0] == 'ROLE_DATAPROVIDER') {
                if(count($vesselList)!=0){
                    $currentShipId=$vesselList[0]['id'];
                    $currentShipName=$vesselList[0]['shipName'];
                }
            }

        }
        else {
            $shipidinString = $statusQueryResult[0]['shipids'];
            $shipidinArray = explode(",", $shipidinString);
            if (count($vesselList) == count($shipidinArray)) {
                $temp_status = $statusQueryResult[0]['status'];
                if ($role[0] == 'ROLE_ADMIN') {
                    if($temp_status == 3 || $temp_status == 4) {
                        if($statusQueryResult[0]['rejections'] == null || $statusQueryResult[0]['rejections'] == 'null') {
                            $shipOverallStatus = "yes";
                        } else {
                            $shipOverallStatus = "no";
                        }
                    } else {
                        $shipOverallStatus = "no";
                        if(count($vesselList)!=0){
                            $currentShipId=$vesselList[0]['id'];
                            $currentShipName=$vesselList[0]['shipName'];
                        }
                    }
                    /*

                    if($temp_status == 2 || $temp_status == 3 || $temp_status == 4) {
                        for ($shipCount = 0; $shipCount < count($vesselList); $shipCount++) {
                            $resultarray = $em->createQueryBuilder()
                                ->select('b.value')
                                ->from('InitialShippingBundle:ReadingKpiValues', 'b')
                                ->where('b.shipDetailsId = :shipdetailsid')
                                ->andWhere('b.monthdetail =:dataofmonth')
                                ->setParameter('shipdetailsid', $vesselList[$shipCount]['id'])
                                ->setParameter('dataofmonth', $dateObject)
                                ->getQuery()
                                ->getResult();

                            $tempshipValueArray = array();

                            for ($valueCount = 0; $valueCount < count($resultarray); $valueCount++) {
                                array_push($tempshipValueArray, $resultarray[$valueCount]['value']);
                            }
                            array_push($elementValues, $tempshipValueArray);
                        }
                    }*/

                } else if ($role[0] == 'ROLE_MANAGER') {
                    if($temp_status == 2 || $temp_status == 3 || $temp_status == 4) {
                        if($statusQueryResult[0]['rejections'] == null || $statusQueryResult[0]['rejections'] == 'null') {
                            $shipOverallStatus = "yes";
                        } else {
                            $shipOverallStatus = "no";
                        }
                    }
                    else
                    {
                        $shipOverallStatus = "no";
                        if(count($vesselList)!=0 && $statusQueryResult[0]['status']==5){
                            $currentShipId=$vesselList[0]['id'];
                            $currentShipName=$vesselList[0]['shipName'];
                        }
                    }

                    /* if($temp_status == 2 || $temp_status == 3 || $temp_status == 4 || $temp_status == 5) {
                         for ($shipCount = 0; $shipCount < count($listallshipforcompany); $shipCount++) {
                             $resultarray = $em->createQueryBuilder()
                                 ->select('b.value')
                                 ->from('InitialShippingBundle:ReadingKpiValues', 'b')
                                 ->where('b.shipDetailsId = :shipdetailsid')
                                 ->andWhere('b.monthdetail =:dataofmonth')
                                 ->setParameter('shipdetailsid', $listallshipforcompany[$shipCount]['id'])
                                 ->setParameter('dataofmonth', $dateObject)
                                 ->getQuery()
                                 ->getResult();

                             $tempshipValueArray = array();

                             for ($valueCount = 0; $valueCount < count($resultarray); $valueCount++) {
                                 array_push($tempshipValueArray, $resultarray[$valueCount]['value']);
                             }
                             array_push($elementValues, $tempshipValueArray);
                         }
                     }*/

                } else if ($role[0] == 'ROLE_DATAPROVIDER') {
                    if($temp_status == 2 || $temp_status == 3 || $temp_status == 4 || $temp_status == 5) {
                        if($statusQueryResult[0]['temp_rejections'] == null || $statusQueryResult[0]['temp_rejections'] == 'null') {
                            $shipOverallStatus = "yes";
                        } else {
                            $shipOverallStatus = "no";
                        }
                    } else {
                        $shipOverallStatus = "no";
                    }

                    /* if($temp_status == 1 || $temp_status == 2 || $temp_status == 3 || $temp_status == 4 || $temp_status == 5) {
                         for ($shipCount = 0; $shipCount < count($listallshipforcompany); $shipCount++) {
                             $resultarray = $em->createQueryBuilder()
                                 ->select('b.value')
                                 ->from('InitialShippingBundle:ReadingKpiValues', 'b')
                                 ->where('b.shipDetailsId = :shipdetailsid')
                                 ->andWhere('b.monthdetail =:dataofmonth')
                                 ->setParameter('shipdetailsid', $listallshipforcompany[$shipCount]['id'])
                                 ->setParameter('dataofmonth', $dateObject)
                                 ->getQuery()
                                 ->getResult();

                             $tempshipValueArray = array();

                             for ($valueCount = 0; $valueCount < count($resultarray); $valueCount++) {
                                 array_push($tempshipValueArray, $resultarray[$valueCount]['value']);
                             }
                             array_push($elementValues, $tempshipValueArray);
                         }
                     }*/
                }
                for($shipCount=0;$shipCount<count($vesselList);$shipCount++){
                    $tempcurrentshipId=(String)$vesselList[$shipCount]['id'];
                    if (in_array($tempcurrentshipId, $shipidinArray)) {
                        $arrayValueExitstStatus=true;
                    }
                    else{
                        $arrayValueExitstStatus=false;
                    }
                    if($arrayValueExitstStatus){
                        $vesselList[$shipCount]['rejections']=null;
                        $vesselList[$shipCount]['status']=$statusQueryResult[0]['status'];
                    }
                    else{
                        $vesselList[$shipCount]['rejections']=null;
                        $vesselList[$shipCount]['status']=0;
                    }
                }

            }
            else
            {
                $shipOverallStatus = "no";
                $shipidinString = $statusQueryResult[0]['shipids'];
                $currentMonthrejectionsInString=$statusQueryResult[0]['rejections'];
                $currentMonthTemprejectionsInString=$statusQueryResult[0]['temp_rejections'];
                if($currentMonthrejectionsInString!=null){
                    $currentMonthsRejectionsArray=json_decode($currentMonthrejectionsInString,true);
                }
                $currentMonthstatus=$statusQueryResult[0]['status'];
                $shipidinArray = explode(",", $shipidinString);
                for($shipCount=0;$shipCount<count($vesselList);$shipCount++){
                    $tempcurrentshipId=(String)$vesselList[$shipCount]['id'];
                    if (in_array($tempcurrentshipId, $shipidinArray)) {
                        $arrayValueExitstStatus=true;
                    }
                    else{
                        if ($role[0] == 'ROLE_ADMIN') {
                            if($shipStatucount==0 && $currentMonthstatus ==3 && $currentMonthTemprejectionsInString==null){
                                $currentShipId=$vesselList[$shipCount]['id'];
                                $currentShipName=$vesselList[$shipCount]['shipName'];
                                $shipStatucount++;
                            }
                            else if($shipStatucount==0 && $currentMonthstatus==2 &&$currentMonthTemprejectionsInString!=null){
                                $currentShipId=$vesselList[$shipCount]['id'];
                                $currentShipName=$vesselList[$shipCount]['shipName'];
                                $shipStatucount++;
                            }
                        }
                        else if ($role[0] == 'ROLE_MANAGER') {
                            if($currentMonthstatus==3||$currentMonthstatus==4){
                                $shipOverallStatus = "yes";
                            }
                            else if($shipStatucount==0 && $currentMonthstatus==2&&$currentMonthTemprejectionsInString!=null){
                                $currentShipId=$vesselList[$shipCount]['id'];
                                $currentShipName=$vesselList[$shipCount]['shipName'];
                                $shipStatucount++;
                            }
                            else if($shipStatucount==0 && $currentMonthstatus==1 &&$currentMonthTemprejectionsInString!=null){
                                $currentShipId=$vesselList[$shipCount]['id'];
                                $currentShipName=$vesselList[$shipCount]['shipName'];
                                $shipStatucount++;
                            }
                        }
                        else if ($role[0] == 'ROLE_DATAPROVIDER') {
                            if($currentMonthstatus==2 ||$currentMonthstatus==3||$currentMonthstatus==4){
                                $shipOverallStatus = "yes";
                            }
                            else if($shipStatucount==0  && $currentMonthrejectionsInString!=null){
                                $currentShipId=$vesselList[$shipCount]['id'];
                                $currentShipName=$vesselList[$shipCount]['shipName'];
                                $shipStatucount++;
                            }
                            else if($shipStatucount==0 && $currentMonthTemprejectionsInString==null && $currentMonthstatus==1){
                                $currentShipId=$vesselList[$shipCount]['id'];
                                $currentShipName=$vesselList[$shipCount]['shipName'];
                                $shipStatucount++;
                            }
                        }
                        $arrayValueExitstStatus=false;
                    }
                    if($arrayValueExitstStatus)
                    {
                        $checkRejectionsExists=array_key_exists($vesselList[$shipCount]['id'],$currentMonthsRejectionsArray);
                        if($checkRejectionsExists){
                            $vesselList[$shipCount]['rejections']=$statusQueryResult[0]['rejections'];
                            $vesselList[$shipCount]['status']=$statusQueryResult[0]['status'];
                            if ($role[0] == 'ROLE_ADMIN') {
                                if($shipStatucount==0 && $currentMonthstatus==2 &&$currentMonthTemprejectionsInString!=null){
                                    $currentShipId=$vesselList[$shipCount]['id'];
                                    $currentShipName=$vesselList[$shipCount]['shipName'];
                                    $shipStatucount++;
                                }
                            }
                            elseif ($role[0] == 'ROLE_MANAGER'){
                                if($shipStatucount==0 && $currentMonthstatus==2&&$currentMonthTemprejectionsInString!=null){
                                    $currentShipId=$vesselList[$shipCount]['id'];
                                    $currentShipName=$vesselList[$shipCount]['shipName'];
                                    $shipStatucount++;
                                }
                                else if($shipStatucount==0 && $currentMonthstatus==1 &&$currentMonthTemprejectionsInString!=null){
                                    $currentShipId=$vesselList[$shipCount]['id'];
                                    $currentShipName=$vesselList[$shipCount]['shipName'];
                                    $shipStatucount++;
                                }
                            }
                            elseif ($role[0] == 'ROLE_DATAPROVIDER'){
                                if($shipStatucount==0 && $currentMonthTemprejectionsInString==null && $currentMonthstatus==1){
                                    $currentShipId=$vesselList[$shipCount]['id'];
                                    $currentShipName=$vesselList[$shipCount]['shipName'];
                                    $shipStatucount++;
                                }
                            }

                        }
                        else{
                            $vesselList[$shipCount]['rejections']=null;
                            if($currentMonthstatus==2 && $currentMonthrejectionsInString==null){
                                $vesselList[$shipCount]['status']=2;
                            }
                            else if($currentMonthstatus==3){
                                $vesselList[$shipCount]['status']=3;
                            }
                            else if($currentMonthstatus==1 &&$currentMonthrejectionsInString!=null && $checkRejectionsExists==false){
                                $vesselList[$shipCount]['status']=2;
                            }
                            else if($currentMonthstatus==1 &&$currentMonthrejectionsInString!=null && $currentMonthTemprejectionsInString!=null){
                                $vesselList[$shipCount]['status']=2;
                            }
                            else if($currentMonthstatus==1 &&$currentMonthrejectionsInString==null && $currentMonthTemprejectionsInString!=null){
                                $vesselList[$shipCount]['status']=2;
                            }
                            else if($currentMonthstatus==1 &&$currentMonthrejectionsInString==null && $currentMonthTemprejectionsInString==null){
                                $vesselList[$shipCount]['status']=1;
                            }
                            else if($currentMonthstatus==2 &&$currentMonthrejectionsInString!=null){
                                $vesselList[$shipCount]['status']=3;
                            }
                        }

                    }
                    else{
                        if($currentMonthstatus==2 &&  $currentMonthrejectionsInString==null){
                            $vesselList[$shipCount]['rejections']=null;
                            $vesselList[$shipCount]['status']=5;
                        }
                        else if($currentMonthstatus==3){
                            $vesselList[$shipCount]['rejections']=null;
                            $vesselList[$shipCount]['status']=2;
                        }
                        else if($currentMonthstatus==2 && $currentMonthrejectionsInString!=null){
                            $checkRejectionsExists=array_key_exists($vesselList[$shipCount]['id'],$currentMonthsRejectionsArray);
                            if($checkRejectionsExists){
                                $vesselList[$shipCount]['rejections']=$currentMonthsRejectionsArray[$vesselList[$shipCount]['id']];
                                $vesselList[$shipCount]['status']=2;
                            }
                            else{
                                $vesselList[$shipCount]['rejections']=null;
                                $vesselList[$shipCount]['status']=2;
                            }
                        }
                        else if($currentMonthstatus==1 &&$currentMonthrejectionsInString!=null){
                            $checkRejectionsExists=array_key_exists($vesselList[$shipCount]['id'],$currentMonthsRejectionsArray);
                            if($checkRejectionsExists){
                                $vesselList[$shipCount]['rejections']=$currentMonthsRejectionsArray[$vesselList[$shipCount]['id']];
                                $vesselList[$shipCount]['status']=1;
                            }
                            else{
                                $vesselList[$shipCount]['rejections']=null;
                                $vesselList[$shipCount]['status']=5;
                            }
                        }
                        else if($currentMonthstatus==2 &&$currentMonthrejectionsInString!=null){
                            $vesselList[$shipCount]['status']=2;
                        }
                        else if($currentMonthstatus==1 &&$currentMonthTemprejectionsInString!=null&&$currentMonthrejectionsInString==null){
                            $vesselList[$shipCount]['status']=1;
                        }
                        else if($currentMonthstatus==1 &&$currentMonthTemprejectionsInString==null&&$currentMonthrejectionsInString==null){
                            $vesselList[$shipCount]['status']=0;
                        }
                    }
                }
                if($currentShipId=="")
                {

                }
            }
        }
        $curretshipObject=$em->getRepository('VesselBundle:ShipDetails')->findOneBy(array('id' =>$currentShipId));
        $kpiRejectionIds=array();
        if($currentShipId==""){
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

        }
        else
        {
            $listofKpiIds = $em->createQueryBuilder()
                ->select('b.kpiName', 'b.id')
                ->from('RankingBundle:RankingKpiDetails', 'b')
                ->where('b.createdDateTime <= :dateTime')
                ->andwhere('b.kpiName != :vesselageValue')
                ->andwhere('b.shipDetailsId =:currentshipId')
                ->andwhere('b.kpiStatusValue = 2 or b.kpiStatusValue = 3')
                ->setParameter('currentshipId',$curretshipObject)
                ->setParameter('vesselageValue', 'Vessel age')
                ->setParameter('dateTime', $dateObject)
                ->add('orderBy', 'b.id  ASC ')
                ->groupBy('b.kpiName')
                ->getQuery()
                ->getResult();
            if(count($currentMonthsRejectionsArray)!=0){
                $kpiRejectionIds=$currentMonthsRejectionsArray[$currentShipId];
            }
        }
        for ($kpiCount = 0; $kpiCount < count($listofKpiIds); $kpiCount++) {
            $kpiId = $listofKpiIds[$kpiCount]['id'];
            $kpiName = $listofKpiIds[$kpiCount]['kpiName'];
            if(count($kpiRejectionIds)==1){
                $rejectionTemp=$kpiRejectionIds;
                if($rejectionTemp=='ALL'){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                    if($rejectionStatusField!=""){
                        $listofKpiIds[$kpiCount]['rejections']=true;
                    }
                    else{
                        $listofKpiIds[$kpiCount]['rejections']=false;
                    }
                }
            }
            else{
                $rejectionStatusField=(string)array_search((string)$kpiId,$kpiRejectionIds);
                if($rejectionStatusField!=""){
                    $listofKpiIds[$kpiCount]['rejections']=true;
                }
                else{
                    $listofKpiIds[$kpiCount]['rejections']=false;
                }
            }
            $elementList = $em->createQueryBuilder()
                ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,
                ele.dateTime,es.symbolIndication,es.id as symbolId')
                ->from('RankingBundle:RankingElementDetails', 'ele')
                ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
                ->where('ele.dateTime <= :dateTime')
                ->andwhere('ele.kpiDetailsId = :kpidetailsid')
                ->setParameter('dateTime', $dateObject)
                ->setParameter('kpidetailsid', $kpiId)
                ->add('orderBy', 'ele.id  DESC ')
                ->getQuery()
                ->getResult();
            if (count($elementList) == 0) {
                $findnewkpiList = $em->createQueryBuilder()
                    ->select('b.kpiName', 'b.id')
                    ->from('RankingBundle:RankingKpiDetails', 'b')
                    ->where('b.kpiName = :kpiName')
                    ->andwhere('b.createdDateTime <= :dateTime')
                    ->andwhere('b.kpiStatusValue = 2 or b.kpiStatusValue = 3')
                    ->setParameter('dateTime', $dateObject)
                    ->setParameter('kpiName', $kpiName)
                    ->add('orderBy', 'b.id  ASC ')
                    ->groupby('b.kpiName')
                    ->getQuery()
                    ->getResult();
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
                        ->setParameter('dateTime', $dateObject)
                        ->setParameter('kpidetailsid', $newkpiId)
                        ->add('orderBy', 'ele.id  DESC ')
                        ->getQuery()
                        ->getResult();
                    for($elementCount=0;$elementCount<count($elementList);$elementCount++){
                        $kpielementValueQuery = $em->createQueryBuilder()
                            ->select('b.value')
                            ->from('RankingBundle:ScorecardMonthlyData', 'b')
                            ->where('b.elementDetailsId = :elementDetailsId')
                            ->andWhere('b.monthdetail =:dataofmonth')
                            ->setParameter('elementDetailsId',$elementList[$elementCount]['id'])
                            ->setParameter('dataofmonth', $dateObject->format('Y-m-d'));
                        if($currentShipId!=""){
                            $kpielementValueQuery
                                ->andWhere('b.shipDetailsId =:shipDetailsId')
                                ->setParameter('shipDetailsId',$curretshipObject);

                        }
                        $kpielementValue=$kpielementValueQuery
                            ->add('orderBy', 'b.shipDetailsId  ASC ')
                            ->getQuery()
                            ->getResult();
                        $elementList[$elementCount]['elementValues']=$kpielementValue;
                    }
                    $listofKpiIds[$kpiCount]['elementList']=$elementList;
                    $listofKpiIds[$kpiCount]['elementList']=$elementList;
                }
                else{
                    $listofKpiIds[$kpiCount]['elementList']=array();
                }

            }
            else {
                for($elementCount=0;$elementCount<count($elementList);$elementCount++){
                    $kpielementValueQuery = $em->createQueryBuilder()
                        ->select('b.value')
                        ->from('RankingBundle:ScorecardMonthlyData', 'b')
                        ->where('b.elementDetailsId = :elementDetailsId')
                        ->andWhere('b.monthdetail =:dataofmonth')
                        ->setParameter('elementDetailsId',$elementList[$elementCount]['id'])
                        ->setParameter('dataofmonth', $dateObject->format('Y-m-d'));
                    if($currentShipId!=""){
                        $kpielementValueQuery
                            ->andWhere('b.shipDetailsId =:shipDetailsId')
                            ->setParameter('shipDetailsId',$curretshipObject);

                    }
                    $kpielementValue=$kpielementValueQuery
                        ->add('orderBy', 'b.shipDetailsId  ASC ')
                        ->getQuery()
                        ->getResult();
                    $elementList[$elementCount]['elementValues']=$kpielementValue;
                }
                $listofKpiIds[$kpiCount]['elementList']=$elementList;
            }
        }
        if($requestMode!=''){
            return array(
                'vesselList' => $vesselList,
                'totalShipCount' => count($vesselList),
                'currentshipid' => $currentShipId,
                'currentshipname' => $currentShipName,
                'statusQueryResult' => $statusQueryResult,
                'shipoverallStatus' => $shipOverallStatus,
                'shipwiseElementValues' => $elementValues,
                'shipwiseStatuscount'=>$statusQueryResult,
                'kpiandelementList'=>$listofKpiIds,
                'currentDatTime'=>$dateObject
            );
        }
        $response = new Response($this->serialize([
            'vesselList' => $vesselList,
            'totalShipCount' => count($vesselList),
            'currentshipid' => $currentShipId,
            'currentshipname' => $currentShipName,
            'statusQueryResult' => $statusQueryResult,
            'shipoverallStatus' => $shipOverallStatus,
            'shipwiseElementValues' => $elementValues,
            'shipwiseStatuscount'=>$statusQueryResult,
            'kpiandelementList'=>$listofKpiIds,
            'currentDatTime'=>$dateObject
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * Adding Kpi Values Ranking.
     *
     *@Rest\Post("/savescorecarddata",name="saveScorecardData")
     */
    public function addkpivaluesAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $userid = $userobject->getId();
        $role = $userobject->getRoles();
        $shipid = $request->request->get('shipId');
        $dataofmonth = $request->request->get('dataofmonth');
        $dateObject=new \DateTime($dataofmonth);
        $dateObject->modify('last day of this month');
        $tempdate = date_format($dateObject, "d-M-Y");
        $datasaveOption=$request->request->get('datasaveOption');
        $elementDetails=$request->request->get('elementDetails');
        $kpiDetailsGroup=$request->request->get('kpiDetailsGroup');
        $returnmsg = '';
        $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>$shipid));
        $elementDetailskeyValue=array_keys($elementDetails);
        $kpiDetailskeyValue=array_keys($kpiDetailsGroup);
        if($userobject->getCompanyId() ==null ){
            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->andWhere('s.createdDate <= :activeDate')
                ->setParameter('activeDate', $dateObject)
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
        }
        else{

            $vesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->andWhere('s.createdDate <= :activeDate')
                ->setParameter('activeDate', $dateObject)
                ->setParameter('companyId', $userobject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        /*$shipIdOnlyarray=array();
        foreach ($vesselList as $vesselId) {
            array_push($shipIdOnlyarray,$vesselId['id']);
        }*/
        /* if ($buttonid == 'updatebuttonid' || $buttonid == 'adminbuttonid' || $buttonid == 'verfiybuttonid') {*/
        if ($datasaveOption == 1 || $datasaveOption ==2 || $datasaveOption == 3) {
            for ($elementCount = 0; $elementCount < count($elementDetailskeyValue); $elementCount++) {
                $arraykeyValue=$elementDetailskeyValue[$elementCount];
                $currentelementValue=$elementDetails[$arraykeyValue];
                $elementarrayfromString=explode("_",$arraykeyValue);
                $elemenId=$elementarrayfromString[1];
                $entityobject = $em->getRepository('RankingBundle:ScorecardMonthlyData')->findOneBy(array('elementDetailsId' =>  (int)$elemenId,'shipDetailsId'=>$shipObject,'monthdetail'=>$dateObject));
                if ($datasaveOption == 3) {
                    $entityobject->setValue($currentelementValue);
                    $entityobject->setStatus(3);
                }
                if ($datasaveOption == 2) {
                    $entityobject->setValue($currentelementValue);
                    $entityobject->setStatus(2);
                }
                if ($datasaveOption == 1) {
                    $entityobject->setValue($currentelementValue);
                    $entityobject->setStatus(1);
                }
                $em->flush();

            }
            $returnmsg = $shipObject->getShipName().' Data Updated...';
            if ($datasaveOption == 3) {
                $rankinglookuptable = array('shipid' => $shipid, 'dataofmonth' => $tempdate, 'userid' => $userid, 'status' => 3,'kpistatusValue'=>2, 'datetime' => date('Y-m-d H:i:s'));
                $lookupstatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('dataofmonth' => $dateObject));
                if ($lookupstatus!=null) {
                    $listofshipsInserted=$lookupstatus->getShipids();
                    if($lookupstatus->getStatus()==3){
                        $lookupstatus->setShipids($listofshipsInserted.','.$shipid);
                    }
                    else{
                        $lookupstatus->setShipids($shipid);
                    }

                    $lookupstatus->setDatetime(new \DateTime());
                    $lookupstatus->setStatus(3);
                    $em->flush();

                }
                $gearman = $this->get('gearman');
                $gearman->doBackgroundJob('RankingBundleServicesExecuteNodeFindColor~scorecard_execute_node_findcolor', json_encode($rankinglookuptable));
            }
            else if ($datasaveOption == 2) {
                $lookupstatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('dataofmonth' => $dateObject));
                if ($lookupstatus!=null) {
                    if($lookupstatus->getRejections()!=null &&$lookupstatus->getStatus()==2){
                        $lookupstatus->setDatetime(new \DateTime());
                        $lookupstatus->setStatus(3);
                        $lookupstatus->setRejections(null);
                        $lookupstatus->setTempRejections(null);
                        $em->flush();
                    }
                    else{
                        $listofshipsInserted=$lookupstatus->getShipids();
                        if($lookupstatus->getStatus()==2){
                            $lookupstatus->setShipids($listofshipsInserted.','.$shipid);
                        }
                        else{
                            $lookupstatus->setShipids($shipid);
                        }
                        $lookupstatus->setDatetime(new \DateTime());
                        $lookupstatus->setStatus(2);
                        $lookupstatus->setRejections(null);
                        $em->flush();
                    }

                }
            }
            else if ($datasaveOption == 1) {
                $lookupstatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('dataofmonth' => $dateObject));
                if ($lookupstatus!=null) {
                    $lookupstatus->setDatetime(new \DateTime());
                    $lookupstatus->setStatus(1);
                    $lookupstatus->setRejections(null);
                    $lookupstatus->setRejectionsStatus(null);
                    $em->flush();
                }
            }
        }
        if ($datasaveOption == 0) {
            /*  foreach ($kpiandelementids as $element) {
              for ($elementCount = 0; $elementCount < count($element); $elementCount++) {
                  $baseValueQuery = $em->createQueryBuilder()
                      ->select('a.baseValue')
                      ->from('InitialShippingBundle:ElementDetails', 'a')
                      ->where('a.id=:elementId')
                      ->setParameter('elementId', $element[$elementCount])
                      ->getQuery()
                      ->getResult();
                  $baseValue = $baseValueQuery[0]['baseValue'];
                  if ($baseValue != 0) {
                      $baseValueForAllShips = $baseValue * count($shipDetails);
                      $currentMonth = (int)$baseValueChangeMonth;
                      $monthlyCount = $baseValueForAllShips / 12;
                      $currentMonthValue = (int)$currentMonth * $monthlyCount;
                      $elementRulesQuery = $em->createQueryBuilder()
                          ->select('a.rules,a.id')
                          ->from('InitialShippingBundle:Rules', 'a')
                          ->where('a.elementDetailsId=:elementId')
                          ->setParameter('elementId', $element[$elementCount])
                          ->getQuery()
                          ->getResult();
                      foreach ($elementRulesQuery as $rules) {
                          $currentMonthValue1 = 0;
                          $ruleObj = json_decode($rules['rules']);
                          $ruleColor = $ruleObj->actions->value;
                          if ($ruleColor == 'Green') {
                              $currentMonthValue1 = (int)$currentMonthValue;
                          } else if ($ruleColor == 'Yellow') {
                              $currentMonthValue1 = (int)$currentMonthValue + (int)$currentMonthValue / 4;
                          } else if ($ruleColor == 'Red') {
                              $currentMonthValue1 = (int)$currentMonthValue + (int)$currentMonthValue / 4;
                          }
                          $ruleObj->conditions->all[0]->value = $currentMonthValue1;
                          $ruleString = json_encode($ruleObj);
                          $rulesDetailObject = $em->getRepository('InitialShippingBundle:Rules')->find($rules['id']);
                          $rulesDetailObject->setRules($ruleString);
                          $em->flush();
                      }
                  }
              }
          }*/
            for ($elementCount = 0; $elementCount < count($elementDetailskeyValue); $elementCount++) {
                $arraykeyValue=$elementDetailskeyValue[$elementCount];
                $currentelementValue=$elementDetails[$arraykeyValue];
                $elementarrayfromString=explode("_",$arraykeyValue);
                $elemenId=$elementarrayfromString[1];
                $elementidObject = $em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' => $elemenId));
                $kpiObject=$elementidObject->getKpiDetailsId();
                //Change Element Rule Based on Base Value
                $baseValue=$elementidObject->getBaseValue();
                if ($baseValue != 0) {
                    $baseValueForAllShips = $baseValue * count($vesselList);
                    $currentMonth = (int) date_format($dateObject, "m");
                    $monthlyCount = $baseValueForAllShips / 12;
                    $currentMonthValue = (int)$currentMonth * $monthlyCount;
                    $elementRulesQuery = $em->createQueryBuilder()
                        ->select('a.rules,a.id')
                        ->from('RankingBundle:RankingRulesDetails', 'a')
                        ->where('a.elementDetailsId=:elementId')
                        ->setParameter('elementId', $elementidObject)
                        ->getQuery()
                        ->getResult();
                    foreach ($elementRulesQuery as $rules) {
                        $currentMonthValue1 = 0;
                        $ruleObj = json_decode($rules['rules']);
                        $ruleColor = $ruleObj->actions->value;
                        if ($ruleColor == 'Green') {
                            $currentMonthValue1 = (int)$currentMonthValue;
                        } else if ($ruleColor == 'Yellow') {
                            $currentMonthValue1 = (int)$currentMonthValue + (int)$currentMonthValue / 4;
                        } else if ($ruleColor == 'Red') {
                            $currentMonthValue1 = (int)$currentMonthValue + (int)$currentMonthValue / 4;
                        }
                        $ruleObj->conditions->all[0]->value = $currentMonthValue1;
                        $ruleString = json_encode($ruleObj);
                        $rulesDetailObject = $em->getRepository('InitialShippingBundle:Rules')->find($rules['id']);
                        $rulesDetailObject->setRules($ruleString);
                        $em->flush();
                    }
                }
                //Change Element Rule Based on Base Value
                $readingkpivalue = new ScorecardMonthlyData();
                $readingkpivalue->setKpiDetailsId($kpiObject);
                $readingkpivalue->setElementDetailsId($elementidObject);
                $readingkpivalue->setShipDetailsId($shipObject);
                $readingkpivalue->setMonthdetail($dateObject);
                $readingkpivalue->setValue($currentelementValue);
                $readingkpivalue->setStatus(1);
                $em->persist($readingkpivalue);
                $em->flush();
            }
            $lookupstatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('dataofmonth' => $dateObject));
            if ($lookupstatus!=null) {
                $listofshipsInserted=$lookupstatus->getShipids();
                $lookupstatus->setShipids($listofshipsInserted.','.$shipid);
                $lookupstatus->setDatetime(new \DateTime());
                $em->flush();
            } else
            {
                $lookupstatusobject = new ScorecardLookupStatus();
                $lookupstatusobject->setShipids($shipid);
                $lookupstatusobject->setStatus(1);
                $lookupstatusobject->setDataofmonth($dateObject);
                $lookupstatusobject->setDatetime(new \DateTime());
                $lookupstatusobject->setUserid($userid);
                $lookupstatusobject->setRejectionsStatus(false);
                $em->persist($lookupstatusobject);
                $em->flush();
            }
            $returnmsg = $shipObject->getShipName().' Data Saved...';

        }
        if ($datasaveOption == 5) {
            /* $status = 5;
             $pre_rejections = $em->createQueryBuilder()
                 ->select('a.temp_rejections, a.rejections')
                 ->from('RankingBundle:ScorecardLookupStatus', 'a')
                 ->where('a.dataofmonth = :dataofmonth')
                 ->setParameter('dataofmonth', $dateObject)
                 ->getQuery()
                 ->getResult();
             if (count($pre_rejections) > 0) {
                 if ($pre_rejections[0]['temp_rejections'] != null && $pre_rejections[0]['temp_rejections'] != "null") {
                     $response = new JsonResponse();

                     $response->setData(array (
                             'returnmsg' => 'rejection_error'
                         )
                     );
                     return $response;
                 }
                 if ($pre_rejections[0]['rejections'] != null && $pre_rejections[0]['rejections'] != "null") {
                     $status = 2;
                 }
             }*/
            foreach ($vesselList as $vessel) {
                $check_empty_value_query = $em->createQueryBuilder()
                    ->select('a.value')
                    ->from('RankingBundle:ScorecardMonthlyData', 'a')
                    ->where('a.shipDetailsId = :shipdetailsid')
                    ->andWhere('a.monthdetail =:dataofmonth')
                    ->setParameter('shipdetailsid', $vessel['id'])
                    ->setParameter('dataofmonth', $dateObject->format('Y-m-d'))
                    ->getQuery()
                    ->getResult();
                foreach ($check_empty_value_query as $check_empty_values) {
                    if ($check_empty_values['value'] != null && $check_empty_values['value'] !=" ") {
                        continue;
                    } else {
                        $return_msg = $vessel['shipName'] . ' data is not completed !';
                        $elementIdsandkpiIds=$this->rankinDataverificationbyShipWiseAction($request, $vessel['id'],$dateObject,2);
                        $response = new Response($this->serialize([
                            'return_msg' => $return_msg,
                            'status' => -1,
                            'currentshipid' => $vessel['id'],
                            'currentshipname' => $vessel['shipName'],
                            'kpiandelementList'=> $elementIdsandkpiIds['kpiandelementList'],
                            'elementValues'=>$elementIdsandkpiIds['elementsValues'],
                            'dateObject'=>$dateObject,
                            'currentdateandMonthOnly'=>$dateObject->format('M-Y')
                        ]), Response::HTTP_CREATED);
                        return $this->setBaseHeaders($response);
                    }
                }
            }
            $lookupstatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('dataofmonth' => $dateObject));
            if ($lookupstatus!=null) {
                $rejection_string = null;
                $listofshipsInserted=$lookupstatus->getShipids();
                $listofshiparray=explode(',',$listofshipsInserted);
                if(count($listofshiparray)==count($vesselList)){
                    $lookupstatus->setStatus(5);
                }
                else{
                    $lookupstatus->setStatus(2);
                }
                $lookupstatus->setTempRejections(null);
                $lookupstatus->setDatetime(new \DateTime());
                $lookupstatus->setRejectionsStatus(false);
                $em->flush();
            }
            $returnmsg = ' Data Uploaded...';

        }
        if ($datasaveOption == -1) {
            $rejectionkpiId=array();
            for ($kpiCount = 0; $kpiCount < count($kpiDetailskeyValue); $kpiCount++) {
                $kpiarraykeyValue=$kpiDetailskeyValue[$kpiCount];
                $currentkpiValue=$kpiDetailsGroup[$kpiarraykeyValue];
                $kpiarrayfromString=explode("_",$kpiarraykeyValue);
                $kpiId=$kpiarrayfromString[1];
                if($currentkpiValue){
                    array_push($rejectionkpiId,$kpiId);
                }
            }
            $pre_rejections = $em->createQueryBuilder()
                ->select('a.rejections')
                ->from('RankingBundle:ScorecardLookupStatus', 'a')
                ->where('a.dataofmonth = :dataofmonth')
                ->setParameter('dataofmonth', $dateObject)
                ->getQuery()
                ->getResult();
            $reject_id_string = null;
            if (count($rejectionkpiId)!=0) {
                $reject_id_string = implode(",", $rejectionkpiId);
            } else {
                $reject_id_string = 'ALL';
            }

            if (count($pre_rejections) > 0) {
                if ($pre_rejections[0]['rejections'] != null && $pre_rejections[0]['rejections'] != "null") {
                    $temp = json_decode($pre_rejections[0]['rejections']);
                    if ($reject_id_string == 'ALL') {
                        $temp->$shipid = $reject_id_string;
                    } else {
                        $temp->$shipid = explode(',', $reject_id_string);
                    }
                    $temp = json_encode($temp);
                } else {
                    if ($reject_id_string == 'ALL') {
                        $temp = json_encode(array($shipid => $reject_id_string));
                    } else {
                        $temp = json_encode(array($shipid => explode(',', $reject_id_string)));
                    }
                }
            } else {
                if ($reject_id_string == 'ALL') {
                    $temp = json_encode(array($shipid => $reject_id_string));
                } else {
                    $temp = json_encode(array($shipid => explode(',', $reject_id_string)));
                }
            }
            $lookupstatus = $em->getRepository('RankingBundle:ScorecardLookupStatus')->findOneBy(array('dataofmonth' => $dateObject));
            if ($lookupstatus!=null) {
                $lookupstatus->setStatus(1);
                $lookupstatus->setRejections($temp);
                $lookupstatus->setTempRejections($temp);
                $lookupstatus->setDatetime(new \DateTime());
                $lookupstatus->setRejectionsStatus(true);
                $em->flush();
            }
            $returnmsg =$shipObject->getShipName(). ' rejected...';
        }
        $findStattus=$this->gotoScorecardMonthDataAction($request,$reuseMode="rebuildcode");
        $response = new Response($this->serialize([
            'vesselList' => $findStattus['vesselList'],
            'totalShipCount' => count( $findStattus['vesselList']),
            'currentshipid' =>  $findStattus['currentshipid'],
            'currentshipname' =>  $findStattus['currentshipname'],
            'statusQueryResult' =>  $findStattus['statusQueryResult'],
            'shipoverallStatus' =>  $findStattus['shipoverallStatus'],
            'shipwiseElementValues' =>  $findStattus['shipwiseElementValues'],
            'shipwiseStatuscount'=> $findStattus['shipwiseStatuscount'],
            'kpiandelementList'=> $findStattus['kpiandelementList'],
            'currentDatTime'=>$dateObject,
            'currentdateandMonthOnly'=>$dateObject->format('M-Y'),
            'return_msg' => $returnmsg,
            'status' => 1,
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
