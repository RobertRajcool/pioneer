<?php

namespace RankingBundle\Controller;

use RankingBundle\Entity\ElementComparisonRules;
use RankingBundle\Entity\ElementSymbols;
use RankingBundle\Entity\RankingElementDetails;
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
 * @Route("/rankingelement")
 */
class RankingElementDetailsController extends Controller
{
    /**
     * @Route("/indexaction")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
    /**
     * Select Ranking Elements Function
     * @Rest\Post("/selectrankingelements",name="selectrankingelements")
     */
    public function selectrankingelementsAction(Request $request,$requestMode="")
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
        $elementList = $em->createQueryBuilder()
            ->select('ele.id,ele.elementName,ele.description','ele.cellName','ele.activeDate','kpi.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,u.username,
                ele.dateTime,es.symbolIndication,kpi.kpiName,u.username')
            ->from('RankingBundle:RankingElementDetails', 'ele')
            ->join('RankingBundle:RankingKpiDetails', 'kpi', 'with', 'kpi.id = ele.kpiDetailsId')
            ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
            ->join('UserBundle:User', 'u', 'with', 'kpi.userId = u.id')
            ->where('u.id = :userObject ')
            ->andwhere('kpi.kpiStatusValue = :kpistatusValue or kpi.kpiStatusValue = 3')
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->setParameter('userObject', $userobject)
            ->getQuery()
            ->getResult();
        if($requestMode=="allelements"){
            return $elementList;
        }
        $response = new Response($this->serialize(['allelementList' => $elementList]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }

    /**
     * Select ranking elements based on kpi id
     * @Rest\Post("/elementdetailsbykpiid",name="elementdetailsbykpiid")
     */
    public function getElementByKpiIdAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $kpi_id=$request->request->get('kpiDetailsId');
        $elementDetails=$em->createQueryBuilder()
            ->select('a.id, a.elementName')
            ->from('RankingBundle:RankingElementDetails', 'a')
            ->where('a.kpiDetailsId = :kpi_id ')
            ->setParameter('kpi_id', $kpi_id)
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['elementDetails' => $elementDetails]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }

    /**
     * Select Ranking Elements Function
     * @Rest\Get("/selectkpiandsymbol",name="selectkpiandsymbol")
     */
    public function selectkpiandsymbolIndicationAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $kpidetailscontroller = new RankingKpiDetailsController();
        $kpidetailscontroller->setContainer($this->container);
        $kpiList = $kpidetailscontroller->selectallusigfilterkpiAction($request,"KpiList");
        $symbolList = $em->createQueryBuilder()
            ->select('es.id', 'es.symbolName','es.symbolIndication')
            ->from('RankingBundle:ElementSymbols', 'es')
            ->getQuery()
            ->getResult();
        $response = new Response($this->serialize(['allkpiList' =>$kpiList['allkpiList'],'symbolList'=>$symbolList]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Select  Elements addSymbol Function
     * @Rest\Post("/addsymbol",name="addSymbol")
     */
    public function addSymbolAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $symbolName=$request->request->get('symbolName');
        $symbolIndication=$request->request->get('symbolIndication');
        $elmentsymbolObject=new ElementSymbols();
        $elmentsymbolObject->setSymbolIndication($symbolIndication);
        $elmentsymbolObject->setSymbolName($symbolName);
        $em->persist($elmentsymbolObject);
        $em->flush();
        $symbolList = $em->createQueryBuilder()
            ->select('es.id', 'es.symbolName','es.symbolIndication')
            ->from('RankingBundle:ElementSymbols', 'es')
            ->getQuery()
            ->getResult();
        $response = new Response($this->serialize(['symbolList'=>$symbolList,'resMsg'=>$symbolName.' Element symbol added']), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * addElements Function
     * @Rest\Post("/addelements",name="addElements")
     */
    public function addElementAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $kpiid=$request->request->get('kpiid');
        $elementName=$request->request->get('elementName');
        $weightage=$request->request->get('weightage');
        $validfrom=$request->request->get('validfrom');
        $validfromdateObject=new \DateTime('01-'.$validfrom);
        $validfromdateObject->modify('first day of this month');
        $validTo=$request->request->get('validTo');
        $validTodateObject=new \DateTime('01-'.$validTo);
        $validTodateObject->modify('first day of this month');
        $cellname=$request->request->get('cellname');
        $celldetails=$request->request->get('celldetails');
        $description=$request->request->get('description');
        $indicationValue=$request->request->get('indicationValue');
        $symbol=$request->request->get('symbol');
        $vesselWiseTotal=$request->request->get('vesselWiseTotal');
        $baseValue=$request->request->get('baseValue');
        $comparisonStatus=$request->request->get('comparisonStatus');
        $rankingkpiObject=$em->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('id' => $kpiid));
        $elementSymbolsObject=$em->getRepository('RankingBundle:ElementSymbols')->findOneBy(array('id' => $symbol));
        $rankingElementObject=new RankingElementDetails();
        $rankingElementObject->setElementName($elementName);
        $rankingElementObject->setWeightage($weightage);
        $rankingElementObject->setKpiDetailsId($rankingkpiObject);
        $rankingElementObject->setSymbolId($elementSymbolsObject);
        $rankingElementObject->setActiveDate($validfromdateObject);
        $rankingElementObject->setEndDate($validTodateObject);
        $rankingElementObject->setBaseValue($baseValue);
        $rankingElementObject->setCellDetails($celldetails);
        $rankingElementObject->setCellName($cellname);
        $rankingElementObject->setComparisonStatus($comparisonStatus);
        $rankingElementObject->setDescription($description);
        $rankingElementObject->setIndicationValue($indicationValue);
        $rankingElementObject->setVesselWiseTotal($vesselWiseTotal);
        $rankingElementObject->setDateTime();
        $em->persist($rankingElementObject);
        $em->flush();
        $elementDetailsObject=$em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id'=>$rankingElementObject->getId()));
        $listofRules=$request->request->get('comparsionRulegroup');
        for($listofRulesCount=0;$listofRulesCount<count($listofRules);$listofRulesCount++){
            $elemenntCompareRulesObject=new ElementComparisonRules();
            $elemenntCompareRulesObject->setElementDetailsId($elementDetailsObject);
            $elemenntCompareRulesObject->setRules(json_encode($listofRules[$listofRulesCount]));
            $em->persist($elemenntCompareRulesObject);
            $em->flush();

        }
        $symbolList = $em->createQueryBuilder()
            ->select('es.id', 'es.symbolName','es.symbolIndication')
            ->from('RankingBundle:ElementSymbols', 'es')
            ->getQuery()
            ->getResult();
        $allelements=$this->selectrankingelementsAction($request,"allelements");
        $response = new Response($this->serialize(['elementlist'=>$allelements,'resMsg'=>$elementName.' Element  added']), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * update element Function
     * @Rest\Put("/updateElement",name="updateElements")
     */
    public function updateElementAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $kpiid=$request->request->get('kpiid');
        $elementName=$request->request->get('elementName');
        $weightage=$request->request->get('weightage');
        $validfrom=$request->request->get('validfrom');
        $validfromdateObject=new \DateTime('01-'.$validfrom);
        $validfromdateObject->modify('first day of this month');
        $validTo=$request->request->get('validTo');
        $validTodateObject=new \DateTime('01-'.$validTo);
        $validTodateObject->modify('first day of this month');
        $cellname=$request->request->get('cellname');
        $celldetails=$request->request->get('celldetails');
        $description=$request->request->get('description');
        $indicationValue=$request->request->get('indicationValue');
        $symbol=$request->request->get('symbol');
        $vesselWiseTotal=$request->request->get('vesselWiseTotal');
        $baseValue=$request->request->get('baseValue');
        $comparisonStatus=$request->request->get('comparisonStatus');
        $elementId=$request->request->get('kpiStatusScorecard');
        $rankingkpiObject=$em->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('id' => $kpiid));
        $elementSymbolsObject=$em->getRepository('RankingBundle:ElementSymbols')->findOneBy(array('id' => $symbol));
        $elementDetailsObject=$em->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id'=>$elementId));
        $elementDetailsObject->setElementName($elementName);
        $elementDetailsObject->setWeightage($weightage);
        $elementDetailsObject->setSymbolId($elementSymbolsObject);
        $elementDetailsObject->setActiveDate($validfromdateObject);
        $elementDetailsObject->setEndDate($validTodateObject);
        $elementDetailsObject->setBaseValue($baseValue);
        $elementDetailsObject->setCellDetails($celldetails);
        $elementDetailsObject->setCellName($cellname);
        $elementDetailsObject->setComparisonStatus($comparisonStatus);
        $elementDetailsObject->setDescription($description);
        $elementDetailsObject->setIndicationValue($indicationValue);
        $elementDetailsObject->setVesselWiseTotal($vesselWiseTotal);
        $em->flush();
        $comparsionRuleList = $em->createQueryBuilder()
            ->select('ecr.id', 'identity(ecr.elementDetailsId)','ecr.rules')
            ->from('RankingBundle:ElementComparisonRules', 'ecr')
            ->where('ecr.elementDetailsId = :elementId')
            ->setParameter('elementId',$elementId)
            ->getQuery()
            ->getResult();
        $listofRules=$request->request->get('comparsionRulegroup');
        if(count($listofRules)==count($comparsionRuleList)){
            for($listofRulesCount=0;$listofRulesCount<count($listofRules);$listofRulesCount++){
                $elemenntCompareRulesObject=$em->getRepository('RankingBundle:ElementComparisonRules')->findOneBy(array('id' => $comparsionRuleList[$listofRulesCount]['id']));
                $elemenntCompareRulesObject->setElementDetailsId($elementDetailsObject);
                $elemenntCompareRulesObject->setRules(json_encode($listofRules[$listofRulesCount]));
                $em->flush();

            }
        }
        else{
            $deleteupdateResults = $em->createQueryBuilder()
                ->delete('RankingBundle:ElementComparisonRules', 'ecr')
                ->where('ecr.elementDetailsId = :elementId')
                ->setParameter('elementId', $elementId)
                ->getQuery()
                ->getResult();
            for($listofRulesCount=0;$listofRulesCount<count($listofRules);$listofRulesCount++){
                $elemenntCompareRulesObject=new ElementComparisonRules();
                $elemenntCompareRulesObject->setElementDetailsId($elementDetailsObject);
                $elemenntCompareRulesObject->setRules(json_encode($listofRules[$listofRulesCount]));
                $em->persist($elemenntCompareRulesObject);
                $em->flush();

            }
        }
        $response = new Response($this->serialize(['resMsg'=>$elementName.' element  updated']), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }
    /**
     * Check Ranking Element Weightage.
     *
     * @Route("/ranking_element_checkweightage", name="checkelementweightage")
     */
    public function checkelementweightageAction(Request $request)
    {
        $userobject = $this->getUser();
        $companyId=$userobject->getCompanyId();
        $em = $this->getDoctrine()->getManager();
        $kpiIds=$request->request->get('kpiid');
        $weightage=$request->request->get('weightage');
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        $sumelementweightage = $em->createQueryBuilder()
            ->select( 'sum(ele.weightage) as totalweightage,rkpi.kpiName')
            ->from('RankingBundle:RankingElementDetails', 'ele')
            ->join('RankingBundle:RankingKpiDetails', 'rkpi','with', 'rkpi.id = ele.kpiDetailsId')
            ->where('rkpi.id = :kpi_id ')
            ->andwhere('rkpi.kpiStatusValue = :kpistatusValue or rkpi.kpiStatusValue = 3')
            ->setParameter('kpi_id', $kpiIds)
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->getQuery()
            ->getResult();
        if(count($sumelementweightage)!=0){
            $totalWeighatge=$sumelementweightage[0]['totalweightage']+$weightage;
            if($totalWeighatge >100){
                $responseMsg=$sumelementweightage[0]['kpiName']." Weightage Exceed Than 100";
                $response = new Response($this->serialize(['status' => false,'resMsg'=>$responseMsg]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
            else{
                $response = new Response($this->serialize(['status' => true,'resMsg'=>'']), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);
            }
        }
        else{
            $response = new Response($this->serialize(['status' => true,'resMsg'=>'']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }

    }
    /**
     * Check Element Name.
     *
     * @Route("/checkrankingelementName", name="checkrankingElementName")
     */
    public function checkrankingElementNameAction(Request $request)
    {
        $user = $this->getUser();
        $elementName=$request->request->get('elementName');
        $kpiStatusValue=$request->request->get('kpiStatusValue');
        $kpiId=$request->request->get('kpiid');
        $em = $this->getDoctrine()->getManager();
        $elementResultQuery= $em->createQueryBuilder()
            ->select( 'ele.id')
            ->from('RankingBundle:RankingElementDetails', 'ele')
            ->join('RankingBundle:RankingKpiDetails', 'rkpi','with', 'rkpi.id = ele.kpiDetailsId')
            ->andwhere('rkpi.kpiStatusValue = :kpistatusValue or rkpi.kpiStatusValue = 3')
            ->where('ele.elementName = :elementNameParameters and rkpi.id = :kpiId ')
            ->andwhere('rkpi.kpiStatusValue = :kpistatusValue or rkpi.kpiStatusValue = 3')
            ->setParameter('elementNameParameters',stripslashes($elementName))
            ->setParameter('kpiId',$kpiId)
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->getQuery()
            ->getResult();
        if(count($elementResultQuery)!=0){
            $response = new Response($this->serialize(['status' => false,'resMsg'=>'Elementname already Exists']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        else{
            $response = new Response($this->serialize(['status' => true,'resMsg'=>'']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
    }
    /**
     * Select elmentwithzeroweightage Function
     * @Rest\Get("/elmentwithzeroweightage",name="elmentwithzeroweightage")
     */
    public function selectallelementwithzeroweighageAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
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
        $elementList = $em->createQueryBuilder()
            ->select('ele.id,ele.elementName,ele.description','ele.cellName','ele.activeDate','ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,u.username,
                ele.dateTime,es.symbolIndication,kpi.kpiName,u.username')
            ->from('RankingBundle:RankingElementDetails', 'ele')
            ->join('RankingBundle:RankingKpiDetails', 'kpi', 'with', 'kpi.id = ele.kpiDetailsId')
            ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
            ->join('UserBundle:User', 'u', 'with', 'kpi.userId = u.id')
            ->where('u.id = :userObject and ele.weightage = 0')
            ->setParameter('userObject', $userobject)
            ->getQuery()
            ->getResult();
        if($requestMode=="allelements"){
            return $elementList;
        }
        $response = new Response($this->serialize(['allelementList' => $elementList]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }
    /**
     * Select Ranking kpi Function
     * @Rest\Post("/selectelementbyId",name="selectrankingelementsbyId")
     */
    public function selectkpiByIdAction(Request $request,$requestMode="")
    {
        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $elementId=$request->request->get('elementId');
        $companyId=$userobject->getCompanyId();
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
        $elementList = $em->createQueryBuilder()
            ->select('ele.id,ele.elementName,ele.description,ele.cellName,ele.cellDetails,ele.activeDate,kpi.id as kpiId,ele.endDate
                ,ele.weightage,ele.vesselWiseTotal,ele.indicationValue,ele.comparisonStatus,ele.baseValue,u.username,
                ele.dateTime,es.symbolIndication,kpi.kpiName,kpi.kpiStatusValue,u.username,es.id as symbolId')
            ->from('RankingBundle:RankingElementDetails', 'ele')
            ->join('RankingBundle:RankingKpiDetails', 'kpi', 'with', 'kpi.id = ele.kpiDetailsId')
            ->leftjoin('RankingBundle:ElementSymbols', 'es', 'with', 'es.id = ele.symbolId')
            ->join('UserBundle:User', 'u', 'with', 'kpi.userId = u.id')
            ->where('u.id = :userObject ')
            ->andwhere('ele.id = :elementId ')
            ->setParameter('elementId', $elementId)
            ->setParameter('userObject', $userobject)
            ->getQuery()
            ->getResult();
        if(count($elementList)!=0){
            $kpiStatutus=$elementList[0]['kpiStatusValue'];
        }
        else{
            $kpiStatutus=null;
        }
        $kpidetailscontroller = new RankingKpiDetailsController();
        $kpidetailscontroller->setContainer($this->container);
        $kpiList = $kpidetailscontroller->selectallusigfilterkpiAction($request,"KpiList_".$kpiStatutus);
        $symbolList = $em->createQueryBuilder()
            ->select('es.id', 'es.symbolName','es.symbolIndication')
            ->from('RankingBundle:ElementSymbols', 'es')
            ->getQuery()
            ->getResult();
        $comparsionRuleList = $em->createQueryBuilder()
            ->select('ecr.id', 'identity(ecr.elementDetailsId)','ecr.rules')
            ->from('RankingBundle:ElementComparisonRules', 'ecr')
            ->where('ecr.elementDetailsId = :elementId')
            ->setParameter('elementId',$elementId)
            ->getQuery()
            ->getResult();
        $elementwithzeroweightage=$this->selectallelementwithzeroweighageAction($request,"allelements");
        $response = new Response($this->serialize([
            'elementList' => $elementList,
            'kpiList'=>$kpiList['allkpiList'],
            'symbolList'=>$symbolList,
            'comparsionRule'=>$comparsionRuleList,'allelementList'=>$elementwithzeroweightage
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
