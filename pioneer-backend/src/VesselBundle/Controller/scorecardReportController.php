<?php
namespace VesselBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use VesselBundle\Entity\Shipdetails;
use UserBundle\Util\CommonFunctions;
use JMS\Serializer\SerializationContext;
use VesselBundle\Entity\mailingdetails;
use Ob\HighchartsBundle\Highcharts\Highchart;


/**
 * scorecardReportController.
 * @Route("/secure")
 */
class scorecardReportController extends Controller
{


    /**
     * @Rest\post("/report_generate",name="scorecard_reportGenerate")
     */
    public function ReportGenerateAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $kpiStatusValue=2;
        $validfrom=$request->request->get('validmonth');
        $fromdate=new \DateTime('01-'.$validfrom);
        $fromdate->modify('first day of this month');
        $validTo=$request->request->get('validyear');
        $Todate=new \DateTime('01-'.$validTo);
        $Todate->modify('first day of next month');
        $monthArray = array();
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($fromdate, $interval, $Todate);
        foreach ($period as $dt) {
            array_push($monthArray, $dt->format("Y-m-d"));
        }
        $scorecardKpiList = $em->createQueryBuilder()
            ->select('a.kpiName', 'a.id', 'a.weightage')
            ->from('RankingBundle:RankingKpiDetails', 'a')
            ->andwhere('a.kpiStatusValue = :kpistatusValue or a.kpiStatusValue = 3')
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->groupby('a.kpiName')
            ->getQuery()
            ->getResult();
        $monthLetterArray = array();
        $monthlyScorecardKpiColorArray = array();
        $monthlyKpiAverageValueTotal = array();
        $overallElementListArray = array();
        $overallMonthlyElementColorArray = array();
        $overallMonthlyKpiSumValue = array();
        for ($dateCount = 0; $dateCount < count($monthArray); $dateCount++) {
            $monthlyKpiSumValue = array();
            $monthlyScorecardElementColorArray = array();
            $scorecardKpiColorArray = array();
            $date = strtotime($monthArray[$dateCount]);
            $monthLetterFormat = date('M', $date);
            array_push($monthLetterArray, $monthLetterFormat);
            $monthDetail = new \DateTime($monthArray[$dateCount]);
            $monthDetail->modify('first day of next month');
            $monthlyScorecardKpiWeightAverageValueTotal = 0;
            for ($kpiCount = 0; $kpiCount < count($scorecardKpiList); $kpiCount++) {
                $scorecardElementColorArray = array();
                $scorecardAllKpiId = $scorecardKpiList[$kpiCount]['id'];
                $scorecardKpiWeight = $scorecardKpiList[$kpiCount]['weightage'];
                
                $scorecardElementArray = $em->createQueryBuilder()
                    ->select('c.id, c.elementName,  c.weightage')
                    ->from('RankingBundle:RankingElementDetails', 'c')
                    ->where('c.kpiDetailsId = :kpiId')
                    ->setParameter('kpiId', $scorecardAllKpiId)
                    ->getQuery()
                    ->getResult();

                if ($dateCount == 0) {
                    $scorecardElementList = $em->createQueryBuilder()
                        ->select('c.id, c.elementName,  c.weightage')
                        ->from('RankingBundle:RankingElementDetails', 'c')
                        ->where('c.kpiDetailsId = :kpiId')
                        ->setParameter('kpiId', $scorecardAllKpiId)
                        ->orderBy('c.id')
                        ->getQuery()
                        ->getResult();
                    array_push($overallElementListArray, $scorecardElementList);
                }

                
            }

        }
        $response = new Response(
            $this->serialize(
                [

                    'kpiNameList' => $scorecardKpiList,
                    'overallElementListArray' =>$overallElementListArray,
                    'monthLetterArray'=>$monthLetterArray

                ]
            ), Response::HTTP_CREATED);

        return $response;
    }


    /**
     * @Rest\post("/Rankingreport_generate",name="ranking_reportGenerate")
     */
    public function RankingGenerateAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $userobject=$this->getUser();
        $companyId=$userobject->getCompanyId();
        $kpiStatusValue=1;

        $validfrom=$request->request->get('validmonth');
        $fromdate=new \DateTime('01-'.$validfrom);
        $fromdate->modify('first day of this month');
        $validTo=$request->request->get('validyear');
        $Todate=new \DateTime('01-'.$validTo);
        $Todate->modify('first day of next month');
        $monthArray = array();
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($fromdate, $interval, $Todate);
        foreach ($period as $dt) {
            array_push($monthArray, $dt->format("Y-m-d"));
        }

        $rankingKpiList = $em->createQueryBuilder()
            ->select('a.kpiName', 'a.id', 'a.weightage')
            ->from('RankingBundle:RankingKpiDetails', 'a')
            ->andwhere('a.kpiStatusValue = :kpistatusValue or a.kpiStatusValue = 3')
            ->setParameter('kpistatusValue',$kpiStatusValue)
            ->groupby('a.kpiName')
            ->getQuery()
            ->getResult();
        $monthLetterArray = array();
        $monthlyScorecardKpiColorArray = array();
        $monthlyKpiAverageValueTotal = array();
        $overallElementListArray = array();
        $overallMonthlyElementColorArray = array();
        $overallMonthlyKpiSumValue = array();
        for ($dateCount = 0; $dateCount < count($monthArray); $dateCount++) {
            $monthlyKpiSumValue = array();
            $monthlyScorecardElementColorArray = array();
            $scorecardKpiColorArray = array();
            $date = strtotime($monthArray[$dateCount]);
            $monthLetterFormat = date('M', $date);
            array_push($monthLetterArray, $monthLetterFormat);
            $monthDetail = new \DateTime($monthArray[$dateCount]);
            $monthDetail->modify('first day of next month');
            $monthlyScorecardKpiWeightAverageValueTotal = 0;
            for ($kpiCount = 0; $kpiCount < count($rankingKpiList); $kpiCount++) {
                $scorecardElementColorArray = array();
                $scorecardAllKpiId = $rankingKpiList[$kpiCount]['id'];
                $scorecardKpiWeight = $rankingKpiList[$kpiCount]['weightage'];

                $scorecardElementArray = $em->createQueryBuilder()
                    ->select('c.id, c.elementName,  c.weightage')
                    ->from('RankingBundle:RankingElementDetails', 'c')
                    ->where('c.kpiDetailsId = :kpiId')
                    ->setParameter('kpiId', $scorecardAllKpiId)
                    ->getQuery()
                    ->getResult();

                if ($dateCount == 0) {
                    $rankingElementList = $em->createQueryBuilder()
                        ->select('c.id, c.elementName,  c.weightage')
                        ->from('RankingBundle:RankingElementDetails', 'c')
                        ->where('c.kpiDetailsId = :kpiId')
                        ->setParameter('kpiId', $scorecardAllKpiId)
                        ->orderBy('c.id')
                        ->getQuery()
                        ->getResult();
                    array_push($overallElementListArray, $rankingElementList);
                }


            }

        }
        $response = new Response(
            $this->serialize(
                [

                    'kpiNameList' => $rankingKpiList,
                    'overallElementListArray' =>$overallElementListArray,
                    'monthLetterArray'=>$monthLetterArray

                ]
            ), Response::HTTP_CREATED);

        return $response;
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