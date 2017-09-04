<?php

namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DashboardBundle\Entity\BodyAreasAffected;
use DashboardBundle\Entity\ContainerPollutionCategory;
use DashboardBundle\Entity\FactortoIncident;
use DashboardBundle\Entity\HazardType;
use DashboardBundle\Entity\Incident;
use DashboardBundle\Entity\IncidentCost;
use DashboardBundle\Entity\IncidentDetails;
use DashboardBundle\Entity\IncidentFirstInfo;
use DashboardBundle\Entity\IncidentOperatorWeather;
use DashboardBundle\Entity\IncidentStatisticsData;
use DashboardBundle\Entity\OperationattimeofIncident;
use DashboardBundle\Entity\PlaceofAccident;
use DashboardBundle\Entity\SeaPollutionCategory;
use DashboardBundle\Entity\ShipOperation;
use DashboardBundle\Entity\TypeofAccident;
use DashboardBundle\Entity\TypeofCause;
use DashboardBundle\Entity\TypeofIncident;
use DashboardBundle\Entity\TypeofInjury;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\CompanyUsers;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * IncidentController.
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * Find all Incident Dashbaord Report
     * @Rest\Post("/welcome",name="dashboard_welcome")
     */
    public function welcomePageAction(Request $request,$reuseMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $selectedYear=$request->request->get('selectedYear');
        if($companyId==null){
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            $finduserObject=$em->createQueryBuilder()
                ->select('u')
                ->from('UserBundle:User', 'u')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 'u.companyId = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            if(count($finduserObject)!=0){
                $userobject=$finduserObject[0];
            }
        }
        else{

            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->setParameter('companyId', $userobject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        if($selectedYear!=""){
            $currentYear=$selectedYear;
        }else{
            $currentYear=date("Y");
        }
        //Find type of Incident Count
        $typeofIncdientlist = $em->createQueryBuilder()
            ->select('ti.id', 'ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $incidentCountByIncidentWise= $em->createQueryBuilder()
            ->select('count(i.id) as typeofincidentCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('tc.id')
            ->orderBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $typeofincidentCountarray=array();
        for($typeofincidentcount=0;$typeofincidentcount<count($typeofIncdientlist);$typeofincidentcount++){
            $typeofincidentTempArray=array();
            $typeofincidentTempArray['name']=$typeofIncdientlist[$typeofincidentcount]['incidentName'];
            if($typeofincidentcount>count($incidentCountByIncidentWise)-1){
                $typeofincidentTempArray['y']=0;
            }
            else{
                $typeofincidentTempArray['y']=(int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
            }
            array_push($typeofincidentCountarray,$typeofincidentTempArray);
        }
        //Find type of cuase Count
        $typeofCauselist = $em->createQueryBuilder()
            ->select('tc.id', 'tc.causeName')
            ->from('DashboardBundle:TypeofCause', 'tc')
            ->getQuery()
            ->getResult();
        $incidnentTypeofcuaseList= $em->createQueryBuilder()
            ->select('count(i.id) as typeofcauseCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $incidentCountbyTypeofCause=array();
        for($typeofcaausecount=0;$typeofcaausecount<count($typeofCauselist);$typeofcaausecount++){
            $typeofcauseTempArray=array();
            $typeofcauseTempArray['name']=$typeofCauselist[$typeofcaausecount]['causeName'];
            if($typeofcaausecount>count($incidnentTypeofcuaseList)-1){
                $typeofcauseTempArray['y']=0;
            }
            else{
                $typeofcauseTempArray['y']=(int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
            }
            array_push($incidentCountbyTypeofCause,$typeofcauseTempArray);
        }
        $incidentClosed = $em->createQueryBuilder()
            ->select('count(i.id) as incidentClosed')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andwhere('if.statusofReport = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',2)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $incidentOpend = $em->createQueryBuilder()
            ->select('count(i.id) as incidentOpen')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andwhere('if.statusofReport = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',1)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $graphRecord= $em->createQueryBuilder()
            ->select('count(i.id) as shipWiseCount','s.shipName','if.dateofIncident')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $serverityClassfication= $em->createQueryBuilder()
            ->select('count(i.id) as countValue')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->where('i.userId = :userObject ')
            ->andwhere('tc.severityClassification = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',3)
            ->orderBy('i.id')
            ->getQuery()
            ->getResult();
        $vesselList=array();
        $vesselwiseincidentCount=array();
        $incidentclosedVessleCount=array();
        $incidentopenStatusCount=array();
        //Find Number of incident for particular Vessel
        for($shipCount=0;$shipCount<count($VesselList);$shipCount++){
            array_push($vesselList,$VesselList[$shipCount]['shipName']);
            if($shipCount>count($graphRecord)-1){
                array_push($vesselwiseincidentCount,0);
            }
            else{
                array_push($vesselwiseincidentCount,(int)$graphRecord[$shipCount]['shipWiseCount']);
            }

            if($shipCount>count($incidentOpend)-1){
                array_push($incidentopenStatusCount,0);
            }
            else{
                array_push($incidentopenStatusCount,(int)$incidentOpend[$shipCount]['incidentOpen']);
            }
            if($shipCount>count($incidentClosed)-1){
                array_push($incidentclosedVessleCount,0);
            }
            else{
                array_push($incidentclosedVessleCount,(int)$incidentClosed[$shipCount]['incidentClosed']);
            }
        }
        $response = new Response($this->serialize(['incidentclosed' =>array_sum($incidentclosedVessleCount) ,'incidentOpenStaus'=>array_sum($incidentopenStatusCount),
            'totalnoIncidnets'=>array_sum($vesselwiseincidentCount),'currentYear'=>$currentYear,'vesselList'=>$vesselList,
            'graphData'=>$vesselwiseincidentCount,'incidentclosedVessleCount'=>$incidentclosedVessleCount,
            'incidentopenStatusCount'=>$incidentopenStatusCount,'serverityClassfication'=>$serverityClassfication[0]['countValue'],
            'typeofIncidentWiseIncidents'=>$typeofincidentCountarray,'typeofCausewiseIncident'=>$incidentCountbyTypeofCause,

        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Find all monthwiseAction Report
     * @Rest\Post("/welcomedata_month",name="dashboard_welcome_month")
     */
    public function monthwiseAction(Request $request,$reuseMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $monthData=$request->request->get('selectMonth');
        $selectedYear=$request->request->get('selectedYear');
        if($companyId==null){
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            $finduserObject=$em->createQueryBuilder()
                ->select('u')
                ->from('UserBundle:User', 'u')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 'u.companyId = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            if(count($finduserObject)!=0){
                $userobject=$finduserObject[0];
            }
        }
        else{

            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->setParameter('companyId', $userobject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        if($monthData!=""){
            $currentMonth=$monthData;
        }
        else{
            $currentMonth=date("m");
        }
        if($selectedYear!=""){
            $currentYear=$selectedYear;
        }
        else{
            $currentYear=date("Y");
        }
        //Find type of Incident Count
        $typeofIncdientlist = $em->createQueryBuilder()
            ->select('ti.id', 'ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $incidentCountByIncidentWise= $em->createQueryBuilder()
            ->select('count(i.id) as typeofincidentCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
            ->where('i.userId = :userObject ')
            ->andWhere('Month(if.dateofIncident) =:currentMonth')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('currentMonth',$currentMonth)
            ->setParameter('userObject', $userobject)
            ->groupBy('tc.id')
            ->orderBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $typeofincidentCountarray=array();
        for($typeofincidentcount=0;$typeofincidentcount<count($typeofIncdientlist);$typeofincidentcount++){
            $typeofincidentTempArray=array();
            $typeofincidentTempArray['name']=$typeofIncdientlist[$typeofincidentcount]['incidentName'];
            if($typeofincidentcount>count($incidentCountByIncidentWise)-1){
                $typeofincidentTempArray['y']=0;
            }
            else{
                $typeofincidentTempArray['y']=(int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
            }
            array_push($typeofincidentCountarray,$typeofincidentTempArray);
        }
        //Find type of cuase Count
        $typeofCauselist = $em->createQueryBuilder()
            ->select('tc.id', 'tc.causeName')
            ->from('DashboardBundle:TypeofCause', 'tc')
            ->getQuery()
            ->getResult();
        $incidnentTypeofcuaseList= $em->createQueryBuilder()
            ->select('count(i.id) as typeofcauseCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->where('i.userId = :userObject ')
            ->andWhere('Month(if.dateofIncident) =:currentMonth')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('currentMonth',$currentMonth)
            ->setParameter('userObject', $userobject)
            ->groupBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $incidentCountbyTypeofCause=array();
        for($typeofcaausecount=0;$typeofcaausecount<count($typeofCauselist);$typeofcaausecount++){
            $typeofcauseTempArray=array();
            $typeofcauseTempArray['name']=$typeofCauselist[$typeofcaausecount]['causeName'];
            if($typeofcaausecount>count($incidnentTypeofcuaseList)-1){
                $typeofcauseTempArray['y']=0;
            }
            else{
                $typeofcauseTempArray['y']=(int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
            }
            array_push($incidentCountbyTypeofCause,$typeofcauseTempArray);
        }
        $incidentClosed = $em->createQueryBuilder()
            ->select('count(i.id) as incidentClosed')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andwhere('if.statusofReport = :statusValue')
            ->andWhere('Month(if.dateofIncident) =:currentMonth')
            ->setParameter('currentMonth',$currentMonth)
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',2)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $incidentOpend = $em->createQueryBuilder()
            ->select('count(i.id) as incidentOpen')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andwhere('if.statusofReport = :statusValue')
            ->andWhere('Month(if.dateofIncident) =:currentMonth')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('currentMonth',$currentMonth)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',1)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $graphRecord= $em->createQueryBuilder()
            ->select('count(i.id) as shipWiseCount','s.shipName','if.dateofIncident')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andWhere('Month(if.dateofIncident) =:currentMonth')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('currentMonth',$currentMonth)
            ->setParameter('userObject', $userobject)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $serverityClassfication= $em->createQueryBuilder()
            ->select('count(i.id) as countValue')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->where('i.userId = :userObject ')
            ->andwhere('tc.severityClassification = :statusValue')
            ->andWhere('Month(if.dateofIncident) =:currentMonth')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('currentMonth',$currentMonth)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',1)
            ->orderBy('i.id')
            ->getQuery()
            ->getResult();
        $vesselList=array();
        $vesselwiseincidentCount=array();
        $incidentclosedVessleCount=array();
        $incidentopenStatusCount=array();
        //Find Number of incident for particular Vessel
        for($shipCount=0;$shipCount<count($VesselList);$shipCount++){
            array_push($vesselList,$VesselList[$shipCount]['shipName']);
            if($shipCount>count($graphRecord)-1){
                array_push($vesselwiseincidentCount,0);
            }
            else{
                array_push($vesselwiseincidentCount,(int)$graphRecord[$shipCount]['shipWiseCount']);
            }

            if($shipCount>count($incidentOpend)-1){
                array_push($incidentopenStatusCount,0);
            }
            else{
                array_push($incidentopenStatusCount,(int)$incidentOpend[$shipCount]['incidentOpen']);
            }
            if($shipCount>count($incidentClosed)-1){
                array_push($incidentclosedVessleCount,0);
            }
            else{
                array_push($incidentclosedVessleCount,(int)$incidentClosed[$shipCount]['incidentClosed']);
            }
        }
        $response = new Response($this->serialize(['incidentclosed' =>array_sum($incidentclosedVessleCount) ,'incidentOpenStaus'=>array_sum($incidentopenStatusCount),
            'totalnoIncidnets'=>array_sum($vesselwiseincidentCount),'currentMonth'=>$currentMonth,'vesselList'=>$vesselList,
            'graphData'=>$vesselwiseincidentCount,'incidentclosedVessleCount'=>$incidentclosedVessleCount,
            'incidentopenStatusCount'=>$incidentopenStatusCount,'serverityClassfication'=>$serverityClassfication[0]['countValue'],
            'typeofIncidentWiseIncidents'=>$typeofincidentCountarray,'typeofCausewiseIncident'=>$incidentCountbyTypeofCause
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Find offhiredaysandCost Report
     * @Rest\Post("/offhiredayscost",name="offhiredayscost")
     */
    public function offhiredaysandCostAction(Request $request,$reuseMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $yearData=$request->request->get('selectYear');
        if($companyId==null){
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            $finduserObject=$em->createQueryBuilder()
                ->select('u')
                ->from('UserBundle:User', 'u')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 'u.companyId = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            if(count($finduserObject)!=0){
                $userobject=$finduserObject[0];
            }
        }
        else{

            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->setParameter('companyId', $userobject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        if($yearData==""){
            $currentYear=date("Y");
        }
        else{
            $currentYear=$yearData;
        }
        $graphRecord= $em->createQueryBuilder()
            ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName','s.id','if.dateofIncident','ic.offHireDays','ic.incidentFinalCostUSD')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $vesselList=array();
        $vesselwiseincidentCount=array();
        $incidentclosedVessleCount=array();
        $incidentopenStatusCount=array();
        $incidentcostcount=array();
        $inicdentoffhiredays=array();
        $graphseriesValue=array();
        //Find Number of incident for particular Vessel
        for($shipCount=0;$shipCount<count($graphRecord);$shipCount++){
            $graphseriesTemp=array();
            $graphseriesTemp['name']=$graphRecord[$shipCount]['shipName'];
            array_push($vesselList,$VesselList[$shipCount]['shipName']);
            if($shipCount>count($graphRecord)-1){
                array_push($vesselwiseincidentCount,0);
            }
            else{
                array_push($vesselwiseincidentCount,(int)$graphRecord[$shipCount]['numberofincidents']);
                array_push($incidentcostcount,(int)$graphRecord[$shipCount]['totalcost']);
                $graphseriesTemp['y']=(int)$graphRecord[$shipCount]['totalcost'];
                array_push($inicdentoffhiredays,(int)$graphRecord[$shipCount]['totaloffhiredays']);
            }
            array_push($graphseriesValue,$graphseriesTemp);
        }
        $response = new Response($this->serialize([
            'totalincidnets' =>array_sum($vesselwiseincidentCount) ,'totalcost'=>array_sum($incidentcostcount),
            'totaloffhiredays'=>array_sum($inicdentoffhiredays),'currentYear'=>$currentYear,'vesselList'=>$vesselList,
            'graphData'=>$vesselwiseincidentCount,'incidentclosedVessleCount'=>$incidentclosedVessleCount,
            'incidentopenStatusCount'=>$incidentopenStatusCount,'offhiredayscountshipwise'=>$inicdentoffhiredays,
            'incidentcostshipwise'=>$incidentcostcount,'vesselistObject'=>$VesselList,'graphDataDetails'=>$graphRecord,
            'graphseriesValue'=>$graphseriesValue]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Find all  typeofcausereport
     * @Rest\Post("/typeofcausereport",name="typeofcausereport")
     */
    public function typeofcausereportAction(Request $request,$reuseMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $selectedYear=$request->request->get('selectedYear');

        if($companyId==null){
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            $finduserObject=$em->createQueryBuilder()
                ->select('u')
                ->from('UserBundle:User', 'u')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 'u.companyId = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
            if(count($finduserObject)!=0){
                $userobject=$finduserObject[0];
            }
        }
        else{

            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->setParameter('companyId', $userobject->getCompanyId())
                ->getQuery()
                ->getResult();
        }
        if($selectedYear!=""){
            $currentYear=$selectedYear;
        }else{
            $currentYear=date("Y");
        }
        //Find type of Incident Count
        $typeofIncdientlist = $em->createQueryBuilder()
            ->select('ti.id', 'ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $incidentCountByIncidentWise= $em->createQueryBuilder()
            ->select('count(i.id) as typeofincidentCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('tc.id')
            ->orderBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $typeofincidentCountarray=array();
        for($typeofincidentcount=0;$typeofincidentcount<count($typeofIncdientlist);$typeofincidentcount++){
            $typeofincidentTempArray=array();
            $typeofincidentTempArray['name']=$typeofIncdientlist[$typeofincidentcount]['incidentName'];
            if($typeofincidentcount>count($incidentCountByIncidentWise)-1){
                $typeofincidentTempArray['y']=0;
            }
            else{
                $typeofincidentTempArray['y']=(int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
            }
            array_push($typeofincidentCountarray,$typeofincidentTempArray);
        }
        //Find type of cuase Count
        $typeofCauselist = $em->createQueryBuilder()
            ->select('tc.id', 'tc.causeName')
            ->from('DashboardBundle:TypeofCause', 'tc')
            ->getQuery()
            ->getResult();
        $incidnentTypeofcuaseList= $em->createQueryBuilder()
            ->select('count(i.id) as typeofcauseCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $incidentCountbyTypeofCause=array();
        for($typeofcaausecount=0;$typeofcaausecount<count($typeofCauselist);$typeofcaausecount++){
            $typeofcauseTempArray=array();
            $typeofcauseTempArray['name']=$typeofCauselist[$typeofcaausecount]['causeName'];
            if($typeofcaausecount>count($incidnentTypeofcuaseList)-1){
                $typeofcauseTempArray['y']=0;
            }
            else{
                $typeofcauseTempArray['y']=(int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
            }
            array_push($incidentCountbyTypeofCause,$typeofcauseTempArray);
        }
        $incidentClosed = $em->createQueryBuilder()
            ->select('count(i.id) as incidentClosed')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andwhere('if.statusofReport = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',2)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $incidentOpend = $em->createQueryBuilder()
            ->select('count(i.id) as incidentOpen')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andwhere('if.statusofReport = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',1)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $graphRecord= $em->createQueryBuilder()
            ->select('count(i.id) as shipWiseCount','s.shipName','if.dateofIncident')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $serverityClassfication= $em->createQueryBuilder()
            ->select('count(i.id) as countValue')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->where('i.userId = :userObject ')
            ->andwhere('tc.severityClassification = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear',$currentYear)
            ->setParameter('userObject', $userobject)
            ->setParameter('statusValue',3)
            ->orderBy('i.id')
            ->getQuery()
            ->getResult();
        $vesselList=array();
        $vesselwiseincidentCount=array();
        $incidentclosedVessleCount=array();
        $incidentopenStatusCount=array();
        $typeofcaausecountvesslewise=array();
        //Find Number of incident for particular Vessel
        $ship_typeofcuaselist=array();
        for($shipCount=0;$shipCount<count($VesselList);$shipCount++){
            array_push($vesselList,$VesselList[$shipCount]['shipName']);
            $incidentCountByIncidentWiseWithVesselWise=array();
            if($shipCount>count($graphRecord)-1){
                array_push($vesselwiseincidentCount,0);
                for($j=0;$j<count($typeofCauselist);$j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as typeofcauseCount')
                        ->from('DashboardBundle:Incident', 'i')
                        ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
                        ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                        ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                        ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                        ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                        ->where('s.id = :ship_id ')
                        ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                        ->andWhere('tc.id = :typeofIncdientId ')
                        ->setParameter('ship_id',$VesselList[$shipCount]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise,$incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                }
            }
            else{
                array_push($vesselwiseincidentCount,(int)$graphRecord[$shipCount]['shipWiseCount']);
                for($j=0;$j<count($typeofCauselist);$j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as typeofcauseCount')
                        ->from('DashboardBundle:Incident', 'i')
                        ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
                        ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                        ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                        ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                        ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                        ->where('s.id = :ship_id ')
                        ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                        ->andWhere('tc.id = :typeofIncdientId ')
                        ->setParameter('ship_id',$VesselList[$shipCount]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise,$incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                }
            }

            if($shipCount>count($incidentOpend)-1){
                array_push($incidentopenStatusCount,0);
            }
            else{
                array_push($incidentopenStatusCount,(int)$incidentOpend[$shipCount]['incidentOpen']);
            }
            if($shipCount>count($incidentClosed)-1){
                array_push($incidentclosedVessleCount,0);
            }
            else{
                array_push($incidentclosedVessleCount,(int)$incidentClosed[$shipCount]['incidentClosed']);
            }

            array_push($typeofcaausecountvesslewise,array_sum($incidentCountByIncidentWiseWithVesselWise));
            array_push($ship_typeofcuaselist,$incidentCountByIncidentWiseWithVesselWise);
        }
        $response = new Response($this->serialize(['incidentclosed' =>array_sum($incidentclosedVessleCount) ,'incidentOpenStaus'=>array_sum($incidentopenStatusCount),
            'totalnoIncidnets'=>array_sum($vesselwiseincidentCount),'currentYear'=>$currentYear,'vesselList'=>$VesselList,
            'graphData'=>$vesselwiseincidentCount,'incidentclosedVessleCount'=>$incidentclosedVessleCount,
            'incidentopenStatusCount'=>$incidentopenStatusCount,'serverityClassfication'=>$serverityClassfication[0]['countValue'],
            'typeofIncidentWiseIncidents'=>$typeofincidentCountarray,'typeofCausewiseIncident'=>$incidentCountbyTypeofCause,
            'typeofCauseList'=>$typeofCauselist,'vesselwisetypeofcause'=>$ship_typeofcuaselist,'typeofcaausecountvesslewise'=>$typeofcaausecountvesslewise
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
