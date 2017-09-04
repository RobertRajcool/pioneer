<?php

namespace DashboardBundle\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
 * @Route("/incident")
 */
class IncidentController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * Find all ships for Company
     * @Rest\GET("/findVessels",name="incident_listofVessels")
     */
    public function findallshipsAction(Request $request,$reuseMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        //Find all Vessels
        if($companyId==null){
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->join('UserBundle:CompanyUsers', 'cu', 'with', 's.companyName = cu.companyname')
                ->where('cu.userId = :userObject ')
                ->setParameter('userObject', $userobject)
                ->getQuery()
                ->getResult();
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
        $typeofIncdientlist = $em->createQueryBuilder()
            ->select('ti.id', 'ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $hazardtypeList = $em->createQueryBuilder()
            ->select('ht.id', 'ht.hazardName')
            ->from('DashboardBundle:HazardType', 'ht')
            ->getQuery()
            ->getResult();
        if($reuseMode=="goToIncidentFirstInfo"){
            return array('vesselList' => $VesselList,'typeofIncidentList'=>$typeofIncdientlist,'hazardtypeList'=>$hazardtypeList);
        }
        if($reuseMode=="resettypeofIncdient"){
            return array('typeofIncidentList'=>$typeofIncdientlist);
        }
        if($reuseMode=='resethazardtype'){
            return array('hazardtypeList'=>$hazardtypeList);
        }
        $response = new Response($this->serialize(['vesselList' => $VesselList,'typeofIncidentList'=>$typeofIncdientlist,'hazardtypeList'=>$hazardtypeList]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Find all typecauselist for Company
     * @Rest\GET("/findallincidenttime",name="incident_listtypeofcaursefactorincident")
     */
    public function findalltypeofcausefactorincidentAction(Request $request,$mode="")
    {
        $em = $this->getDoctrine()->getManager();
        // Find typeofCauselist
        $typeofCauselist = $em->createQueryBuilder()
            ->select('tc.id', 'tc.causeName')
            ->from('DashboardBundle:TypeofCause', 'tc')
            ->getQuery()
            ->getResult();
        // Find operationattimeofIncidentList
        $operationattimeofIncidentList = $em->createQueryBuilder()
            ->select('oti.id', 'oti.timeofIncident')
            ->from('DashboardBundle:OperationattimeofIncident', 'oti')
            ->getQuery()
            ->getResult();
        // Find factortoIncidentList
        $factortoIncidentList = $em->createQueryBuilder()
            ->select('f.id', 'f.factorName')
            ->from('DashboardBundle:FactortoIncident', 'f')
            ->getQuery()
            ->getResult();
        if($mode=="gotocreateincidentDetail"){
            return array('factortoIncidentList' => $factortoIncidentList,'operationattimeofIncidentList'=>$operationattimeofIncidentList,'typeofCauselist'=>$typeofCauselist);

        }
        $response = new Response($this->serialize(['factortoIncidentList' => $factortoIncidentList,'operationattimeofIncidentList'=>$operationattimeofIncidentList,'typeofCauselist'=>$typeofCauselist]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Create New Incident
     * @Rest\Post("/createnewincident",name="createnewIcident")
     */
    public function createnewIcidentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $id=$request->request->get('id');
        $shipId = $request->request->get('shipId');
        $typeofIncidentId = $request->request->get('typeofIncident');
        $dateofIncident = $request->request->get('dateofIncident');
        $dateofIncidentreportMade = $request->request->get('dateofIncidentreportMade');
        $statusoftheReport = $request->request->get('statusofReport');
        $location = $request->request->get('location');
        $hazardtype=$request->request->get('hazardtype');
        $incidentDaylight=$request->request->get('incidentDaylight');
        $incidentatsea=$request->request->get('incidentatsea');
        $hazardtypeObject =$em->getRepository('DashboardBundle:HazardType')->findOneBy(array('id' =>  $hazardtype));
        $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  $shipId));
        $typeofIncidentObject =$em->getRepository('DashboardBundle:TypeofIncident')->findOneBy(array('id' =>  $typeofIncidentId));
        try{
            if($id==0){
                $findLastRecordofIncident = $em->createQueryBuilder()
                    ->select('i.incidentUId','i.id')
                    ->from('DashboardBundle:Incident', 'i')
                    ->setMaxResults(1)
                    ->addOrderBy('i.id', 'DESC')
                    ->getQuery()
                    ->getResult();
                $uniqueId="";
                if(count($findLastRecordofIncident)>0){
                    $tempUniqueId=$findLastRecordofIncident[0]['id'];
                    if($tempUniqueId==null){
                        $uniqueId="INC-000001";
                    }
                    else{
                        $integerValue=(int)$tempUniqueId+1;
                        $integerLength=strlen((string)$integerValue);
                        if($integerLength==1){
                            $uniqueId="INC-00000".(int)$integerValue;
                        }
                        elseif ($integerLength==2){
                            $uniqueId="INC-0000".(int)$integerValue;
                        }
                        elseif ($integerLength==3){
                            $uniqueId="INC-000".(int)$integerValue;
                        }
                        elseif ($integerLength==4){
                            $uniqueId="INC-00".(int)$integerValue;
                        }
                        elseif ($integerLength==5){
                            $uniqueId="INC-0".(int)$integerValue;
                        }
                        elseif ($integerLength==6){
                            $uniqueId=$integerValue;
                        }
                    }
                }
                else{
                    $uniqueId="INC-000001";
                }
                $incidentObject=new Incident();
                $incidentObject->setIncidentStatus(0);
                $incidentObject->setIncidentUId($uniqueId);
                $incidentObject->setUserId($userobject);
                $em->persist($incidentObject);
                $em->flush();
                $incidentFirstInfoObject=new IncidentFirstInfo();
                $incidentFirstInfoObject->setIncidentId($incidentObject);
                $incidentFirstInfoObject->setTypeofIncdientId($typeofIncidentObject);
                $incidentFirstInfoObject->setShipId($shipObject);
                $incidentFirstInfoObject->setHazardType($hazardtypeObject);
                if($incidentDaylight==1){
                    $incidentFirstInfoObject->setIncidentDaylight(true);
                }
                else{
                    $incidentFirstInfoObject->setIncidentDaylight(false);
                }
                if($incidentatsea==1){
                    $incidentFirstInfoObject->setIncidentatSea(true);
                }
                else{
                    $incidentFirstInfoObject->setIncidentatSea(false);
                }
                $incidentFirstInfoObject->setDateofIncident(new \DateTime($dateofIncident));
                if($dateofIncidentreportMade!="" &&$dateofIncidentreportMade!=null){
                    $incidentFirstInfoObject->setDateofIncidentreportMade(new \DateTime($dateofIncidentreportMade));
                }
                else{
                    $incidentFirstInfoObject->setDateofIncidentreportMade(null);
                }
                $incidentFirstInfoObject->setStatusofReport(1);
                $incidentFirstInfoObject->setLocation($location);
                $dataInsertionStartus=$em->persist($incidentFirstInfoObject);
                if($dataInsertionStartus==null){
                    $incidentObject->setIncidentStatus(1);
                    $em->flush();
                }

                $response = new Response($this->serialize([
                    'icidentId'=>$incidentObject->getId(),
                    'resmsg' => 'Incident FirstInfo create sucessfully!!!!',
                    'incidentFirstInfoId'=>$incidentFirstInfoObject->getId()
                ]), Response::HTTP_CREATED);
            }
            else{
                $incidnetFirstInfoObject = $this->getDoctrine()->getManager()->getRepository('DashboardBundle:IncidentFirstInfo')->findOneBy(array('id' =>  $id));
                //$incidnetFirstInfoObject->setIncidentId($incidentObject);
                if(count($incidnetFirstInfoObject)>0){
                    $dateofIncidentProviousValue=$incidnetFirstInfoObject->getDateofIncident();
                    $dateofIncidentreportMadePrviousValue=$incidnetFirstInfoObject->getDateofIncidentreportMade();
                    $incidentIdObject=$incidnetFirstInfoObject->getIncidentId();
                    if($dateofIncidentreportMade!="" &&$dateofIncidentreportMade!=null){
                        $dateofIncidentreportMadeDateObject=new \DateTime($dateofIncidentreportMade);
                    }
                    else{
                        $dateofIncidentreportMadeDateObject=null;
                    }
                    if($dateofIncident!="" && $dateofIncident!=null){
                        $dateofIncidentDateObject=new \DateTime($dateofIncident);
                    }
                    else{
                        $dateofIncidentDateObject=null;
                    }
                    $incidnetFirstInfoObject->setTypeofIncdientId($typeofIncidentObject);
                    $incidnetFirstInfoObject->setShipId($shipObject);
                    $incidnetFirstInfoObject->setDateofIncident($dateofIncidentDateObject);
                    $incidnetFirstInfoObject->setDateofIncidentreportMade($dateofIncidentreportMadeDateObject);
                    $incidnetFirstInfoObject->setLocation($location);
                    $incidnetFirstInfoObject->setHazardType($hazardtypeObject);
                    if($incidentDaylight==1){
                        $incidnetFirstInfoObject->setIncidentDaylight(true);
                    }
                    else{
                        $incidnetFirstInfoObject->setIncidentDaylight(false);
                    }
                    if($incidentatsea==1){
                        $incidnetFirstInfoObject->setIncidentatSea(true);
                    }
                    else{
                        $incidnetFirstInfoObject->setIncidentatSea(false);
                    }
                    $em->flush();
                    $findLastRecordofIncident = $em->createQueryBuilder()
                        ->select('i.incidentUId','i.id')
                        ->from('DashboardBundle:Incident', 'i')
                        ->join('DashboardBundle:IncidentFirstInfo', 'if','with', 'i.id = if.incidentId')
                        ->where('if.id = :firstInfoId ')
                        ->setParameter('firstInfoId', $incidnetFirstInfoObject->getId())
                        ->getQuery()
                        ->getResult();
                    if($dateofIncidentProviousValue!=$dateofIncidentDateObject || $dateofIncidentreportMadePrviousValue!=$dateofIncidentreportMadeDateObject){
                        if($dateofIncidentreportMadeDateObject!=null){
                            $timebetweenincidentandincidentmadeInterval = $dateofIncidentDateObject->diff($dateofIncidentreportMadeDateObject);
                            $timebetweenincidentandincidentmade=$timebetweenincidentandincidentmadeInterval->format('%m')." Months ".$timebetweenincidentandincidentmadeInterval->format('%d')." Days ". $timebetweenincidentandincidentmadeInterval->format('%h')." Hours ".$timebetweenincidentandincidentmadeInterval->format('%i')." Minutes";
                        }
                        else{
                            $timebetweenincidentandincidentmade=null;
                        }
                        $icidentcostObject = $em->getRepository('DashboardBundle:IncidentCost')->findOneBy(array('incidentId' =>  $findLastRecordofIncident[0]['id']));
                        if(count($icidentcostObject)!=null){
                            $icidentcostObject->setTimebetweenincidentandincidentmade($timebetweenincidentandincidentmade);
                            $em->flush();
                        }


                    }

                    $response = new Response($this->serialize([
                        'icidentId'=>$findLastRecordofIncident[0]['id'],
                        'resmsg' => 'Incident FirstInfo Update sucessfully!!!!',
                    ]), Response::HTTP_CREATED);
                }
                else{
                    $response = new Response($this->serialize([
                        'resmsg' => 'Incident Not Found!!!!',
                    ]), Response::HTTP_CREATED);
                }

            }
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create Incident Deatial for Particular Incident
     * @Rest\Post("/incidentDetail",name="addincidentDetail")
     */
    public function incidentDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $icidentDetailId=$request->request->get('id');
        $icidentId=$request->request->get('incidentId');
        $typeofCause = $request->request->get('typeofCause');
        $totalDemage = $request->request->get('totalDemage');
        $rcaRequired = $request->request->get('rcaRequired');
        $operationattimeofIncident = $request->request->get('operationattimeofIncident');
        $factortoIncident = $request->request->get('factortoIncident');
        $incidentDescription = $request->request->get('incidentDescription');
        $immediateAction= $request->request->get('immediateAction');
        $followupAction = $request->request->get('followupAction');

        try{

            $icidentObject = $this->getDoctrine()->getManager()->getRepository('DashboardBundle:Incident')->findOneBy(array('id' =>  $icidentId));
            $factortoIncidentObject = $this->getDoctrine()->getManager()->getRepository('DashboardBundle:FactortoIncident')->findOneBy(array('id' =>  $factortoIncident));
            $typeofCauseObject = $this->getDoctrine()->getManager()->getRepository('DashboardBundle:TypeofCause')->findOneBy(array('id' =>  $typeofCause));
            $operationattimeofIncidentObject = $this->getDoctrine()->getManager()->getRepository('DashboardBundle:OperationattimeofIncident')->findOneBy(array('id' =>  $operationattimeofIncident));
            if($icidentDetailId==0){
                $incidentDetailObject=new IncidentDetails();
                $incidentDetailObject->setIncidentId($icidentObject);
                $incidentDetailObject->setRcaRequired($rcaRequired);
                $incidentDetailObject->setIncidentDescription($incidentDescription);
                $incidentDetailObject->setImmediateAction($immediateAction);
                $incidentDetailObject->setFollowupAction($followupAction);
                $incidentDetailObject->setTotalDemage($totalDemage);
                $incidentDetailObject->setFactortoIncident($factortoIncidentObject);
                $incidentDetailObject->setTypeofCause($typeofCauseObject);
                $incidentDetailObject->setOperationattimeofIncident($operationattimeofIncidentObject);
                $em->persist($incidentDetailObject);
                if($icidentObject!=null ){
                    $icidentObject->setIncidentStatus(2);
                    $em->flush();
                }
                $response = new Response($this->serialize([
                    'icidentId'=>$icidentId,'incidentDetailsId'=>$incidentDetailObject->getId(),
                    'resmsg' => 'Incident create sucessfully!!!!'
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            else{
                $incidneDetailObject = $this->getDoctrine()->getManager()->getRepository('DashboardBundle:IncidentDetails')->findOneBy(array('id' =>$icidentDetailId));
                if(count($incidneDetailObject)>0){
                    $incidneDetailObject->setRcaRequired($rcaRequired);
                    $incidneDetailObject->setIncidentDescription($incidentDescription);
                    $incidneDetailObject->setImmediateAction($immediateAction);
                    $incidneDetailObject->setFollowupAction($followupAction);
                    $incidneDetailObject->setTotalDemage($totalDemage);
                    $incidneDetailObject->setFactortoIncident($factortoIncidentObject);
                    $incidneDetailObject->setTypeofCause($typeofCauseObject);
                    $incidneDetailObject->setOperationattimeofIncident($operationattimeofIncidentObject);
                    $em->flush();
                    $response = new Response($this->serialize([
                        'icidentId'=>$icidentId,
                        'resmsg' => 'Incident Detail Updated!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }
                else{
                    $response = new Response($this->serialize([
                        'icidentId'=>$icidentId,
                        'resmsg' => 'Incident Not Found'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);

                }

            }
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create Cost Deatial for Particular Incident
     * @Rest\Post("/addCostDetails",name="addCostDetail")
     */
    public function addCostDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $costId=$request->request->get('id');
        $icidentId=$request->request->get('incidentId');
        $incidentReportFinalCost = $request->request->get('incidentReportFinalCost');
        $offHireDays = $request->request->get('offHireDays');
        $managersCostUSD = $request->request->get('managersCostUSD');
        $ownersCostUSD = $request->request->get('ownersCostUSD');
        $incidentFinalCostUSD = $request->request->get('incidentFinalCostUSD');
        $dateReportsenttoowners= $request->request->get('dateReportsenttoowners');
        $incidentClosedbyOwners = $request->request->get('incidentClosedbyOwners');
        try{
            if($costId==0){
                $icidentFirstInfoObject = $em->getRepository('DashboardBundle:IncidentFirstInfo')->findOneBy(array('incidentId' =>  $icidentId));
                $icidentObject = $em->getRepository('DashboardBundle:Incident')->findOneBy(array('id' =>  $icidentId));
                $incidentCostObject=new IncidentCost();
                $incidentCostObject->setIncidentId($icidentObject);
                $incidentCostObject->setIncidentClosedbyOwners($incidentClosedbyOwners);
                $dateofIncident=$icidentFirstInfoObject->getDateofIncident();
                $dateofIncidentReportMade=$icidentFirstInfoObject->getDateofIncidentreportMade();
                if($dateofIncidentReportMade!=null && $dateofIncidentReportMade=""){
                    // Time between Two Dates
                    $timebetweenincidentandincidentmadeInterval = $dateofIncident->diff($dateofIncidentReportMade);
                    $timebetweenincidentandincidentmade= $timebetweenincidentandincidentmadeInterval->format('%m')." Months ".$timebetweenincidentandincidentmadeInterval->format('%d')." Days ".$timebetweenincidentandincidentmadeInterval->format('%h')." Hours ".$timebetweenincidentandincidentmadeInterval->format('%i')." Minutes";
                    //end time between two dates
                    $incidentCostObject->setTimebetweenincidentandincidentmade($timebetweenincidentandincidentmade);
                }
                else{
                    $incidentCostObject->setTimebetweenincidentandincidentmade(null);
                }
                if($dateReportsenttoowners!=null && $dateReportsenttoowners!=""){
                    $datereportsendtoowners = new \DateTime($dateReportsenttoowners);
                    if($dateofIncidentReportMade!=null &&$dateofIncidentReportMade!=""){
                        $timebettweenincidentreportmadeandsendtoowensInterVal=$dateofIncidentReportMade->diff($datereportsendtoowners);
                        $timebettweenincidentreportmadeandsendtoowens= $timebettweenincidentreportmadeandsendtoowensInterVal->format('%m')." Months ".$timebettweenincidentreportmadeandsendtoowensInterVal->format('%d')." Days ".$timebettweenincidentreportmadeandsendtoowensInterVal->format('%h')." Hours ".$timebettweenincidentreportmadeandsendtoowensInterVal->format('%i')." Minutes";
                        $incidentCostObject->setDateReportsenttoowners($datereportsendtoowners);
                        $incidentCostObject->setTimebetweenincidentreportmadeandreportsendtoowners($timebettweenincidentreportmadeandsendtoowens);
                    }
                    else{
                        $incidentCostObject->setDateReportsenttoowners($datereportsendtoowners);
                        $incidentCostObject->setTimebetweenincidentreportmadeandreportsendtoowners(null);
                    }

                }
                else
                {
                    $incidentCostObject->setDateReportsenttoowners(null);
                    $incidentCostObject->setTimebetweenincidentreportmadeandreportsendtoowners(null);
                }
                $incidentCostObject->setManagersCostUSD($managersCostUSD);
                $incidentCostObject->setOffHireDays($offHireDays);
                $incidentCostObject->setOwnersCostUSD($ownersCostUSD);
                $incidentCostObject->setIncidentFinalCostUSD($incidentFinalCostUSD);
                $incidentCostObject->setIncidentReportFinalCost($incidentReportFinalCost);
                $em->persist($incidentCostObject);
                if($icidentObject!=null ){
                    $icidentObject->setIncidentStatus(3);
                    $em->flush();
                }
                $response = new Response($this->serialize([
                    'icidentId'=>$icidentId,'costDetailId'=>$incidentCostObject->getId(),
                    'resmsg' => 'Incident create sucessfully!!!!'
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            else{
                $icidentcostObject = $em->getRepository('DashboardBundle:IncidentCost')->findOneBy(array('id' =>  $costId));
                if(count($icidentcostObject)==1){

                    $icidentFirstInfoObject = $em->getRepository('DashboardBundle:IncidentFirstInfo')->findOneBy(array('incidentId' =>  $icidentcostObject->getIncidentId()));
                    $dateofIncidentReportMade=$icidentFirstInfoObject->getDateofIncidentreportMade();
                    if($dateofIncidentReportMade!=null){
                        if($dateReportsenttoowners!=null &&$dateReportsenttoowners!=""){
                            $timebettweenincidentreportmadeandsendtoowensInterval=$dateofIncidentReportMade->diff(new \DateTime($dateReportsenttoowners));
                            $timebettweenincidentreportmadeandsendtoowens= $timebettweenincidentreportmadeandsendtoowensInterval->format('%m')." Month ".$timebettweenincidentreportmadeandsendtoowensInterval->format('%d')." Day ".$timebettweenincidentreportmadeandsendtoowensInterval->format('%h')." Hours ".$timebettweenincidentreportmadeandsendtoowensInterval->format('%i')." Minutes";
                            $icidentcostObject->setTimebetweenincidentreportmadeandreportsendtoowners($timebettweenincidentreportmadeandsendtoowens);
                            $icidentcostObject->setDateReportsenttoowners(new \DateTime($dateReportsenttoowners));
                        }
                        else{
                            $icidentcostObject->setTimebetweenincidentreportmadeandreportsendtoowners(null);
                            $icidentcostObject->setDateReportsenttoowners(null);
                        }

                    }
                    else{
                        $icidentcostObject->setTimebetweenincidentreportmadeandreportsendtoowners(null);
                        $icidentcostObject->setDateReportsenttoowners(null);
                    }
                    $icidentcostObject->setIncidentClosedbyOwners($incidentClosedbyOwners);
                    $icidentcostObject->setManagersCostUSD($managersCostUSD);
                    $icidentcostObject->setOffHireDays($offHireDays);
                    $icidentcostObject->setOwnersCostUSD($ownersCostUSD);
                    $icidentcostObject->setIncidentFinalCostUSD($incidentFinalCostUSD);
                    $icidentcostObject->setIncidentReportFinalCost($incidentReportFinalCost);
                    $em->flush();
                    $response = new Response($this->serialize([
                        'icidentId'=>$icidentId,
                        'resmsg' => 'Incident Cost Detail Updated!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }
                else if(count($icidentcostObject)>=0){
                    $response = new Response($this->serialize([
                        'resmsg' => 'Incident Cost Detail Not Found!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }
            }
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create Cost Deatial for Particular Incident
     * @Rest\Post("/addOperatorWetherDetail",name="addOperatorWetherDetail")
     */
    public function addOperatorWetherDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $operator_whetherId=$request->request->get('id');
        $icidentId=$request->request->get('incidentId');
        $whether = $request->request->get('whether');
        $waterCondition = $request->request->get('water');
        $wind = $request->request->get('wind');
        $windDirection= $request->request->get('windDirection');
        $visiblity = $request->request->get('visiblity');
        $tide = $request->request->get('tide');
        $operator_sure_name= $request->request->get('operator_sure_name');
        $operator_given_name = $request->request->get('operator_given_name');
        $operator_dob = $request->request->get('operator_dob');
        $operator_address = $request->request->get('operator_address');
        $operator_mobile = $request->request->get('operator_mobile');
        $operator_landline = $request->request->get('operator_landline');
        $operator_email= $request->request->get('operator_email');
        $operator_LicenseType= $request->request->get('operator_LicenseType');
        $operator_LicenseNumber= $request->request->get('operator_LicenseNumber');
        try{
            if($operator_whetherId==0)
            {
                $icidentObject = $em->getRepository('DashboardBundle:Incident')->findOneBy(array('id' =>  $icidentId));
                $incidentOperatorWeatherObject=new IncidentOperatorWeather();
                $incidentOperatorWeatherObject->setIncidentId($icidentObject);
                $incidentOperatorWeatherObject->setWhether($whether);
                $incidentOperatorWeatherObject->setWater($waterCondition);
                $incidentOperatorWeatherObject->setWind($wind);
                $incidentOperatorWeatherObject->setWindDirection($windDirection);
                $incidentOperatorWeatherObject->setVisiblity($visiblity);
                $incidentOperatorWeatherObject->setTide($tide);
                $incidentOperatorWeatherObject->setOperatorGivenName($operator_given_name);
                $incidentOperatorWeatherObject->setOperatorSureName($operator_sure_name);
                $incidentOperatorWeatherObject->setOperatorDob(new \DateTime($operator_dob));
                $incidentOperatorWeatherObject->setOperatorAddress($operator_address);
                $incidentOperatorWeatherObject->setOperatorMobile($operator_mobile);
                $incidentOperatorWeatherObject->setOperatorLandline($operator_landline);
                $incidentOperatorWeatherObject->setOperatorEmail($operator_email);
                $incidentOperatorWeatherObject->setOperatorLicenseType($operator_LicenseType);
                $incidentOperatorWeatherObject->setOperatorLicenseNumber($operator_LicenseNumber);
                $em->persist($incidentOperatorWeatherObject);
                if($icidentObject!=null ){
                    $icidentObject->setIncidentStatus(4);
                    $em->flush();
                }
                $response = new Response($this->serialize([
                    'icidentId'=>$icidentId,'operatorWhetherId'=>$incidentOperatorWeatherObject->getId(),
                    'resmsg' => 'Incident create sucessfully!!!!'
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            else{
                $icidentoperaterWheatherObject = $em->getRepository('DashboardBundle:IncidentOperatorWeather')->findOneBy(array('id' =>  $operator_whetherId));
                if(count($icidentoperaterWheatherObject)==1){
                    $icidentoperaterWheatherObject->setWhether($whether);
                    $icidentoperaterWheatherObject->setWater($waterCondition);
                    $icidentoperaterWheatherObject->setWind($wind);
                    $icidentoperaterWheatherObject->setWindDirection($windDirection);
                    $icidentoperaterWheatherObject->setVisiblity($visiblity);
                    $icidentoperaterWheatherObject->setTide($tide);
                    $icidentoperaterWheatherObject->setOperatorGivenName($operator_given_name);
                    $icidentoperaterWheatherObject->setOperatorSureName($operator_sure_name);
                    $icidentoperaterWheatherObject->setOperatorDob(new \DateTime($operator_dob));
                    $icidentoperaterWheatherObject->setOperatorAddress($operator_address);
                    $icidentoperaterWheatherObject->setOperatorMobile($operator_mobile);
                    $icidentoperaterWheatherObject->setOperatorLandline($operator_landline);
                    $icidentoperaterWheatherObject->setOperatorEmail($operator_email);
                    $icidentoperaterWheatherObject->setOperatorLicenseType($operator_LicenseType);
                    $icidentoperaterWheatherObject->setOperatorLicenseNumber($operator_LicenseNumber);
                    $em->flush();
                    $response = new Response($this->serialize([
                        'resmsg' => 'Incident Operator Whether Detail Updated!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }else{
                    $response = new Response($this->serialize([
                        'resmsg' => 'Incident Not Found!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }

            }
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create Cost Deatial for Particular Incident
     * @Rest\Post("/addincident_stat_Details",name="addincident_stat_Details")
     */
    public function addstatdataDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incident_stat_DetailsId=$request->request->get('id');
        $icidentId=$request->request->get('incidentId');
        $stat_data_option = $request->request->get('stat_data_option');
        $dutyStatus = $request->request->get('dutyStatus');
        $rankStatus = $request->request->get('rankStatus');
        $typeofInjury= $request->request->get('typeofInjury');
        $typeofAccident = $request->request->get('typeofAccident');
        $placeofAccident = $request->request->get('placeofAccident');
        $bodyareaAffected= $request->request->get('bodyareaAffected');
        $shipoperation = $request->request->get('shipoperation');
        $primaryequimentdemage = $request->request->get('primaryequimentdemage');
        $demagepart = $request->request->get('demagepart');
        $demagethirdparty = $request->request->get('demagethirdparty');
        $detailsofincident = $request->request->get('detailsofincident');
        $demagedrug_alcohol= $request->request->get('demagedrug_alcohol');
        $spills_sea_liter= $request->request->get('spills_sea_liter');
        $spills_sea_pol_cate= $request->request->get('spills_sea_pol_cate');
        $spills_sea_pol_cate_other= $request->request->get('spills_sea_pol_cate_other');
        $spills_contain_liter= $request->request->get('spills_contain_liter');
        $spills_contain_pol_cate= $request->request->get('spills_contain_pol_cate');
        $spills_contain_liter_other= $request->request->get('spills_contain_liter_other');
        try{
            if($incident_stat_DetailsId==0)
            {
                $icidentObject = $em->getRepository('DashboardBundle:Incident')->findOneBy(array('id' =>  $icidentId));
                $incident_sta_Object=new IncidentStatisticsData();
                $incident_sta_Object->setIncidentId($icidentObject);
                $incident_sta_Object->setDutyStatus($dutyStatus);
                $incident_sta_Object->setRankStatus($rankStatus);
                $incident_sta_Object->setTypeofStatData($stat_data_option);
                $incident_sta_Object->setTypeofInjury($typeofInjury);
                $incident_sta_Object->setTypeofAccident($typeofAccident);
                $incident_sta_Object->setPlaceofAccident($placeofAccident);
                $incident_sta_Object->setBodyareaAffected($bodyareaAffected);
                $incident_sta_Object->setShipoperation($shipoperation);
                $incident_sta_Object->setPrimaryequimentdemage($primaryequimentdemage);
                $incident_sta_Object->setDemagepart($demagepart);
                $incident_sta_Object->setDemagethirdparty($demagethirdparty);
                $incident_sta_Object->setDetailsofincident($detailsofincident);
                $incident_sta_Object->setDemagedrugAlcohol($demagedrug_alcohol);
                $incident_sta_Object->setSpillsSeaLiter($spills_sea_liter);
                $incident_sta_Object->setSpillsSeaPolCate($spills_sea_pol_cate);
                $incident_sta_Object->setSpillsSeaPolCateOther($spills_sea_pol_cate_other);
                $incident_sta_Object->setSpillsContainLiter($spills_contain_liter);
                $incident_sta_Object->setSpillsContainPolCate($spills_contain_pol_cate);
                $incident_sta_Object->setSpillsContainLiterOther($spills_contain_liter_other);
                $em->persist($incident_sta_Object);
                if($icidentObject!=null ){
                    $icidentObject->setIncidentStatus(3);
                    $em->flush();
                }
                $response = new Response($this->serialize([
                    'icidentId'=>$icidentId,'incident_stat_Id'=>$incident_sta_Object->getId(),
                    'resmsg' => 'Statistics Data sucessfully!!!!'
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            else{
                $incident_sta_Object = $em->getRepository('DashboardBundle:IncidentStatisticsData')->findOneBy(array('id' =>  $incident_stat_DetailsId));
                if(count($incident_sta_Object)==1){
                    $incident_sta_Object->setDutyStatus($dutyStatus);
                    $incident_sta_Object->setRankStatus($rankStatus);
                    $incident_sta_Object->setTypeofStatData($stat_data_option);
                    $incident_sta_Object->setTypeofInjury($typeofInjury);
                    $incident_sta_Object->setTypeofAccident($typeofAccident);
                    $incident_sta_Object->setPlaceofAccident($placeofAccident);
                    $incident_sta_Object->setBodyareaAffected($bodyareaAffected);
                    $incident_sta_Object->setShipoperation($shipoperation);
                    $incident_sta_Object->setPrimaryequimentdemage($primaryequimentdemage);
                    $incident_sta_Object->setDemagepart($demagepart);
                    $incident_sta_Object->setDemagethirdparty($demagethirdparty);
                    $incident_sta_Object->setDetailsofincident($detailsofincident);
                    $incident_sta_Object->setDemagedrugAlcohol($demagedrug_alcohol);
                    $incident_sta_Object->setSpillsSeaLiter($spills_sea_liter);
                    $incident_sta_Object->setSpillsSeaPolCate($spills_sea_pol_cate);
                    $incident_sta_Object->setSpillsSeaPolCateOther($spills_sea_pol_cate_other);
                    $incident_sta_Object->setSpillsContainLiter($spills_contain_liter);
                    $incident_sta_Object->setSpillsContainPolCate($spills_contain_pol_cate);
                    $incident_sta_Object->setSpillsContainLiterOther($spills_contain_liter_other);
                    $em->flush();
                    $response = new Response($this->serialize([
                        'resmsg' => 'Incident Statistics Data Updated!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }else{
                    $response = new Response($this->serialize([
                        'resmsg' => 'Incident Not Found!!!!'
                    ]), Response::HTTP_CREATED);
                    return $this->setBaseHeaders($response);
                }

            }
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create Type of Cause
     * @Rest\Post("/addTypeofCause",name="addTypeofCause")
     */
    public function addTypeofCauseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $typeofcauseName= $request->request->get('typeofcauseName');
        $severityClassification = $request->request->get('severityClassification');
        try{
            $typeofCauseObject=new TypeofCause();
            $typeofCauseObject->setCauseName($typeofcauseName);
            $typeofCauseObject->setSeverityClassification($severityClassification);
            $em->persist($typeofCauseObject);
            $em->flush();
            $typeofCauselist = $em->createQueryBuilder()
                ->select('tc.id', 'tc.causeName')
                ->from('DashboardBundle:TypeofCause', 'tc')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Type of Cause create sucessfully!!!!','typeofcauseList'=>$typeofCauselist
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create Type of Cause
     * @Rest\Post("/addoperationattheTimeofIncident",name="addoperationattheTimeofIncident")
     */
    public function operationattheTimeofIncidentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $timeofIncident= $request->request->get('timeofIncident');
        try{
            $timeofIncidentObject=new OperationattimeofIncident();
            $timeofIncidentObject->setTimeofIncident($timeofIncident);
            $em->persist($timeofIncidentObject);
            $em->flush();
            $operationattimeofIncidentList = $em->createQueryBuilder()
                ->select('oti.id', 'oti.timeofIncident')
                ->from('DashboardBundle:OperationattimeofIncident', 'oti')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Time of Incident create sucessfully!!!!','timeofIncidentList'=>$operationattimeofIncidentList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create goToIncidentFirstInfo
     * @Rest\Post("/goToIncidentFirstInfo",name="goToIncidentFirstInfo")
     */
    public function goToIncidentFirstInfoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incidentId= $request->request->get('incidentId');
        try{
            $firstInfoDetails = $em->createQueryBuilder()
                ->select('if.id','s.id as shipId','ti.id as typeofIncidentId',
                    'ht.id as hazardtypeid','if.incidentDaylight','if.incidentatSea',
                    'if.dateofIncident','if.dateofIncidentreportMade',
                    'if.statusofReport','if.location')
                ->from('DashboardBundle:IncidentFirstInfo', 'if')
                ->join('VesselBundle:Shipdetails', 's', 'with', 's.id = if.shipId')
                ->join('DashboardBundle:TypeofIncident', 'ti', 'with', 'ti.id = if.typeofIncdientId')
                ->join('DashboardBundle:HazardType', 'ht', 'with', 'ht.id = if.hazardType')
                ->join('DashboardBundle:Incident', 'i', 'with', 'i.id = if.incidentId')
                ->where('if.incidentId = :incidentId ')
                ->setParameter('incidentId', $incidentId)
                ->getQuery()
                ->getResult();
            $shipandtypeofIncident = $this->findallshipsAction($request, 'goToIncidentFirstInfo');
            $response = new Response($this->serialize([
                'firstInfoDetails' =>$firstInfoDetails,'vesselList'=>$shipandtypeofIncident['vesselList'],
                'typeofIncidentList'=>$shipandtypeofIncident['typeofIncidentList'],
                'hazardtypeList'=>$shipandtypeofIncident['hazardtypeList']
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create gotocreateincidentDetail
     * @Rest\Post("/gotocreateincidentDetail",name="gotocreateincidentDetail")
     */
    public function gotocreateincidentDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incidentId= $request->request->get('incidentId');
        try{
            $incdientDetails = $em->createQueryBuilder()
                ->select('ide.id','oti.id as operationattimeofIncident','tc.id as typeofcasueId','i.id as incidentId','ft.id as factorIncidentId', 'ide.totalDemage','ide.rcaRequired','ide.incidentDescription','ide.immediateAction','ide.followupAction')
                ->from('DashboardBundle:IncidentDetails', 'ide')
                ->join('DashboardBundle:OperationattimeofIncident', 'oti', 'with', 'oti.id = ide.operationattimeofIncident')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'tc.id = ide.typeofCause')
                ->join('DashboardBundle:Incident', 'i', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:FactortoIncident', 'ft', 'with', 'ft.id = ide.factortoIncident')
                ->where('ide.incidentId = :incidentId ')
                ->setParameter('incidentId', $incidentId)
                ->getQuery()
                ->getResult();
            $shipandtypeofIncident = $this->findalltypeofcausefactorincidentAction($request, 'gotocreateincidentDetail');
            if(count($incdientDetails)==1){
                $response = new Response($this->serialize([
                    'incdientDetails' =>$incdientDetails,'factortoIncidentList' => $shipandtypeofIncident['factortoIncidentList'],
                    'operationattimeofIncidentList'=>$shipandtypeofIncident['operationattimeofIncidentList'],
                    'typeofCauselist'=>$shipandtypeofIncident['typeofCauselist']
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            elseif (count($incdientDetails)<=0){
                $response = new Response($this->serialize([
                    'incdientDetails' =>0,'factortoIncidentList' => $shipandtypeofIncident['factortoIncidentList'],
                    'operationattimeofIncidentList'=>$shipandtypeofIncident['operationattimeofIncidentList'],
                    'typeofCauselist'=>$shipandtypeofIncident['typeofCauselist']
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);

            }

        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }

    /**
     * gotoCreateCostDetail
     * @Rest\Post("/gotoCreateCostDetail",name="gotoCreateCostDetail")
     */
    public function gotoCreateCostDetailAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incidentId= $request->request->get('incidentId');
        try{
            $costDetails = $em->createQueryBuilder()
                ->select('ic.id','i.id as incidentId', 'ic.incidentReportFinalCost','ic.offHireDays',
                    'ic.managersCostUSD','ic.ownersCostUSD','ic.incidentFinalCostUSD','ic.timebetweenincidentandincidentmade',
                    'ic.dateReportsenttoowners','ic.timebetweenincidentreportmadeandreportsendtoowners',
                    'ic.incidentClosedbyOwners')
                ->from('DashboardBundle:IncidentCost', 'ic')
                ->join('DashboardBundle:Incident', 'i', 'with', 'i.id = ic.incidentId')
                ->where('ic.incidentId = :incidentId ')
                ->setParameter('incidentId', $incidentId)
                ->getQuery()
                ->getResult();
            if(count($costDetails)==1){
                $response = new Response($this->serialize([
                    'costDetailsList' =>$costDetails
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            elseif (count($costDetails)<=0){
                $response = new Response($this->serialize([
                    'costDetailsList' =>0
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);

            }

        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * gotocreateOperatorWhetherDetails
     * @Rest\Post("/gotocreateOperatorWhetherDetails",name="gotocreateOperatorWhetherDetails")
     */
    public function gotocreateOperatorWhetherDetailsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incidentId= $request->request->get('incidentId');
        try{
            $operatorwhetherDetails = $em->createQueryBuilder()
                ->select('ip.id','i.id as incidentId','i.incidentStatus', 'ip.whether','ip.water',
                    'ip.wind','ip.windDirection','ip.visiblity','ip.tide',
                    'ip.operator_sure_name','ip.operator_given_name',
                    'ip.operator_dob','ip.operator_address','ip.operator_mobile','ip.operator_landline',
                    'ip.operator_email','ip.operator_LicenseType','ip.operator_LicenseNumber')
                ->from('DashboardBundle:IncidentOperatorWeather', 'ip')
                ->join('DashboardBundle:Incident', 'i', 'with', 'i.id = ip.incidentId')
                ->where('ip.incidentId = :incidentId ')
                ->setParameter('incidentId', $incidentId)
                ->getQuery()
                ->getResult();
            if(count($operatorwhetherDetails)==1){
                $response = new Response($this->serialize([
                    'operatorwhetherDetails' =>$operatorwhetherDetails
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            elseif (count($operatorwhetherDetails)<=0){
                $response = new Response($this->serialize([
                    'operatorwhetherDetails' =>0
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);

            }

        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create factortoIncidentmodel
     * @Rest\Post("/addfactortoIncidentmodel",name="addfactortoIncidentmodel")
     */
    public function factortoIncidentmodelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $factorName= $request->request->get('factorName');
        try{
            $factortoIncidentObject=new FactortoIncident();
            $factortoIncidentObject->setFactorName($factorName);
            $em->persist($factortoIncidentObject);
            $em->flush();
            $factortoIncidentList = $em->createQueryBuilder()
                ->select('f.id', 'f.factorName')
                ->from('DashboardBundle:FactortoIncident', 'f')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Factor to Incident create sucessfully!!!!','factortoincidentList'=>$factortoIncidentList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create addTypeofIncident
     * @Rest\Post("/addTypeofIncident",name="addTypeofIncident")
     */
    public function addTypeofIncidentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $typeIncidentName= $request->request->get('typeIncidentName');
        try{
            $factortoIncidentObject=new TypeofIncident();
            $factortoIncidentObject->setIncidentName($typeIncidentName);
            $em->persist($factortoIncidentObject);
            $em->flush();
            $typeofIncidentList=$this->findallshipsAction($request,'resettypeofIncdient');
            $response = new Response($this->serialize([
                'resmsg' => 'Type of Incident create sucessfully!!!!','typeofIncidentList'=>$typeofIncidentList['typeofIncidentList']
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create addhazardtype
     * @Rest\Post("/addhazardtype",name="addhazardtype")
     */
    public function addhazardtypeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $hazardName= $request->request->get('hazardName');
        try{
            $factortoIncidentObject=new HazardType();
            $factortoIncidentObject->setHazardName($hazardName);
            $em->persist($factortoIncidentObject);
            $em->flush();
            $hazardtypeList=$this->findallshipsAction($request,'resethazardtype');
            $response = new Response($this->serialize([
                'resmsg' => 'Type of Incident create sucessfully!!!!','hazardtypeList'=>$hazardtypeList['hazardtypeList']
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create addTypeofAccident
     * @Rest\Post("/addTypeofInjury",name="addTypeofInjury")
     */
    public function addTypeofInjuryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $injuryName= $request->request->get('injuryName');
        try{
            $typeofInjuryObject=new TypeofInjury();
            $typeofInjuryObject->setInjuryName($injuryName);
            $em->persist($typeofInjuryObject);
            $em->flush();
            $typeofInjuryList = $em->createQueryBuilder()
                ->select('ti.id', 'ti.injuryName')
                ->from('DashboardBundle:TypeofInjury', 'ti')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Factor to Incident create sucessfully!!!!',
                'typeofInjuryList'=>$typeofInjuryList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create addTypeofAccident
     * @Rest\Post("/addTypeofAccident",name="addTypeofAccident")
     */
    public function addTypeofAccidentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $accidentName= $request->request->get('accidentName');
        try{
            $typeofAccidentObject=new TypeofAccident();
            $typeofAccidentObject->setAccidentName($accidentName);
            $em->persist($typeofAccidentObject);
            $em->flush();
            $typeofAccidentList=$em->createQueryBuilder()
                ->select('ta.id', 'ta.accidentName')
                ->from('DashboardBundle:TypeofAccident', 'ta')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Factor to Incident create sucessfully!!!!',
                'typeofAccidentList'=>$typeofAccidentList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create addTypeofAccident
     * @Rest\Post("/addPlaceofAccident",name="addPlaceofAccident")
     */
    public function addPlaceofAccidentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $placeName= $request->request->get('placeName');
        try{
            $placeofAccidentObject=new PlaceofAccident();
            $placeofAccidentObject->setPlaceName($placeName);
            $em->persist($placeofAccidentObject);
            $em->flush();
            $placeofAccidentList=$em->createQueryBuilder()
                ->select('pa.id', 'pa.placeName')
                ->from('DashboardBundle:PlaceofAccident', 'pa')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Factor to Incident create sucessfully!!!!',
                'placeofAccidentList'=>$placeofAccidentList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create  addBodyAreasAffected
     * @Rest\Post("/addBodyAreasAffected",name="addBodyAreasAffected")
     */
    public function addBodyAreasAffectedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $bodyareaAffectedname= $request->request->get('bodyareaAffectedname');
        try{
            $bodyAreasAffectedObject=new BodyAreasAffected();
            $bodyAreasAffectedObject->setBodyareaAffectedname($bodyareaAffectedname);
            $em->persist($bodyAreasAffectedObject);
            $em->flush();
            $bodyAreasAffectedList=$em->createQueryBuilder()
                ->select('pa.id', 'pa.bodyareaAffectedname')
                ->from('DashboardBundle:BodyAreasAffected', 'pa')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Factor to Incident create sucessfully!!!!',
                'bodyAreasAffectedList'=>$bodyAreasAffectedList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create  addshipOperation
     * @Rest\Post("/addshipOperation",name="addshipOperation")
     */
    public function addshipOperationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $operationname= $request->request->get('operationname');
        try{
            $shipOperationObject=new ShipOperation();
            $shipOperationObject->setOperationname($operationname);
            $em->persist($shipOperationObject);
            $em->flush();
            $shipOperationList=$em->createQueryBuilder()
                ->select('so.id', 'so.operationname')
                ->from('DashboardBundle:ShipOperation', 'so')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Ship Operation create sucessfully!!!!',
                'shipOperationList'=>$shipOperationList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create  addseaPollutionCategory
     * @Rest\Post("/addseaPollutionCategory",name="addseaPollutionCategory")
     */
    public function addseaPollutionCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $sea_pol_name= $request->request->get('sea_pol_name');
        try{
            $sea_pol_cat_Object=new SeaPollutionCategory();
            $sea_pol_cat_Object->setSeaPolName($sea_pol_name);
            $em->persist($sea_pol_cat_Object);
            $em->flush();
            $seaPollutionCategoryList=$em->createQueryBuilder()
                ->select('spc.id', 'spc.sea_pol_name')
                ->from('DashboardBundle:SeaPollutionCategory', 'spc')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Ship Operation create sucessfully!!!!',
                'seaPollutionCategoryList'=>$seaPollutionCategoryList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create  addContainerPollutionCategory
     * @Rest\Post("/addContainerPollutionCategory",name="addContainerPollutionCategory")
     */
    public function addContainerPollutionCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $con_pol_name= $request->request->get('con_pol_name');
        try{
            $con_Pop_Object=new ContainerPollutionCategory();
            $con_Pop_Object->setConPolName($con_pol_name);
            $em->persist($con_Pop_Object);
            $em->flush();
            $conPollutionCategoryList=$em->createQueryBuilder()
                ->select('cpc.id', 'cpc.con_pol_name')
                ->from('DashboardBundle:ContainerPollutionCategory', 'cpc')
                ->getQuery()
                ->getResult();
            $response = new Response($this->serialize([
                'resmsg' => 'Ship Operation create sucessfully!!!!',
                'conPollutionCategoryList'=>$conPollutionCategoryList
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Create  getalldropdownstatdata
     * @Rest\Get("/getalldropdownstatdata",name="getalldropdownstatdata")
     */
    public function getalldropdownstatdataAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        try{
            $conPollutionCategoryList=$em->createQueryBuilder()
                ->select('cpc.id', 'cpc.con_pol_name')
                ->from('DashboardBundle:ContainerPollutionCategory', 'cpc')
                ->getQuery()
                ->getResult();
            $seaPollutionCategoryList=$em->createQueryBuilder()
                ->select('spc.id', 'spc.sea_pol_name')
                ->from('DashboardBundle:SeaPollutionCategory', 'spc')
                ->getQuery()
                ->getResult();
            $shipOperationList=$em->createQueryBuilder()
                ->select('so.id', 'so.operationname')
                ->from('DashboardBundle:ShipOperation', 'so')
                ->getQuery()
                ->getResult();
            $bodyAreasAffectedList=$em->createQueryBuilder()
                ->select('pa.id', 'pa.bodyareaAffectedname')
                ->from('DashboardBundle:BodyAreasAffected', 'pa')
                ->getQuery()
                ->getResult();
            $placeofAccidentList=$em->createQueryBuilder()
                ->select('pa.id', 'pa.placeName')
                ->from('DashboardBundle:PlaceofAccident', 'pa')
                ->getQuery()
                ->getResult();
            $typeofInjuryList = $em->createQueryBuilder()
                ->select('ti.id', 'ti.injuryName')
                ->from('DashboardBundle:TypeofInjury', 'ti')
                ->getQuery()
                ->getResult();
            $typeofAccidentList=$em->createQueryBuilder()
                ->select('ta.id', 'ta.accidentName')
                ->from('DashboardBundle:TypeofAccident', 'ta')
                ->getQuery()
                ->getResult();
            if($requestMode=='gotoaddstat_data'){
                return array(
                    'typeofAccidentList'=>$typeofAccidentList,
                    'typeofInjuryList'=>$typeofInjuryList,
                    'placeofAccidentList'=>$placeofAccidentList,
                    'bodyAreasAffectedList'=>$bodyAreasAffectedList,
                    'shipOperationList'=>$shipOperationList,
                    'seaPollutionCategoryList'=>$seaPollutionCategoryList,
                    'conPollutionCategoryList'=>$conPollutionCategoryList
                );
            }
            $response = new Response($this->serialize([
                'typeofAccidentList'=>$typeofAccidentList,
                'typeofInjuryList'=>$typeofInjuryList,
                'placeofAccidentList'=>$placeofAccidentList,
                'bodyAreasAffectedList'=>$bodyAreasAffectedList,
                'shipOperationList'=>$shipOperationList,
                'seaPollutionCategoryList'=>$seaPollutionCategoryList,
                'conPollutionCategoryList'=>$conPollutionCategoryList,
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * gotocreateincidentstat
     * @Rest\Post("/gotocreateincidentstat",name="gotocreateincidentstat")
     */
    public function gotocreateincidentstatDetailsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incidentId= $request->request->get('incidentId');
        try{
            $incidentStatisticsDataDetails = $em->createQueryBuilder()
                ->select('isd.id','i.id as incidentId','isd.typeof_stat_data', 'isd.dutyStatus','isd.rankStatus',
                    'isd.typeofInjury','isd.typeofAccident','isd.placeofAccident','isd.bodyareaAffected',
                    'isd.shipoperation','isd.primaryequimentdemage',
                    'isd.demagepart','isd.demagethirdparty','isd.detailsofincident','isd.demagedrug_alcohol',
                    'isd.spills_sea_liter','isd.spills_sea_pol_cate','isd.spills_sea_pol_cate_other',
                    'isd.spills_contain_liter','isd.spills_contain_pol_cate','isd.spills_contain_liter_other')
                ->from('DashboardBundle:IncidentStatisticsData', 'isd')
                ->join('DashboardBundle:Incident', 'i', 'with', 'i.id = isd.incidentId')
                ->where('isd.incidentId = :incidentId ')
                ->setParameter('incidentId', $incidentId)
                ->getQuery()
                ->getResult();
            $listdropDownValueforinci_stat=$this->getalldropdownstatdataAction($request,"gotoaddstat_data");
            if(count($incidentStatisticsDataDetails)==1){
                $response = new Response($this->serialize([
                    'incidentStatisticsDataDetails' =>$incidentStatisticsDataDetails,
                    'typeofAccidentList'=>$listdropDownValueforinci_stat['typeofAccidentList'],
                    'typeofInjuryList'=>$listdropDownValueforinci_stat['typeofInjuryList'],
                    'placeofAccidentList'=>$listdropDownValueforinci_stat['placeofAccidentList'],
                    'bodyAreasAffectedList'=>$listdropDownValueforinci_stat['bodyAreasAffectedList'],
                    'shipOperationList'=>$listdropDownValueforinci_stat['shipOperationList'],
                    'seaPollutionCategoryList'=>$listdropDownValueforinci_stat['seaPollutionCategoryList'],
                    'conPollutionCategoryList'=>$listdropDownValueforinci_stat['conPollutionCategoryList'],
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            elseif (count($incidentStatisticsDataDetails)<=0){
                $response = new Response($this->serialize([
                    'incidentStatisticsDataDetails' =>0,
                    'typeofAccidentList'=>$listdropDownValueforinci_stat['typeofAccidentList'],
                    'typeofInjuryList'=>$listdropDownValueforinci_stat['typeofInjuryList'],
                    'placeofAccidentList'=>$listdropDownValueforinci_stat['placeofAccidentList'],
                    'bodyAreasAffectedList'=>$listdropDownValueforinci_stat['bodyAreasAffectedList'],
                    'shipOperationList'=>$listdropDownValueforinci_stat['shipOperationList'],
                    'seaPollutionCategoryList'=>$listdropDownValueforinci_stat['seaPollutionCategoryList'],
                    'conPollutionCategoryList'=>$listdropDownValueforinci_stat['conPollutionCategoryList'],
                ]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);

            }
            else{
                $response = new Response($this->serialize([
                    'typeofAccidentList'=>$listdropDownValueforinci_stat['typeofAccidentList'],
                    'typeofInjuryList'=>$listdropDownValueforinci_stat['typeofInjuryList'],
                    'placeofAccidentList'=>$listdropDownValueforinci_stat['placeofAccidentList'],
                    'bodyAreasAffectedList'=>$listdropDownValueforinci_stat['bodyAreasAffectedList'],
                    'shipOperationList'=>$listdropDownValueforinci_stat['shipOperationList'],
                    'seaPollutionCategoryList'=>$listdropDownValueforinci_stat['seaPollutionCategoryList'],
                    'conPollutionCategoryList'=>$listdropDownValueforinci_stat['conPollutionCategoryList'],
                ]), Response::HTTP_CREATED);
            }
            return $this->setBaseHeaders($response);

        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Find all Typeof Cause
     * @Rest\Post("/findalltypecause",name="findalltypecause")
     */
    public function findallTypeofCauseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        //Find all Type of Cause
        $typeofCauselist = $em->createQueryBuilder()
            ->select('i')
            ->from('DashboardBundle:TypeofCause', 'i')
            ->getQuery()
            ->getResult();
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $total_records = count($typeofCauselist);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $listActiveRecords = $em->createQueryBuilder()
            ->select('i')
            ->from('DashboardBundle:TypeofCause', 'i')
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->getQuery()
            ->getResult();
        $response = new Response($this->serialize(['typeofCauselist' => $listActiveRecords,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }

    /**
     * Change Type of Cause
     * @Rest\Post("/changetypeofcuaseStatus",name="changetypeofcuaseStatus")
     */
    public function changeTypeofCuaseStuatusAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $typeofCauseId= $request->request->get('typeofcauseId');
        $severity_classification=$request->request->get('severityClassification');

        try{
            $typeofCuaseObject = $em->getRepository('DashboardBundle:TypeofCause')->findOneBy(array('id' =>  $typeofCauseId));
            $typeofCuaseObject->setSeverityClassification($severity_classification);
            $em->flush();
            $response = new Response($this->serialize([
                'resmsg' => 'Typeof Cause Changed!!!'
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Change Incident Status
     * @Rest\Post("/changeIncidentStatus",name="changeIncidentStatus")
     */
    public function changeIncidentStuatusAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $incidentId= $request->request->get('id');
        $statusofReport=$request->request->get('statusofReport');

        try{
            $incidentFirstInfoObject= $em->getRepository('DashboardBundle:IncidentFirstInfo')->findOneBy(array('incidentId' =>  $incidentId));
            $resMsg="";
            $status=0;
            if($incidentFirstInfoObject!=null){
                $incidentFirstInfoObject->setStatusofReport(2);
                $em->flush();
                $resMsg="Incident Closed";
                $status=1;
            }
            else{
                $resMsg="Incident Not Found";
            }
            $response = new Response($this->serialize([
                'resmsg' => $resMsg,'status'=>$status
            ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        catch (Exception $e){
            $response = new Response($this->serialize(['resmsg' => $e->getMessage()]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

    }
    /**
     * Find all Incidents for Company
     * @Rest\POST("/findincidents",name="findAllincidents")
     */
    public function findallIncidentsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        if($companyId==null){
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
        //Find all Vessels
        $findallIncidents = $em->createQueryBuilder()
            ->select('i.id','i.incidentUId','if.dateofIncident','s.shipName',
                'if.dateofIncidentreportMade','if.statusofReport','if.location',
                'ide.totalDemage','ide.rcaRequired','ide.immediateAction','ide.incidentDescription','ide.followupAction',
                'tc.causeName','tc.severityClassification','ti.incidentName','ottt.timeofIncident',
                'fi.factorName','ic.incidentReportFinalCost','ic.offHireDays','ic.managersCostUSD','ic.ownersCostUSD',
                'ic.incidentFinalCostUSD','ic.timebetweenincidentandincidentmade','ic.dateReportsenttoowners','ic.timebetweenincidentreportmadeandreportsendtoowners',
                'ic.incidentClosedbyOwners','iow.whether','iow.water','iow.wind','iow.windDirection','iow.visiblity','iow.tide','iow.operator_given_name')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
            ->join('DashboardBundle:IncidentOperatorWeather', 'iow', 'with', 'i.id = iow.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'ti', 'with', 'if.typeofIncdientId = ti.id')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->join('DashboardBundle:OperationattimeofIncident', 'ottt', 'with', 'ottt.id = ide.operationattimeofIncident')
            ->join('DashboardBundle:FactortoIncident', 'fi', 'with', 'fi.id = ide.factortoIncident')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->setParameter('userObject', $userobject)
            ->getQuery()
            ->getResult();
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $total_records = count($findallIncidents);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $findallActiveIncidents = $em->createQueryBuilder()
            ->select('i.id','i.incidentUId','if.dateofIncident','s.shipName',
                'if.dateofIncidentreportMade','if.statusofReport','if.location',
                'ide.totalDemage','ide.rcaRequired','ide.immediateAction','ide.incidentDescription','ide.followupAction',
                'tc.causeName','tc.severityClassification','ti.incidentName','ottt.timeofIncident',
                'fi.factorName','ic.incidentReportFinalCost','ic.offHireDays','ic.managersCostUSD','ic.ownersCostUSD',
                'ic.incidentFinalCostUSD','ic.timebetweenincidentandincidentmade','ic.dateReportsenttoowners','ic.timebetweenincidentreportmadeandreportsendtoowners',
                'ic.incidentClosedbyOwners','iow.whether','iow.water','iow.wind','iow.windDirection','iow.visiblity','iow.tide','iow.operator_given_name')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
            ->join('DashboardBundle:IncidentOperatorWeather', 'iow', 'with', 'i.id = iow.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'ti', 'with', 'if.typeofIncdientId = ti.id')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->join('DashboardBundle:OperationattimeofIncident', 'ottt', 'with', 'ottt.id = ide.operationattimeofIncident')
            ->join('DashboardBundle:FactortoIncident', 'fi', 'with', 'fi.id = ide.factortoIncident')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->setParameter('userObject', $userobject)
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->orderBy('i.id')
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['allincidentList' => $findallActiveIncidents,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);        return $this->setBaseHeaders($response);

    }
    /**
     * Find all Incidents for Company
     * @Rest\POST("/findallincidentwithoutpaging",name="findallincidentwithoutpaging")
     */
    public function findallIncidentswithoutPaginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        if($companyId==null){
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
        //Find all Incidents
        $findallIncidents = $em->createQueryBuilder()
            ->select('i.id','i.incidentUId','if.dateofIncident','s.shipName',
                'if.dateofIncidentreportMade','if.statusofReport','if.location',
                'ide.totalDemage','ide.rcaRequired','ide.immediateAction','ide.incidentDescription','ide.followupAction',
                'tc.causeName','tc.severityClassification','ti.incidentName','ottt.timeofIncident',
                'fi.factorName','ic.incidentReportFinalCost','ic.offHireDays','ic.managersCostUSD','ic.ownersCostUSD',
                'ic.incidentFinalCostUSD','ic.timebetweenincidentandincidentmade','ic.dateReportsenttoowners','ic.timebetweenincidentreportmadeandreportsendtoowners',
                'ic.incidentClosedbyOwners','iow.whether','iow.water','iow.wind','iow.windDirection','iow.visiblity','iow.tide','iow.operator_given_name')
            ->from('DashboardBundle:Incident', 'i')
            ->join('UserBundle:User', 'u', 'with', 'i.userId = u.id')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
            ->join('DashboardBundle:IncidentOperatorWeather', 'iow', 'with', 'i.id = iow.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'ti', 'with', 'if.typeofIncdientId = ti.id')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->join('DashboardBundle:OperationattimeofIncident', 'ottt', 'with', 'ottt.id = ide.operationattimeofIncident')
            ->join('DashboardBundle:FactortoIncident', 'fi', 'with', 'fi.id = ide.factortoIncident')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->where('i.userId = :userObject ')
            ->setParameter('userObject', $userobject)
            ->orderBy('i.id')
            ->getQuery()
            ->getResult();
        $pageNumber=$request->request->get('pageNumber');
        $records_per_page=$request->request->get('recordsperPage');
        $total_records = count($findallIncidents);
        $last_page = ceil($total_records / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $response = new Response($this->serialize(['allincidentList' => $findallIncidents,
            'totalRecords'=>$total_records,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);        return $this->setBaseHeaders($response);

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
