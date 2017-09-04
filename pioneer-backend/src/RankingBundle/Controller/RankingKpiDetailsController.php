<?php

namespace RankingBundle\Controller;

use RankingBundle\Entity\RankingKpiDetails;
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
 * @Route("/rankingkpi")
 */
class RankingKpiDetailsController extends Controller
{
    /**
     * @Route("/indexaction")
     */
    public function indexAction()
    {
        return $this->render('DashboardBundle:Default:index.html.twig');
    }
    /**
     * add Ranking kpi Function
     * @Rest\Post("/addkpi",name="addrankingKpi")
     */
    public function addkpiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $shipId=$request->request->get('shipId');
        $kpiname=$request->request->get('kpiname');
        $weightage=$request->request->get('weightage');
        $description=$request->request->get('description');
        $validfrom=$request->request->get('validfrom');
        $validfromdateObject=new \DateTime($validfrom);
        $validfromdateObject->modify('first day of this month');
        $validTo=$request->request->get('validTo');
        $validTodateObject=new \DateTime($validTo);
        $validTodateObject->modify('first day of this month');
        $cellname=$request->request->get('cellname');
        $celldetails=$request->request->get('celldetails');
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        if($shipId[0]==-1){
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
            for($shipCount=0;$shipCount<count($VesselList);$shipCount++){
                $rankingkpiObject=new RankingKpiDetails();
                $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  $VesselList[$shipCount]['id']));
                $rankingkpiObject->setShipDetailsId($shipObject);
                $rankingkpiObject->setKpiStatusValue($kpiStatusValue);
                $rankingkpiObject->setUserId($userobject);
                $rankingkpiObject->setKpiName($kpiname);
                $rankingkpiObject->setWeightage($weightage);
                $rankingkpiObject->setDescription($description);
                $rankingkpiObject->setActiveDate($validfromdateObject);
                $rankingkpiObject->setEndDate($validTodateObject);
                $rankingkpiObject->setCellName($cellname);
                $rankingkpiObject->setCellDetails($celldetails);
                $rankingkpiObject->setCreatedDateTime();
                $em->persist($rankingkpiObject);
                $em->flush();
            }
        }
        else{
            for($shipCount=0;$shipCount<count($shipId);$shipCount++){
                $rankingkpiObject=new RankingKpiDetails();
                $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  $shipId[$shipCount]));
                $rankingkpiObject->setShipDetailsId($shipObject);
                $rankingkpiObject->setKpiStatusValue($kpiStatusValue);
                $rankingkpiObject->setUserId($userobject);
                $rankingkpiObject->setKpiName($kpiname);
                $rankingkpiObject->setWeightage($weightage);
                $rankingkpiObject->setDescription($description);
                $rankingkpiObject->setActiveDate($validfromdateObject);
                $rankingkpiObject->setEndDate($validTodateObject);
                $rankingkpiObject->setCellName($cellname);
                $rankingkpiObject->setCellDetails($celldetails);
                $rankingkpiObject->setCreatedDateTime();
                $em->persist($rankingkpiObject);
                $em->flush();
            }
        }
        $allKpiList=$this->selectallkpiAction($request,$requestMode="KpiList");
        $response = new Response($this->serialize(['allkpiList' => $allKpiList['allkpiList'],'resMsg'=>$kpiname.' Kpi Created','showStatus'=>(int)$kpiStatusValue]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * update RankingDetails kpi Function
     * @Rest\Put("/updaterankingkpi",name="updaterankingkpi")
     */
    public function updatekpiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        $kpiId=$request->request->get('kpiId');
        $shipId=$request->request->get('shipId');
        $kpiname=$request->request->get('kpiname');
        $weightage=$request->request->get('weightage');
        $description=$request->request->get('description');
        $validfrom=$request->request->get('validfrom');
        $validfromdateObject=new \DateTime($validfrom);
        $validfromdateObject->modify('first day of this month');
        $validTo=$request->request->get('validTo');
        $validTodateObject=new \DateTime($validTo);
        $validTodateObject->modify('first day of this month');
        $cellname=$request->request->get('cellname');
        $celldetails=$request->request->get('celldetails');
        if($shipId[0]==-1){
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
            for($shipCount=0;$shipCount<count($VesselList);$shipCount++){
                $rankingkpiObject=$em->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('shipDetailsId' =>  $VesselList[$shipCount]['id'],'kpiName' => $kpiname));
                $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  $VesselList[$shipCount]['id']));
                if($rankingkpiObject!=null){
                    $rankingkpiObject->setShipDetailsId($shipObject);
                    $rankingkpiObject->setUserId($userobject);
                    $rankingkpiObject->setKpiName($kpiname);
                    $rankingkpiObject->setWeightage($weightage);
                    $rankingkpiObject->setDescription($description);
                    $rankingkpiObject->setActiveDate($validfromdateObject);
                    $rankingkpiObject->setEndDate($validTodateObject);
                    $rankingkpiObject->setCellName($cellname);
                    $rankingkpiObject->setCellDetails($celldetails);
                    $rankingkpiObject->setKpiStatusValue($kpiStatusValue);
                    $em->flush();
                }else{
                    $newRankingkpiDetails=new RankingKpiDetails();
                    $newRankingkpiDetails->setShipDetailsId($shipObject);
                    $newRankingkpiDetails->setUserId($userobject);
                    $newRankingkpiDetails->setKpiName($kpiname);
                    $newRankingkpiDetails->setWeightage($weightage);
                    $newRankingkpiDetails->setDescription($description);
                    $newRankingkpiDetails->setActiveDate($validfromdateObject);
                    $newRankingkpiDetails->setEndDate($validTodateObject);
                    $newRankingkpiDetails->setCellName($cellname);
                    $newRankingkpiDetails->setCellDetails($celldetails);
                    $newRankingkpiDetails->setKpiStatusValue($kpiStatusValue);
                    $em->persist($newRankingkpiDetails);
                    $em->flush();
                }

            }
        }
        else{
            for($shipCount=0;$shipCount<count($shipId);$shipCount++){
                $rankingkpiObject=$em->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('shipDetailsId' =>  (int)$shipId[$shipCount],'kpiName' => $kpiname));
                $shipObject =$em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  (int)$shipId[$shipCount]));
                if($rankingkpiObject==null){
                    $newRankingkpiDetails=new RankingKpiDetails();
                    $newRankingkpiDetails->setShipDetailsId($shipObject);
                    $newRankingkpiDetails->setUserId($userobject);
                    $newRankingkpiDetails->setKpiName($kpiname);
                    $newRankingkpiDetails->setWeightage($weightage);
                    $newRankingkpiDetails->setDescription($description);
                    $newRankingkpiDetails->setActiveDate($validfromdateObject);
                    $newRankingkpiDetails->setEndDate($validTodateObject);
                    $newRankingkpiDetails->setCellName($cellname);
                    $newRankingkpiDetails->setCellDetails($celldetails);
                    $newRankingkpiDetails->setKpiStatusValue($kpiStatusValue);
                    $em->persist($newRankingkpiDetails);
                    $em->flush();
                }
                else{
                    $rankingkpiObject->setShipDetailsId($shipObject);
                    $rankingkpiObject->setUserId($userobject);
                    $rankingkpiObject->setKpiName($kpiname);
                    $rankingkpiObject->setWeightage($weightage);
                    $rankingkpiObject->setDescription($description);
                    $rankingkpiObject->setActiveDate($validfromdateObject);
                    $rankingkpiObject->setEndDate($validTodateObject);
                    $rankingkpiObject->setCellName($cellname);
                    $rankingkpiObject->setCellDetails($celldetails);
                    $rankingkpiObject->setKpiStatusValue($kpiStatusValue);
                    $em->flush();
                }

            }
        }
        $allKpiList=$this->selectallkpiAction($request,$requestMode="KpiList");
        $response = new Response($this->serialize(['allkpiList' => $allKpiList['allkpiList'],'resMsg'=>$kpiname.' Kpi Created','showStatus'=>(int)$kpiStatusValue]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }

    /**
     * Select Ranking kpi Function
     * @Rest\Post("/selectallkpi",name="selectrankingkpi")
     */
    public function selectallkpiAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        if($kpiStatusValue==null){
            $kpiStatusValue=2;
        }
        if($requestMode!=""){
            $arraylistSting=explode("_",$requestMode);
            if(count($arraylistSting)==2){
                $kpiStatusValue=$arraylistSting[1];
            }
        }
        if($companyId==null) {
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
        $allKpiList = $em->createQueryBuilder()
            ->select('kpi.id,kpi.kpiName,kpi.description','kpi.activeDate','kpi.endDate','kpi.cellName
                ,kpi.cellDetails,kpi.weightage,kpi.createdDateTime,u.username,s.shipName,kpi.kpiStatusValue')
            ->from('RankingBundle:RankingKpiDetails', 'kpi')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'kpi.shipDetailsId = s.id')
            ->join('UserBundle:User', 'u', 'with', 'kpi.userId = u.id')
            ->where('u.id = :userObject ')
            ->andwhere('kpi.kpiStatusValue = :kpistatusValue or kpi.kpiStatusValue = 3')
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->setParameter('userObject', $userobject)
            ->groupby('kpi.kpiName')
            ->getQuery()
            ->getResult();
        if($requestMode=="KpiList"){
            return array('allkpiList' => $allKpiList);
        }
        else{
            $response = new Response($this->serialize(['allkpiList' => $allKpiList]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }


    }
    /**
     * Select Ranking by filert kpi Function
     * @Rest\Post("/selectallkpibyfilter",name="selectrankingkpibyfilter")
     */
    public function selectallusigfilterkpiAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        if($kpiStatusValue==null){
            $kpiStatusValue=2;
        }
        if($requestMode!=""){
            $arraylistSting=explode("_",$requestMode);
            if(count($arraylistSting)==2){
                $kpiStatusValue=$arraylistSting[1];
            }
        }
        if($companyId==null) {
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
        $allKpiList = $em->createQueryBuilder()
            ->select('kpi.id,kpi.kpiName,kpi.description','kpi.activeDate','kpi.endDate','kpi.cellName
                ,kpi.cellDetails,kpi.weightage,kpi.createdDateTime,u.username,s.shipName,kpi.kpiStatusValue')
            ->from('RankingBundle:RankingKpiDetails', 'kpi')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'kpi.shipDetailsId = s.id')
            ->join('UserBundle:User', 'u', 'with', 'kpi.userId = u.id')
            ->where('u.id = :userObject ')
            ->andwhere('kpi.kpiStatusValue = :kpistatusValue')
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->setParameter('userObject', $userobject)
            ->groupby('kpi.kpiName')
            ->getQuery()
            ->getResult();
        if($requestMode=="KpiList"){
            return array('allkpiList' => $allKpiList);
        }
        else{
            return array('allkpiList' => $allKpiList);
        }
        $response = new Response($this->serialize(['allkpiList' => $allKpiList]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Select Ranking kpi Function
     * @Rest\Post("/selectkpibyId",name="selectkpibyId")
     */
    public function selectkpiByIdAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $kpiId=$request->request->get('rankingkpiId');
        $companyId=$userobject->getCompanyId();
        if($companyId==null){
        }
        else{

            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->where('s.companyName = :companyId ')
                ->setParameter('companyId', $userobject->getCompanyId())
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
        $allKpiList = $em->createQueryBuilder()
            ->select('kpi.id,kpi.kpiName,kpi.description','kpi.kpiStatusValue','kpi.activeDate','kpi.endDate','kpi.cellName
                ,kpi.cellDetails,kpi.weightage,kpi.createdDateTime,u.username,s.shipName')
            ->from('RankingBundle:RankingKpiDetails', 'kpi')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'kpi.shipDetailsId = s.id')
            ->join('UserBundle:User', 'u', 'with', 'kpi.userId = u.id')
            ->where('u.id = :userObject ')
            ->andwhere('kpi.id = :rankingkpiId ')
            ->setParameter('rankingkpiId', $kpiId)
            ->setParameter('userObject', $userobject)
            ->groupby('kpi.kpiName')
            ->getQuery()
            ->getResult();
        $selectedkpiwithelement = $em->createQueryBuilder()
            ->select('s.id', 's.shipName')
            ->from('VesselBundle:Shipdetails', 's')
            ->join('RankingBundle:RankingKpiDetails', 'kpi','with', 'kpi.shipDetailsId = s.id')
            ->where('s.companyName = :companyId ')
            ->andwhere('kpi.kpiName = :rankingkpiName ')
            ->setParameter('rankingkpiName', $allKpiList[0]['kpiName'])
            ->setParameter('companyId', $userobject->getCompanyId())
            ->getQuery()
            ->getResult();
        if($requestMode=="KpiList"){
            return array('allkpiList' => $allKpiList);
        }
        $response = new Response($this->serialize([
            'kpiList' => $allKpiList,
            'vesselList'=>$VesselList,
            'selectedkpiwithelement'=>$selectedkpiwithelement
        ]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Check Kpi Weightage.
     *
     * @Route("/ranking_kpi_checkweightage", name="checkkpiweightage")
     */
    public function checkrankingkpiweightageAction(Request $request)
    {
        $userobject = $this->getUser();
        $companyId=$userobject->getCompanyId();
        $em = $this->getDoctrine()->getManager();
        $shipIds=$request->request->get('shipId');
        $weightage=$request->request->get('weightage');
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        if($shipIds[0]==-1){
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
            for($shipCount=0;$shipCount<count($VesselList);$shipCount++){
                $currentShipId=$VesselList[$shipCount]['id'];
                if($currentShipId!=null){
                    $sumKpiweightage = $em->createQueryBuilder()
                        ->select( 'sum(rkpi.weightage) as totalweightage','s.shipName')
                        ->from('RankingBundle:RankingKpiDetails', 'rkpi')
                        ->join('VesselBundle:Shipdetails', 's', 'with', 'rkpi.shipDetailsId = s.id')
                        ->where('rkpi.shipDetailsId = :shipId ')->andwhere('rkpi.kpiStatusValue = :kpistatusValue or rkpi.kpiStatusValue = 3')
                        ->setParameter('kpistatusValue',$kpiStatusValue)
                        ->setParameter('shipId', $currentShipId)
                        ->getQuery()
                        ->getResult();
                    if(count($sumKpiweightage)!=0){
                        $totalWeighatge=$sumKpiweightage[0]['totalweightage']+$weightage;
                        if($totalWeighatge >100){
                            $responseArray=$sumKpiweightage[0]['shipName']." Weightage Exceed Than 100";
                            $response = new Response($this->serialize(['status' => false,'resMsg'=>$responseArray]), Response::HTTP_CREATED);
                            return $this->setBaseHeaders($response);
                        }
                    }
                }
            }
        }
        else{
            for($shipCount=0;$shipCount<count($shipIds);$shipCount++){
                $currentShipId=$shipIds[$shipCount];
                if($currentShipId!=null){
                    $sumKpiweightage = $em->createQueryBuilder()
                        ->select( 'sum(rkpi.weightage) as totalweightage','s.shipName')
                        ->from('RankingBundle:RankingKpiDetails', 'rkpi')
                        ->join('VesselBundle:Shipdetails', 's', 'with', 'rkpi.shipDetailsId = s.id')
                        ->where('rkpi.shipDetailsId = :shipId ')
                        ->andwhere('rkpi.kpiStatusValue = :kpistatusValue or rkpi.kpiStatusValue = 3')
                        ->setParameter('kpistatusValue',$kpiStatusValue)
                        ->setParameter('shipId', $shipIds[$shipCount])
                        ->groupby('rkpi.shipDetailsId')
                        ->getQuery()
                        ->getResult();
                    if(count($sumKpiweightage)!=0){
                        $totalWeighatge=$sumKpiweightage[0]['totalweightage']+$weightage;
                        if($totalWeighatge >100){
                            $responseArray=$sumKpiweightage[0]['shipName']." Weightage Exceed Than 100";
                            $response = new Response($this->serialize(['status' => false,'resMsg'=>$responseArray]), Response::HTTP_CREATED);
                            return $this->setBaseHeaders($response);
                        }
                    }
                }
            }
        }
        $response = new Response($this->serialize(['status' => true,'resMsg'=>'']), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * Check Kpiname.
     *
     * @Route("/checkrankingkpiname", name="checkkpiname")
     */
    public function checkrankingkpinameAction(Request $request)
    {
        $user = $this->getUser();
        $kpiName=$request->request->get('kpiname');
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        $em = $this->getDoctrine()->getManager();
        $kpinameResultQuery= $em->createQueryBuilder()
            ->select( 'rkpi.id')
            ->from('RankingBundle:RankingKpiDetails', 'rkpi')
            ->where('rkpi.kpiName = :kpiNameparameters ')
            ->andwhere('rkpi.kpiStatusValue = :kpistatusValue or rkpi.kpiStatusValue = 3')
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->setParameter('kpiNameparameters',$kpiName)
            ->getQuery()
            ->getResult();
        if(count($kpinameResultQuery)!=0){
            $response = new Response($this->serialize(['status' => false,'resMsg'=>'Kpiname Already Exsist']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        else{
            $response = new Response($this->serialize(['status' => true,'resMsg'=>'']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
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
