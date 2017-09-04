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
 * ReportController.
 * @Route("/secure")
 */
class ReportController extends Controller
{


    /**
     * @Rest\post("/allships",name="get_vessel")
     */

    public function AllshipsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('a.id', 'a.shipName')
            ->from('VesselBundle:Shipdetails', 'a')
            ->getQuery();
        $Shipdetail = $query->getResult();
        $response = new JsonResponse($Shipdetail);
        return $response;
    }


    /**
     * @Rest\post("/allreport",name="get_report")
     */
    public function shipReportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();

        $incidentCountByIncidentWise = array();
        $incidentCount = array();
        $incidentOpened = array();
        $incidentClosed = array();
        $vesselname = array();
        $vesselListObject = array();

        if ($select_checkedall == 'true') {

            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();
            for ($k = 0; $k < count($VesselDetail); $k++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$k]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $VesselDetail[$k]['shipName']);
            }

            for ($j = 0; $j < count($VesselDetail); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }

            for ($i = 0; $i < count($VesselDetail); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);

            }

        } else {
            for ($j = 0; $j < count($shipid); $j++) {
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($k = 0; $k < count($incidentName); $k++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$k]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }


        }


        $response = new JsonResponse();

        $response = new Response(
            $this->serialize(
                [
                    'shipDetails' => $vesselname,
                    'incidentCount' => $incidentCount,
                    'incidentOpened' => $incidentOpened,
                    'incidentClosed' => $incidentClosed,
                    'incidentName' => $incidentName,
                    'currentYear' =>$currentYear,
                    'vesselListObject'=>$vesselListObject,
                    'incidentCountByIncidentWise' => $incidentCountByIncidentWise
                ]
            ), Response::HTTP_CREATED);

        return $response;
    }

    /**
     * @Rest\get("/incidentreport",name="incident_report")
     */
    public function getIncidentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $incidentdetail = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();

        $response = new JsonResponse($incidentdetail);
        return $response;
    }

    /**
     * @Rest\post("/incidentwisereport",name="get_incidentreport")
     */
    public function IncidentReportAction(Request $request, $pdfmode = " ")
    {

        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        
        $incidentCountByIncidentWise = array();
        $offhirecost = array();
        $incidentCount = array();
        $vesselname = array();
        $listrecord = array();
        $graphrecordlist=array();


        if ($select_checkedall == 'true') {
            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();

            for ($shiplist = 0; $shiplist < count($VesselDetail); $shiplist++) {
                $Vessel = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$shiplist]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);


                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }
            $graph = $em->createQueryBuilder()
                ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName', 's.id', 'if.dateofIncident', 'ic.offHireDays', 'ic.incidentFinalCostUSD')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->Where('YEAR(if.dateofIncident) =:currentYear')
                //->andWhere('if.shipId = :ship_id')
                ->setParameter('currentYear', $currentYear)
                //->setParameter('ship_id', $vesselname[$k])
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery();
            $valuelist = $graph->getResult();

            for($listcount=0; $listcount< count($valuelist);$listcount++) {

                array_push($graphrecordlist,$valuelist[$listcount]);

            }

            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $incidentcostcount = array();
            $inicdentoffhiredays = array();
            $graphseriesValue = array();
            //Find Number of incident for particular Vessel
            for ($shipCount = 0; $shipCount < count($graphrecordlist); $shipCount++) {
                $graphseriesTemp = array();
                $graphseriesTemp['name'] = $graphrecordlist[$shipCount]['shipName'];
                //array_push($vesselList, $VesselDetail[$shipCount]['shipName']);
                if ($shipCount > count($graphrecordlist) - 1) {
                    //array_push($vesselwiseincidentCount, 0);
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphrecordlist[$shipCount]['numberofincidents']);
                    array_push($incidentcostcount, (int)$graphrecordlist[$shipCount]['totalcost']);
                    $graphseriesTemp['y'] = (int)$graphrecordlist[$shipCount]['totalcost'];
                    array_push($inicdentoffhiredays, (int)$graphrecordlist[$shipCount]['totaloffhiredays']);
                }
                array_push($graphseriesValue, $graphseriesTemp);
            }

        } else {
            for ($j = 0; $j < count($shipid); $j++) {
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);


                $incidentCountByIncidentWiseWithVesselWise = array();


                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                       // ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        //->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);

                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }

            for ($k = 0; $k < count($vesselname); $k++) {
                $graphRecord = $em->createQueryBuilder()
                    ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName', 's.id', 'if.dateofIncident', 'ic.offHireDays', 'ic.incidentFinalCostUSD')
                    ->from('DashboardBundle:Incident', 'i')
                    ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                    ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                    ->Where('YEAR(if.dateofIncident) =:currentYear')
                    ->andWhere('if.shipId = :ship_id')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('ship_id', $vesselname[$k])
                    ->groupBy('s.id')
                    ->orderBy('s.id')
                    ->getQuery();
                $value = $graphRecord->getResult();
                array_push($graphrecordlist,$value[0]);
            }

            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $incidentcostcount = array();
            $inicdentoffhiredays = array();
            $graphseriesValue = array();
            //Find Number of incident for particular Vessel
            for ($shipCount = 0; $shipCount < count($graphrecordlist); $shipCount++) {
                $graphseriesTemp = array();
                $graphseriesTemp['name'] = $graphrecordlist[$shipCount]['shipName'];
                //array_push($vesselList, $vesselname[$shipCount]['shipName']);
                if ($shipCount > count($graphrecordlist) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphrecordlist[$shipCount]['numberofincidents']);
                    array_push($incidentcostcount, (int)$graphrecordlist[$shipCount]['totalcost']);
                    $graphseriesTemp['y'] = (int)$graphrecordlist[$shipCount]['totalcost'];
                    array_push($inicdentoffhiredays, (int)$graphrecordlist[$shipCount]['totaloffhiredays']);
                }
                array_push($graphseriesValue, $graphseriesTemp);
            }


        }
        if ($pdfmode == 'sendReport') {
            return array(
                'totalincidnets' => array_sum($vesselwiseincidentCount), 'totalcost' => array_sum($incidentcostcount),
                'totaloffhiredays' => array_sum($inicdentoffhiredays), 'currentYear' => $currentYear, 'vesselList' => $vesselList,
                'graphData' => $vesselwiseincidentCount, 'incidentclosedVessleCount' => $incidentclosedVessleCount,
                'incidentopenStatusCount' => $incidentopenStatusCount, 'offhiredayscountshipwise' => $inicdentoffhiredays,
                'incidentcostshipwise' => $incidentcostcount, 'vesselistObject' => $VesselDetail, 'graphDataDetails' => $graphRecord,
                'graphseriesValue' => $graphseriesValue, 'shipid' => $shipid,
            );
        }
        //$response = new JsonResponse();
        $response = new Response($this->serialize([
            'totalincidnets' => array_sum($vesselwiseincidentCount), 'totalcost' => array_sum($incidentcostcount),
            'totaloffhiredays' => array_sum($inicdentoffhiredays), 'currentYear' => $currentYear, 'vesselList' => $vesselList,
            'graphData' => $vesselwiseincidentCount, 'incidentclosedVessleCount' => $incidentclosedVessleCount,
            'incidentopenStatusCount' => $incidentopenStatusCount, 'offhiredayscountshipwise' => $inicdentoffhiredays,
            'incidentcostshipwise' => $incidentcostcount, 'vesselistObject' => $vesselname, 'graphDataDetails' => $graphrecordlist,
            'graphseriesValue' => $graphseriesValue, 'shipid' => $shipid]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }

    /**
     * @Rest\post("/severitywisereport",name="severity_report")
     */
    public function severtyReportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');
        $userobject = $this->getUser();
        $companyId = $userobject->getCompanyId();
        $vesselname = array();
        $incidentCount = array();
        $incidentClosed =array();
        $incidentOpened =array();
        $vesselListObject=array();


        if ($select_checkedall == 'true') {
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->getQuery()
                ->getResult();
            for ($k = 0; $k < count($VesselList); $k++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselList[$k]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $VesselList[$k]['shipName']);
            }

            for ($j = 0; $j < count($VesselList); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselList[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }
            for($shipcount = 0; $shipcount<count($VesselList); $shipcount++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);
                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

            }
        //Find type of Incident Count
        $typeofIncdientlist = $em->createQueryBuilder()
            ->select('ti.id', 'ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $incidentCountByIncidentWise = $em->createQueryBuilder()
            ->select('count(i.id) as typeofincidentCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear', $currentYear)
            ->groupBy('tc.id')
            ->orderBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $typeofincidentCountarray = array();
        for ($typeofincidentcount = 0; $typeofincidentcount < count($typeofIncdientlist); $typeofincidentcount++) {
            $typeofincidentTempArray = array();
            $typeofincidentTempArray['name'] = $typeofIncdientlist[$typeofincidentcount]['incidentName'];
            if ($typeofincidentcount > count($incidentCountByIncidentWise) - 1) {
                $typeofincidentTempArray['y'] = 0;
            } else {
                $typeofincidentTempArray['y'] = (int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
            }
            array_push($typeofincidentCountarray, $typeofincidentTempArray);
        }
        //Find type of cuase Count
        $typeofCauselist = $em->createQueryBuilder()
            ->select('tc.id', 'tc.causeName')
            ->from('DashboardBundle:TypeofCause', 'tc')
            ->getQuery()
            ->getResult();
        $incidnentTypeofcuaseList = $em->createQueryBuilder()
            ->select('count(i.id) as typeofcauseCount')
            ->from('DashboardBundle:Incident', 'i')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear', $currentYear)
            ->groupBy('tc.id')
            ->getQuery()
            ->getResult();
        //Find Number of incident for particular Incident
        $incidentCountbyTypeofCause = array();
        for ($typeofcaausecount = 0; $typeofcaausecount < count($typeofCauselist); $typeofcaausecount++) {
            $typeofcauseTempArray = array();
            $typeofcauseTempArray['name'] = $typeofCauselist[$typeofcaausecount]['causeName'];
            if ($typeofcaausecount > count($incidnentTypeofcuaseList) - 1) {
                $typeofcauseTempArray['y'] = 0;
            } else {
                $typeofcauseTempArray['y'] = (int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
            }
            array_push($incidentCountbyTypeofCause, $typeofcauseTempArray);
        }

        $graphRecord = $em->createQueryBuilder()
            ->select('count(i.id) as shipWiseCount', 's.shipName', 'if.dateofIncident')
            ->from('DashboardBundle:Incident', 'i')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear', $currentYear)
            ->groupBy('s.id')
            ->orderBy('s.id')
            ->getQuery()
            ->getResult();
        $serverityClassfication = $em->createQueryBuilder()
            ->select('count(i.id) as countValue')
            ->from('DashboardBundle:Incident', 'i')
            ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
            ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
            ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
            ->andwhere('tc.severityClassification = :statusValue')
            ->andWhere('YEAR(if.dateofIncident) =:currentYear')
            ->setParameter('currentYear', $currentYear)
            ->setParameter('statusValue', 3)
            ->orderBy('i.id')
            ->getQuery()
            ->getResult();
        $vesselList = array();
        $vesselwiseincidentCount = array();
        $incidentclosedVessleCount = array();
        $incidentopenStatusCount = array();
        $typeofcaausecountvesslewise = array();
        //Find Number of incident for particular Vessel
        $ship_typeofcuaselist = array();
        for ($shipCount = 0; $shipCount < count($vesselname); $shipCount++) {
            //array_push($vesselList, $VesselList[$shipCount]['shipName']);
            $incidentCountByIncidentWiseWithVesselWise = array();
            if ($shipCount > count($graphRecord) - 1) {
                array_push($vesselwiseincidentCount, 0);
                for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                        ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                }
            } else {
                array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['shipWiseCount']);
                for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                        ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                }
            }


            array_push($typeofcaausecountvesslewise, array_sum($incidentCountByIncidentWiseWithVesselWise));
            array_push($ship_typeofcuaselist, $incidentCountByIncidentWiseWithVesselWise);
        }

        } else {
            for ($i = 0; $i < count($shipid); $i++) {
                $VesselList = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$i])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselList);
            }
            for ($j = 0; $j < count($vesselname); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $vesselname[$j][0]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $vesselname[$j][0]['shipName']);
            }
            //Find type of Incident Count
            for($k = 0; $k<count($vesselname); $k++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);
                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

            }
            $typeofIncdientlist = $em->createQueryBuilder()
                ->select('ti.id', 'ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            $incidentCountByIncidentWise = $em->createQueryBuilder()
                ->select('count(i.id) as typeofincidentCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->orderBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $typeofincidentCountarray = array();
            for ($typeofincidentcount = 0; $typeofincidentcount < count($typeofIncdientlist); $typeofincidentcount++) {
                $typeofincidentTempArray = array();
                $typeofincidentTempArray['name'] = $typeofIncdientlist[$typeofincidentcount]['incidentName'];
                if ($typeofincidentcount > count($incidentCountByIncidentWise) - 1) {
                    $typeofincidentTempArray['y'] = 0;
                } else {
                    $typeofincidentTempArray['y'] = (int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
                }
                array_push($typeofincidentCountarray, $typeofincidentTempArray);
            }
            //Find type of cuase Count
            $typeofCauselist = $em->createQueryBuilder()
                ->select('tc.id', 'tc.causeName')
                ->from('DashboardBundle:TypeofCause', 'tc')
                ->getQuery()
                ->getResult();
            $incidnentTypeofcuaseList = $em->createQueryBuilder()
                ->select('count(i.id) as typeofcauseCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $incidentCountbyTypeofCause = array();
            for ($typeofcaausecount = 0; $typeofcaausecount < count($typeofCauselist); $typeofcaausecount++) {
                $typeofcauseTempArray = array();
                $typeofcauseTempArray['name'] = $typeofCauselist[$typeofcaausecount]['causeName'];
                if ($typeofcaausecount > count($incidnentTypeofcuaseList) - 1) {
                    $typeofcauseTempArray['y'] = 0;
                } else {
                    $typeofcauseTempArray['y'] = (int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
                }
                array_push($incidentCountbyTypeofCause, $typeofcauseTempArray);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('count(i.id) as shipWiseCount', 's.shipName', 'if.dateofIncident')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $serverityClassfication = $em->createQueryBuilder()
                ->select('count(i.id) as countValue')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andwhere('tc.severityClassification = :statusValue')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('statusValue', 3)
                ->orderBy('i.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $typeofcaausecountvesslewise = array();
            //Find Number of incident for particular Vessel
            $ship_typeofcuaselist = array();
            for ($shipCount = 0; $shipCount <count($vesselname); $shipCount++) {
                array_push($vesselList, $vesselname[$shipCount][0]['shipName']);
                $incidentCountByIncidentWiseWithVesselWise = array();
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['shipWiseCount']);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                }

                array_push($typeofcaausecountvesslewise, array_sum($incidentCountByIncidentWiseWithVesselWise));
                array_push($ship_typeofcuaselist, $incidentCountByIncidentWiseWithVesselWise);
            }
        }

            $response = new Response($this->serialize(['incidentOpenStaus' => array_sum($incidentopenStatusCount),
                'totalnoIncidnets' => array_sum($vesselwiseincidentCount), 'currentYear' => $currentYear,'vesselListObject'=> $vesselListObject,
                'graphData' => $vesselwiseincidentCount, 'incidentclosedVessleCount' => $incidentclosedVessleCount,
                'incidentopenStatusCount' => $incidentopenStatusCount, 'serverityClassfication' => $serverityClassfication[0]['countValue'],
                'typeofIncidentWiseIncidents' => $typeofincidentCountarray, 'typeofCausewiseIncident' => $incidentCountbyTypeofCause,
                'typeofCauseList' => $typeofCauselist, 'vesselwisetypeofcause' => $ship_typeofcuaselist, 'typeofcaausecountvesslewise' => $typeofcaausecountvesslewise,'vessel'=>$vesselname,'incidentCount'=>$incidentCount,
                'incidentClosed'=>$incidentClosed,'incidentOpened'=>$incidentOpened ]), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);


    }



    /**
     * @Rest\post("/pdfopenclosed",name="openclosed_pdfreport")
     */
    public function openclosePdfAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $currentYear=$request->request->get('yearobj');
        $shipid=$request->request->get('shipname');
        $select_checkedall=$request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();

        $incidentCountByIncidentWise = array();
        $incidentCount = array();
        $incidentOpened = array();
        $incidentClosed = array();
        $vesseldetails = array();
        $incidentopenStatusCount=array();
        $incidentclosedVessleCount=array();
        $incidentdata=array();
        $vesselname=array();


        if($select_checkedall == 'true') {
            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();

            for($j=0;$j<count($VesselDetail);$j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }


            for($i=0;$i<count($VesselDetail);$i++) {
                array_push($vesseldetails,$VesselDetail[$i]['shipName']);
                $incidentCountQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();


                array_push( $incidentdata,(int)$incidentCountQuery[0]['incidentCount']);

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();



                    array_push($incidentopenStatusCount,(int)$incidentOpenedQuery[0]['incidentOpened']);

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                    array_push($incidentclosedVessleCount,(int)$incidentClosedQuery[0]['incidentClosed']);

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for($j=0;$j<count($incidentName);$j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id',$VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise,$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise,$incidentCountByIncidentWiseWithVesselWise);
            }

        } else {
            for($j=0;$j<count($shipid);$j++){
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id','s.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                array_push($vesseldetails, $vesselname[$i][0]['shipName']);
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();
                array_push($incidentdata, (int)$incidentCountQuery[0]['incidentCount']);

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',  $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();
                array_push($incidentopenStatusCount, (int)$incidentOpenedQuery[0]['incidentOpened']);

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',  $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentclosedVessleCount, (int)$incidentClosedQuery[0]['incidentClosed']);

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id',  $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }
        }
        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $openclosedGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "column"),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('column' => array(
                "pointPadding"=> 0.2,
                "borderWidth"=> 0,
                'cursor'=> 'pointer',

            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('shadow'=>false, 'borderWidth'=> 0,),



            'series' => array(
                array('name' => 'Number of Incident','data' => $incidentdata),

            array('name' => 'Pending Incidents','data' => $incidentopenStatusCount),
                array('name' => 'Closed Incidents','data' => $incidentclosedVessleCount),
             ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            'xAxis' => array('categories' => $vesseldetails,'crosshair'=> true),
            'yAxis' => array('text' => '', 'min' => 0)

        );
        $kpiJsonFileData = json_encode($openclosedGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $currentYear . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $currentYear . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $currentYear . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);

        $customerListDesign =$this->renderView('VesselBundle:Default:openclosedpdf.html.twig', array(
                    'shipDetails' => $vesselname,
                    'incidentCount' => $incidentCount,
                    'incidentOpened' => $incidentOpened,
                    'incidentClosed' => $incidentClosed,
                    'incidentName' => $incidentName,
                    'vesseldetails' =>$vesseldetails,
                    'incidentCountByIncidentWise' => $incidentCountByIncidentWise,
                    'incidentopenStatusCount' => $incidentopenStatusCount,
                    'incidentclosedVessleCount' =>$incidentclosedVessleCount,
                    'incidentdata'=>$incidentdata,
                    'imageSource' => 'KPI-' .  $currentYear . $todayTime . '.png '


        ));


        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign,077,true);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $response = new Response();
        $response->setContent($customerListDesign);
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;

    }






    /**
     * @Rest\post("/offhire_pdf",name="pdf_report")
     */
    public function PdfAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$reportObject = $this->IncidentReportAction($request, 'sendReport');
        $currentYear=$request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $incidentCountByIncidentWise = array();
        $offhirecost = array();
        $incidentCount = array();
        $vesselname = array();
        $listrecord = array();


        if ($select_checkedall == 'true') {
            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();
            for ($i = 0; $i < count($VesselDetail); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);


                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName', 's.id', 'if.dateofIncident', 'ic.offHireDays', 'ic.incidentFinalCostUSD')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->Where('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $incidentcostcount = array();
            $inicdentoffhiredays = array();
            $graphseriesValue = array();
            //Find Number of incident for particular Vessel
            for ($shipCount = 0; $shipCount < count($graphRecord); $shipCount++) {
                $graphseriesTemp = array();
                $graphseriesTemp['name'] = $graphRecord[$shipCount]['shipName'];
                array_push($vesselList, $VesselDetail[$shipCount]['shipName']);
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['numberofincidents']);
                    array_push($incidentcostcount, (int)$graphRecord[$shipCount]['totalcost']);
                    $graphseriesTemp['y'] = (int)$graphRecord[$shipCount]['totalcost'];
                    array_push($inicdentoffhiredays, (int)$graphRecord[$shipCount]['totaloffhiredays']);
                }
                array_push($graphseriesValue, $graphseriesTemp);
            }

        } else {
            for ($j = 0; $j < count($shipid); $j++) {
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);


                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName', 's.id', 'if.dateofIncident', 'ic.offHireDays', 'ic.incidentFinalCostUSD')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->Where('YEAR(if.dateofIncident) =:currentYear')
                ->andWhere('if.shipId = :ship_id')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('ship_id', $vesselname[$i])
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery();


            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $incidentcostcount = array();
            $inicdentoffhiredays = array();
            $graphseriesValue = array();
            //Find Number of incident for particular Vessel
            for ($shipCount = 0; $shipCount < count($graphRecord); $shipCount++) {
                $graphseriesTemp = array();
                $graphseriesTemp['name'] = $graphRecord[$shipCount]['shipName'];
                //array_push($vesselList, $vesselname[$shipCount]['shipName']);
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['numberofincidents']);
                    array_push($incidentcostcount, (int)$graphRecord[$shipCount]['totalcost']);
                    $graphseriesTemp['y'] = (int)$graphRecord[$shipCount]['totalcost'];
                    array_push($inicdentoffhiredays, (int)$graphRecord[$shipCount]['totaloffhiredays']);
                }
                array_push($graphseriesValue, $graphseriesTemp);
            }


        }

        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $incidentGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "pie", 'plotBackgroundColor'=> null, 'plotBorderWidth'=> null,'plotShadow'=> false,'width'=> 950),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('pie' => array(
                'allowPointSelect'=>true,
                'cursor'=> 'pointer',
                "dataLabels" => array(
                    "enabled" => true,
                    "format"=> '<b>{point.name}</b>:$ {point.y}',
                )
            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('pointFormat'=> '{series.name}: <b>$ {series.y}</b>'),
        
                        
            
            'series' => array(
                array('name' => 'Total Cost', 'colorByPoint'=> true,'showInLegend' => false,'data' => $graphseriesValue)
            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            
        );
        $kpiJsonFileData = json_encode($incidentGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign =(string) $this->renderView('VesselBundle:Default:index.html.twig', array(
            'shipobj' => $VesselDetail,
            'totalincidnets' =>array_sum($vesselwiseincidentCount) ,'totalcost'=>array_sum($incidentcostcount),
            'totaloffhiredays'=>array_sum($inicdentoffhiredays),'currentYear'=>$currentYear,'vesselList'=>$vesselList,
            'graphData'=>$vesselwiseincidentCount,'incidentclosedVessleCount'=>$incidentclosedVessleCount,
            'incidentopenStatusCount'=>$incidentopenStatusCount,'offhiredayscountshipwise'=>$inicdentoffhiredays,
            'incidentcostshipwise'=>$incidentcostcount,'vesselistObject'=>$VesselDetail,'graphDataDetails'=>$graphRecord,
            'graphseriesValue'=>$graphseriesValue, 'imageSource' => 'KPI-' .  $currentYear . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $response = new Response($fileName);
        $response->setContent($content);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }



    /**
     * @Rest\post("/typeofincidentreport",name="get_incidentwisereport")
     */
    public function incidentwiseReportAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $typeIncidentName=$request->request->get('incidentname');
        $select_checkedall=$request->request->get('checkedall');
        $incidentvalues = array();
        $incident = array();
        $incidentwisename= array();
        if ($select_checkedall == 'true') {
            $incidentName = $em->createQueryBuilder()
                ->select('ti.id, ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            for($j=0;$j<count($incidentName);$j++) {
                $incident_Name = $em->createQueryBuilder()
                    ->select('ti.id, ti.incidentName')
                    ->from('DashboardBundle:TypeofIncident', 'ti')
                    ->Where('ti.id =:incidentid')
                    ->setParameter('incidentid', $incidentName[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($incidentwisename, $incident_Name);
            }
            for ($i = 0; $i < count($incidentName); $i++) {
                $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentWiseCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->Where('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('typeofIncdientId', $incidentName[$i]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($incidentvalues, (int)$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                array_push($incident,$incidentName[$i]['incidentName']);
               
            }

        }
        else{
            for($i=0;$i<count($typeIncidentName);$i++){
                $incidentName = $em->createQueryBuilder()
                    ->select('ti.id, ti.incidentName')
                    ->from('DashboardBundle:TypeofIncident', 'ti')
                    ->Where('ti.id =:incidentid')
                    ->setParameter('incidentid', $typeIncidentName[$i])
                    ->getQuery()
                    ->getResult();
                array_push($incidentwisename,$incidentName);
            }
            for ($j = 0; $j < count($incidentwisename); $j++) {
                $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentWiseCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->Where('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('typeofIncdientId', $incidentwisename[$j])
                    ->getQuery()
                    ->getResult();
                array_push($incidentvalues, (int)$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                array_push($incident,$incidentwisename[$j][0]['incidentName']);
            }
    }
        $response = new Response($this->serialize(
            [
                'incidentvalues' => $incidentvalues,
                'incidentName' => $incidentwisename,
                'currentYear' => $currentYear,
                'incident'=> $incident,
            ]), Response::HTTP_CREATED);
        return $response;

    }



    /**
     * @Rest\post("/pdfoffhireReport",name="openClosed_report")
     */
    public function opencloseReportAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $currentYear=$request->request->get('yearobj');
        $shipid=$request->request->get('shipname');
        $select_checkedall=$request->request->get('checkedall');

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();

        $incidentCountByIncidentWise = array();
        $incidentCount = array();
        $incidentOpened = array();
        $incidentClosed = array();
        $vesseldetails = array();
        $incidentopenStatusCount=array();
        $incidentclosedVessleCount=array();
        $incidentdata=array();
        $vesselname=array();


        if($select_checkedall == 'true') {
            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();

            for($j=0;$j<count($VesselDetail);$j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }


            for($i=0;$i<count($VesselDetail);$i++) {
                array_push($vesseldetails,$VesselDetail[$i]['shipName']);
                $incidentCountQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();


                array_push( $incidentdata,(int)$incidentCountQuery[0]['incidentCount']);

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();



                array_push($incidentopenStatusCount,(int)$incidentOpenedQuery[0]['incidentOpened']);

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentclosedVessleCount,(int)$incidentClosedQuery[0]['incidentClosed']);

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for($j=0;$j<count($incidentName);$j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id',$VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise,$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise,$incidentCountByIncidentWiseWithVesselWise);
            }

        } else {
            for($j=0;$j<count($shipid);$j++){
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id','s.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                array_push($vesseldetails, $vesselname[$i][0]['shipName']);
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();
                array_push($incidentdata, (int)$incidentCountQuery[0]['incidentCount']);

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',  $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();
                array_push($incidentopenStatusCount, (int)$incidentOpenedQuery[0]['incidentOpened']);

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',  $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentclosedVessleCount, (int)$incidentClosedQuery[0]['incidentClosed']);

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id',  $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }
        }

        $response = new JsonResponse();

        $response = new Response(
            $this->serialize(
                [
                    'shipDetails' => $vesselname,
                    'incidentCount' => $incidentCount,
                    'incidentOpened' => $incidentOpened,
                    'incidentClosed' => $incidentClosed,
                    'incidentName' => $incidentName,
                    'vesseldetails' =>$vesseldetails,
                    'incidentCountByIncidentWise' => $incidentCountByIncidentWise,
                    'incidentopenStatusCount' => $incidentopenStatusCount,
                    'incidentclosedVessleCount' =>$incidentclosedVessleCount,
                    'incidentdata'=>$incidentdata,
                ]
            ), Response::HTTP_CREATED);

        return $response;
    }





    /**
     * @Rest\post("/pdfincidentwise",name="incidentwise_pdfreport")
     */
    public function pdfincidentwiseAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $typeIncidentName=$request->request->get('incidentname');
        $select_checkedall=$request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");
        $incidentvalues = array();
        $incident = array();
        $incidentwisename= array();
        if ($select_checkedall == 'true') {
            $incidentName = $em->createQueryBuilder()
                ->select('ti.id, ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            for($j=0;$j<count($incidentName);$j++) {
                $incident_Name = $em->createQueryBuilder()
                    ->select('ti.id, ti.incidentName')
                    ->from('DashboardBundle:TypeofIncident', 'ti')
                    ->Where('ti.id =:incidentid')
                    ->setParameter('incidentid', $incidentName[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($incidentwisename, $incident_Name);
            }
            for ($i = 0; $i < count($incidentName); $i++) {
                $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentWiseCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->Where('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('typeofIncdientId', $incidentName[$i]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($incidentvalues, (int)$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                array_push($incident,$incidentName[$i]['incidentName']);

            }

        }
        else{
            for($i=0;$i<count($typeIncidentName);$i++){
                $incidentName = $em->createQueryBuilder()
                    ->select('ti.id, ti.incidentName')
                    ->from('DashboardBundle:TypeofIncident', 'ti')
                    ->Where('ti.id =:incidentid')
                    ->setParameter('incidentid', $typeIncidentName[$i])
                    ->getQuery()
                    ->getResult();
                array_push($incidentwisename,$incidentName);
            }
            for ($j = 0; $j < count($incidentwisename); $j++) {
                $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentWiseCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->Where('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('typeofIncdientId', $incidentwisename[$j])
                    ->getQuery()
                    ->getResult();
                array_push($incidentvalues, (int)$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                array_push($incident,$incidentwisename[$j][0]['incidentName']);
            }
        }

        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $incidentwisegraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "column",'options3d'=>array('enabled'=> true, 'alpha'=> 10, 'beta'=> 25,'depth'=>70

            )),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('column' => array(
                "pointPadding"=> 0.2,
                "borderWidth"=> 0,
                "depth"=>25,

            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('shadow'=>false, 'borderWidth'=> 0,'backgroundColor'=> 'rgba(219,219,216,0.8)'),



            'series' => array(
                array('name' => 'Number of Incident','data' => $incidentvalues,'colorByPoint'=>true,),

            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            'xAxis' => array('categories' => $incident,'crosshair'=> true),
            'yAxis' => array('text' => '', 'min' => 0)

        );
        $kpiJsonFileData = json_encode($incidentwisegraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign =(string) $this->renderView('VesselBundle:Default:incidentwisepdf.html.twig', array(
            'incidentvalues' => $incidentvalues,
            'incidentName' => $incidentwisename,
            'currentYear' => $currentYear,
            'incident'=> $incident,
            'imageSource' => 'KPI-' .  $todayDate . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $response = new Response($fileName);
        $response->setContent($content);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }


    /**
     * @Rest\post("/pdfvesselreport",name="vesselwise_pdfreport")
     */
    public function pdfvesselwiseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");


        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();

        $incidentCountByIncidentWise = array();
        $incidentCount = array();
        $incidentOpened = array();
        $incidentClosed = array();
        $vesselname = array();

        if ($select_checkedall == 'true') {

            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();

            for ($j = 0; $j < count($VesselDetail); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }

            for ($i = 0; $i < count($VesselDetail); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);

            }

        } else {
            for ($j = 0; $j < count($shipid); $j++) {
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($k = 0; $k < count($incidentName); $k++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$k]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }


        }
        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $incidentGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "pie", 'options3d'=>array('enabled'=>true,'alpha'=>45,'beta')),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('pie' => array(
                'allowPointSelect'=>true,
                'cursor'=> 'pointer',
                'depth'=> '35',
                "dataLabels" => array(
                    "enabled" => true,
                    'format'=> '{point.name}'
                ),
                 'showInLegend'=>true,
            )),
            'title'=> array('text'=> ''),

            //'tooltip' =>array('pointFormat'=> '{series.name}: <b>{point.percentage:.1f}%</b>'),



            'series' => array(
                array('name' => 'number of incident','data' => $incidentCountByIncidentWise,'colorByPoint'=>true,),

            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),

        );
        $kpiJsonFileData = json_encode($incidentGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign =$this->renderView('VesselBundle:Default:vesselwisepdf.html.twig', array(
            'shipDetails' => $vesselname,
            'incidentCount' => $incidentCount,
            'incidentOpened' => $incidentOpened,
            'incidentClosed' => $incidentClosed,
            'incidentName' => $incidentName,
            'incidentCountByIncidentWise' => $incidentCountByIncidentWise
        ,   'imageSource' => 'KPI-' .  $currentYear . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign,077,true);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $response = new Response();
        $response->setContent($content);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }



    /**
     * @Rest\post("/severitywisepdf_report",name="severity_pdfreport")
     */
    public function pdfseveritywiseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");
        $userobject = $this->getUser();
        $companyId = $userobject->getCompanyId();
        $vesselname = array();
        $incidentCount = array();
        $incidentClosed =array();
        $incidentOpened =array();
        $vesselListObject=array();


        if ($select_checkedall == 'true') {
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->getQuery()
                ->getResult();
            for ($k = 0; $k < count($VesselList); $k++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselList[$k]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $VesselList[$k]['shipName']);
            }

            for ($j = 0; $j < count($VesselList); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselList[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }
            for($shipcount = 0; $shipcount<count($VesselList); $shipcount++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);
                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

            }
            //Find type of Incident Count
            $typeofIncdientlist = $em->createQueryBuilder()
                ->select('ti.id', 'ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            $incidentCountByIncidentWise = $em->createQueryBuilder()
                ->select('count(i.id) as typeofincidentCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->orderBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $typeofincidentCountarray = array();
            for ($typeofincidentcount = 0; $typeofincidentcount < count($typeofIncdientlist); $typeofincidentcount++) {
                $typeofincidentTempArray = array();
                $typeofincidentTempArray['name'] = $typeofIncdientlist[$typeofincidentcount]['incidentName'];
                if ($typeofincidentcount > count($incidentCountByIncidentWise) - 1) {
                    $typeofincidentTempArray['y'] = 0;
                } else {
                    $typeofincidentTempArray['y'] = (int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
                }
                array_push($typeofincidentCountarray, $typeofincidentTempArray);
            }
            //Find type of cuase Count
            $typeofCauselist = $em->createQueryBuilder()
                ->select('tc.id', 'tc.causeName')
                ->from('DashboardBundle:TypeofCause', 'tc')
                ->getQuery()
                ->getResult();
            $incidnentTypeofcuaseList = $em->createQueryBuilder()
                ->select('count(i.id) as typeofcauseCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $incidentCountbyTypeofCause = array();
            for ($typeofcaausecount = 0; $typeofcaausecount < count($typeofCauselist); $typeofcaausecount++) {
                $typeofcauseTempArray = array();
                $typeofcauseTempArray['name'] = $typeofCauselist[$typeofcaausecount]['causeName'];
                if ($typeofcaausecount > count($incidnentTypeofcuaseList) - 1) {
                    $typeofcauseTempArray['y'] = 0;
                } else {
                    $typeofcauseTempArray['y'] = (int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
                }
                array_push($incidentCountbyTypeofCause, $typeofcauseTempArray);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('count(i.id) as shipWiseCount', 's.shipName', 'if.dateofIncident')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $serverityClassfication = $em->createQueryBuilder()
                ->select('count(i.id) as countValue')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andwhere('tc.severityClassification = :statusValue')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('statusValue', 3)
                ->orderBy('i.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $typeofcaausecountvesslewise = array();
            //Find Number of incident for particular Vessel
            $ship_typeofcuaselist = array();
            for ($shipCount = 0; $shipCount < count($vesselname); $shipCount++) {
                //array_push($vesselList, $VesselList[$shipCount]['shipName']);
                $incidentCountByIncidentWiseWithVesselWise = array();
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['shipWiseCount']);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                }


                array_push($typeofcaausecountvesslewise, array_sum($incidentCountByIncidentWiseWithVesselWise));
                array_push($ship_typeofcuaselist, $incidentCountByIncidentWiseWithVesselWise);
            }

        } else {
            for ($i = 0; $i < count($shipid); $i++) {
                $VesselList = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$i])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselList);
            }
            for ($j = 0; $j < count($vesselname); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $vesselname[$j][0]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $vesselname[$j][0]['shipName']);
            }
            //Find type of Incident Count
            for($k = 0; $k<count($vesselname); $k++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);
                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

            }
            $typeofIncdientlist = $em->createQueryBuilder()
                ->select('ti.id', 'ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            $incidentCountByIncidentWise = $em->createQueryBuilder()
                ->select('count(i.id) as typeofincidentCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->orderBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $typeofincidentCountarray = array();
            for ($typeofincidentcount = 0; $typeofincidentcount < count($typeofIncdientlist); $typeofincidentcount++) {
                $typeofincidentTempArray = array();
                $typeofincidentTempArray['name'] = $typeofIncdientlist[$typeofincidentcount]['incidentName'];
                if ($typeofincidentcount > count($incidentCountByIncidentWise) - 1) {
                    $typeofincidentTempArray['y'] = 0;
                } else {
                    $typeofincidentTempArray['y'] = (int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
                }
                array_push($typeofincidentCountarray, $typeofincidentTempArray);
            }
            //Find type of cuase Count
            $typeofCauselist = $em->createQueryBuilder()
                ->select('tc.id', 'tc.causeName')
                ->from('DashboardBundle:TypeofCause', 'tc')
                ->getQuery()
                ->getResult();
            $incidnentTypeofcuaseList = $em->createQueryBuilder()
                ->select('count(i.id) as typeofcauseCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $incidentCountbyTypeofCause = array();
            for ($typeofcaausecount = 0; $typeofcaausecount < count($typeofCauselist); $typeofcaausecount++) {
                $typeofcauseTempArray = array();
                $typeofcauseTempArray['name'] = $typeofCauselist[$typeofcaausecount]['causeName'];
                if ($typeofcaausecount > count($incidnentTypeofcuaseList) - 1) {
                    $typeofcauseTempArray['y'] = 0;
                } else {
                    $typeofcauseTempArray['y'] = (int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
                }
                array_push($incidentCountbyTypeofCause, $typeofcauseTempArray);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('count(i.id) as shipWiseCount', 's.shipName', 'if.dateofIncident')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $serverityClassfication = $em->createQueryBuilder()
                ->select('count(i.id) as countValue')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andwhere('tc.severityClassification = :statusValue')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('statusValue', 3)
                ->orderBy('i.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $typeofcaausecountvesslewise = array();
            //Find Number of incident for particular Vessel
            $ship_typeofcuaselist = array();
            for ($shipCount = 0; $shipCount <count($vesselname); $shipCount++) {
                array_push($vesselList, $vesselname[$shipCount][0]['shipName']);
                $incidentCountByIncidentWiseWithVesselWise = array();
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['shipWiseCount']);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                }

                array_push($typeofcaausecountvesslewise, array_sum($incidentCountByIncidentWiseWithVesselWise));
                array_push($ship_typeofcuaselist, $incidentCountByIncidentWiseWithVesselWise);
            }
        }

        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';
        $severityGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "column"),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('column' => array(
                "pointPadding"=> 0.2,
                "borderWidth"=> 0,
            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('shadow'=>false, 'borderWidth'=> 0,),



            'series' => array(
                array('name' => 'severity','data' =>$typeofcaausecountvesslewise),

            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            'xAxis' => array('categories' => $vesselListObject,'crosshair'=> true),
            'yAxis' => array('text' => '', 'min' => 0)

        );
        $kpiJsonFileData = json_encode($severityGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign = $this->renderView('VesselBundle:Default:severitypdf.html.twig', array(
            'totalnoIncidnets' => array_sum($vesselwiseincidentCount), 'currentYear' => $currentYear,'vesselListObject'=> $vesselListObject,
            'graphData' => $vesselwiseincidentCount, 'incidentclosedVessleCount' => $incidentclosedVessleCount,
            'incidentopenStatusCount' => $incidentopenStatusCount, 'serverityClassfication' => $serverityClassfication[0]['countValue'],
            'typeofIncidentWiseIncidents' => $typeofincidentCountarray, 'typeofCausewiseIncident' => $incidentCountbyTypeofCause,
            'typeofCauseList' => $typeofCauselist, 'vesselwisetypeofcause' => $ship_typeofcuaselist, 'typeofcaausecountvesslewise' => $typeofcaausecountvesslewise,'vessel'=>$vesselname,'incidentCount'=>$incidentCount,
            'incidentClosed'=>$incidentClosed,'incidentOpened'=>$incidentOpened,'imageSource' => 'KPI-' .  $todayDate . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign,0777,true);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $response = new Response();
        $response->setContent($content);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }

    /**
     * @Rest\post("/sendreport_offhire",name="send_report")
     */
    public function sendReportoffhireAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear=$request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();
        $incidentCountByIncidentWise = array();
        $offhirecost = array();
        $incidentCount = array();
        $vesselname = array();
        $listrecord = array();


        if ($select_checkedall == 'true') {
            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();
            for ($i = 0; $i < count($VesselDetail); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);


                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName', 's.id', 'if.dateofIncident', 'ic.offHireDays', 'ic.incidentFinalCostUSD')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->Where('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $incidentcostcount = array();
            $inicdentoffhiredays = array();
            $graphseriesValue = array();
            //Find Number of incident for particular Vessel
            for ($shipCount = 0; $shipCount < count($graphRecord); $shipCount++) {
                $graphseriesTemp = array();
                $graphseriesTemp['name'] = $graphRecord[$shipCount]['shipName'];
                array_push($vesselList, $VesselDetail[$shipCount]['shipName']);
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['numberofincidents']);
                    array_push($incidentcostcount, (int)$graphRecord[$shipCount]['totalcost']);
                    $graphseriesTemp['y'] = (int)$graphRecord[$shipCount]['totalcost'];
                    array_push($inicdentoffhiredays, (int)$graphRecord[$shipCount]['totaloffhiredays']);
                }
                array_push($graphseriesValue, $graphseriesTemp);
            }

        } else {
            for ($j = 0; $j < count($shipid); $j++) {
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);


                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id', $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('sum(ic.incidentFinalCostUSD) as totalcost,sum(ic.offHireDays) as totaloffhiredays,count(i.id) as numberofincidents,s.shipName', 's.id', 'if.dateofIncident', 'ic.offHireDays', 'ic.incidentFinalCostUSD')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentCost', 'ic', 'with', 'i.id = ic.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->Where('YEAR(if.dateofIncident) =:currentYear')
                ->andWhere('if.shipId = :ship_id')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('ship_id', $vesselname[$i])
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery();


            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $incidentcostcount = array();
            $inicdentoffhiredays = array();
            $graphseriesValue = array();
            //Find Number of incident for particular Vessel
            for ($shipCount = 0; $shipCount < count($graphRecord); $shipCount++) {
                $graphseriesTemp = array();
                $graphseriesTemp['name'] = $graphRecord[$shipCount]['shipName'];
                //array_push($vesselList, $vesselname[$shipCount]['shipName']);
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['numberofincidents']);
                    array_push($incidentcostcount, (int)$graphRecord[$shipCount]['totalcost']);
                    $graphseriesTemp['y'] = (int)$graphRecord[$shipCount]['totalcost'];
                    array_push($inicdentoffhiredays, (int)$graphRecord[$shipCount]['totaloffhiredays']);
                }
                array_push($graphseriesValue, $graphseriesTemp);
            }


        }

        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $incidentGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "pie", 'plotBackgroundColor'=> null, 'plotBorderWidth'=> null,'plotShadow'=> false,'width'=> 950),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('pie' => array(
                'allowPointSelect'=>true,
                'cursor'=> 'pointer',
                "dataLabels" => array(
                    "enabled" => true,
                    "format"=> '<b>{point.name}</b>:$ {point.y}',
                )
            )),
            'title'=> array('text'=> ''),
            'credits'=>array('enabled'=>false),

            'tooltip' =>array('pointFormat'=> '{series.name}: <b>$ {series.y}</b>'),



            'series' => array(
                array('name' => 'Total Cost', 'colorByPoint'=> true,'showInLegend' => false,'data' => $graphseriesValue)
            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),

        );
        $kpiJsonFileData = json_encode($incidentGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign =$this->renderView('VesselBundle:Default:index.html.twig', array(
            'shipobj' => $VesselDetail,
            'totalincidnets' =>array_sum($vesselwiseincidentCount) ,'totalcost'=>array_sum($incidentcostcount),
            'totaloffhiredays'=>array_sum($inicdentoffhiredays),'currentYear'=>$currentYear,'vesselList'=>$vesselList,
            'graphData'=>$vesselwiseincidentCount,'incidentclosedVessleCount'=>$incidentclosedVessleCount,
            'incidentopenStatusCount'=>$incidentopenStatusCount,'offhiredayscountshipwise'=>$inicdentoffhiredays,
            'incidentcostshipwise'=>$incidentcostcount,'vesselistObject'=>$VesselDetail,'graphDataDetails'=>$graphRecord,
            'graphseriesValue'=>$graphseriesValue, 'imageSource' => 'KPI-' .  $currentYear . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $userMailId = $request->request->get('clientMail');
        $commentBox = $request->request->get('textboxvalue');
        $mailidarray = array();
        if (filter_var($userMailId, FILTER_VALIDATE_EMAIL)) {
            array_push($mailidarray, $userMailId);
        } else {
            $findsemail = $em->createQueryBuilder()
                ->select('a.useremailid')
                ->from('InitialShippingBundle:EmailUsers', 'a')
                ->join('InitialShippingBundle:EmailGroup', 'b', 'WITH', 'b.id = a.groupid')
                ->where('b.groupname = :sq')
                ->ORwhere('a.useremailid = :sb')
                ->setParameter('sq', $userMailId)
                ->setParameter('sb', $userMailId)
                ->getQuery()
                ->getResult();
            for ($ma = 0; $ma < count($findsemail); $ma++) {
                array_push($mailidarray, $findsemail[$ma]['emailid']);
            }
        }

             $mailer = $this->container->get('mailer');
             $message = \Swift_Message::newInstance()
                 ->setFrom('starshipping123@gmail.com')
                 ->setTo($userMailId)
                 ->setSubject('OFF-hire cost report')
                 ->setBody($commentBox);
             $message->attach(\Swift_Attachment::fromPath($pdfFilePath)->setFilename($fileName . '.pdf'));
             $mailer->send($message);
            //array_push($mailidarray, $findsemail[$ma]['emailid']);


        $response = new JsonResponse();
        $response->setData(array('updatemsg' => "Report has been send"));
        return $response;

    }




    /**
     * @Rest\post("/sendreportopenclosed",name="send_openclosedreport")
     */
    public function sendreportopenClosePdfAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $currentYear=$request->request->get('yearobj');
        $shipid=$request->request->get('shipname');
        $select_checkedall=$request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");

        $incidentName = $em->createQueryBuilder()
            ->select('ti.id, ti.incidentName')
            ->from('DashboardBundle:TypeofIncident', 'ti')
            ->getQuery()
            ->getResult();

        $incidentCountByIncidentWise = array();
        $incidentCount = array();
        $incidentOpened = array();
        $incidentClosed = array();
        $vesseldetails = array();
        $incidentopenStatusCount=array();
        $incidentclosedVessleCount=array();
        $incidentdata=array();
        $vesselname=array();


        if($select_checkedall == 'true') {
            $VesselDetail = $em->createQueryBuilder()
                ->select('a.id', 'a.shipName')
                ->from('VesselBundle:Shipdetails', 'a')
                ->getQuery()
                ->getResult();

            for($j=0;$j<count($VesselDetail);$j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselDetail[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }


            for($i=0;$i<count($VesselDetail);$i++) {
                array_push($vesseldetails,$VesselDetail[$i]['shipName']);
                $incidentCountQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();


                array_push( $incidentdata,(int)$incidentCountQuery[0]['incidentCount']);

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();



                array_push($incidentopenStatusCount,(int)$incidentOpenedQuery[0]['incidentOpened']);

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery= $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->join('VesselBundle:Shipdetails', 's', 'with', 'i.shipId = s.id')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',$VesselDetail[$i]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentclosedVessleCount,(int)$incidentClosedQuery[0]['incidentClosed']);

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for($j=0;$j<count($incidentName);$j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id',$VesselDetail[$i]['id'])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise,$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise,$incidentCountByIncidentWiseWithVesselWise);
            }

        } else {
            for($j=0;$j<count($shipid);$j++){
                $VesselDetail = $em->createQueryBuilder()
                    ->select('s.id','s.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$j])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselDetail);
            }
            for ($i = 0; $i < count($vesselname); $i++) {
                array_push($vesseldetails, $vesselname[$i][0]['shipName']);
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();
                array_push($incidentdata, (int)$incidentCountQuery[0]['incidentCount']);

                array_push($incidentCount, $incidentCountQuery);

                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',  $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();
                array_push($incidentopenStatusCount, (int)$incidentOpenedQuery[0]['incidentOpened']);

                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id',  $vesselname[$i])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentclosedVessleCount, (int)$incidentClosedQuery[0]['incidentClosed']);

                array_push($incidentClosed, $incidentClosedQuery);

                $incidentCountByIncidentWiseWithVesselWise = array();

                for ($j = 0; $j < count($incidentName); $j++) {
                    $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                        ->select('count(i.id) as incidentWiseCount')
                        ->from('DashboardBundle:IncidentFirstInfo', 'i')
                        ->where('i.shipId = :ship_id ')
                        ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                        ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                        ->setParameter('ship_id',  $vesselname[$i])
                        ->setParameter('currentYear', $currentYear)
                        ->setParameter('typeofIncdientId', $incidentName[$j]['id'])
                        ->getQuery()
                        ->getResult();
                    array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                }
                array_push($incidentCountByIncidentWise, $incidentCountByIncidentWiseWithVesselWise);
            }
        }
        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $openclosedGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "column"),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('column' => array(
                "pointPadding"=> 0.2,
                "borderWidth"=> 0,
                'cursor'=> 'pointer',

            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('shadow'=>false, 'borderWidth'=> 0,),

            'credits'=>array('enabled'=>false),

            'series' => array(
                array('name' => 'Number of Incident','data' => $incidentdata),

                array('name' => 'Pending Incidents','data' => $incidentopenStatusCount),
                array('name' => 'Closed Incidents','data' => $incidentclosedVessleCount),
            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            'xAxis' => array('categories' => $vesseldetails,'crosshair'=> true),
            'yAxis' => array('text' => '', 'min' => 0)

        );
        $kpiJsonFileData = json_encode($openclosedGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $currentYear . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $currentYear . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $currentYear . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);

        $customerListDesign =$this->renderView('VesselBundle:Default:openclosedpdf.html.twig', array(
            'shipDetails' => $vesselname,
            'incidentCount' => $incidentCount,
            'incidentOpened' => $incidentOpened,
            'incidentClosed' => $incidentClosed,
            'incidentName' => $incidentName,
            'vesseldetails' =>$vesseldetails,
            'incidentCountByIncidentWise' => $incidentCountByIncidentWise,
            'incidentopenStatusCount' => $incidentopenStatusCount,
            'incidentclosedVessleCount' =>$incidentclosedVessleCount,
            'incidentdata'=>$incidentdata,
            'imageSource' => 'KPI-' .  $currentYear . $todayTime . '.png '


        ));


        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign,077,true);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $userMailId = $request->request->get('clientMail');
        $commentBox = $request->request->get('textboxvalue');
        $mailidarray = array();
        if (filter_var($userMailId, FILTER_VALIDATE_EMAIL)) {
            array_push($mailidarray, $userMailId);
        } else {
            $findsemail = $em->createQueryBuilder()
                ->select('a.useremailid')
                ->from('InitialShippingBundle:EmailUsers', 'a')
                ->join('InitialShippingBundle:EmailGroup', 'b', 'WITH', 'b.id = a.groupid')
                ->where('b.groupname = :sq')
                ->ORwhere('a.useremailid = :sb')
                ->setParameter('sq', $userMailId)
                ->setParameter('sb', $userMailId)
                ->getQuery()
                ->getResult();
            for ($ma = 0; $ma < count($findsemail); $ma++) {
                array_push($mailidarray, $findsemail[$ma]['emailid']);
            }
        }

        $mailer = $this->container->get('mailer');
        $message = \Swift_Message::newInstance()
            ->setFrom('starshipping123@gmail.com')
            ->setTo($userMailId)
            ->setSubject('open-closed incident report')
            ->setBody($commentBox);
        $message->attach(\Swift_Attachment::fromPath($pdfFilePath)->setFilename($fileName . '.pdf'));
        $mailer->send($message);
        $response = new JsonResponse();
        $response->setData(array('updatemsg' => "Report has been send"));
        return $response;

    }



    /**
     * @Rest\post("/sendincident_report",name="send_incidentwisereport")
     */
    public function sendReportincidentwiseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $typeIncidentName=$request->request->get('incidentname');
        $select_checkedall=$request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");
        $incidentvalues = array();
        $incident = array();
        $incidentwisename= array();
        if ($select_checkedall == 'true') {
            $incidentName = $em->createQueryBuilder()
                ->select('ti.id, ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            for($j=0;$j<count($incidentName);$j++) {
                $incident_Name = $em->createQueryBuilder()
                    ->select('ti.id, ti.incidentName')
                    ->from('DashboardBundle:TypeofIncident', 'ti')
                    ->Where('ti.id =:incidentid')
                    ->setParameter('incidentid', $incidentName[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($incidentwisename, $incident_Name);
            }
            for ($i = 0; $i < count($incidentName); $i++) {
                $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentWiseCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->Where('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('typeofIncdientId', $incidentName[$i]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($incidentvalues, (int)$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                array_push($incident,$incidentName[$i]['incidentName']);

            }

        }
        else{
            for($i=0;$i<count($typeIncidentName);$i++){
                $incidentName = $em->createQueryBuilder()
                    ->select('ti.id, ti.incidentName')
                    ->from('DashboardBundle:TypeofIncident', 'ti')
                    ->Where('ti.id =:incidentid')
                    ->setParameter('incidentid', $typeIncidentName[$i])
                    ->getQuery()
                    ->getResult();
                array_push($incidentwisename,$incidentName);
            }
            for ($j = 0; $j < count($incidentwisename); $j++) {
                $incidentCountByIncidentWiseQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentWiseCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->Where('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.typeofIncdientId = :typeofIncdientId ')
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('typeofIncdientId', $incidentwisename[$j])
                    ->getQuery()
                    ->getResult();
                array_push($incidentvalues, (int)$incidentCountByIncidentWiseQuery[0]['incidentWiseCount']);
                array_push($incident,$incidentwisename[$j][0]['incidentName']);
            }
        }

        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';

        $incidentwisegraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "column",'options3d'=>array('enabled'=> true, 'alpha'=> 10, 'beta'=> 25,'depth'=>70

            )),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('column' => array(
                "pointPadding"=> 0.2,
                "borderWidth"=> 0,
                "depth"=>25,

            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('shadow'=>false, 'borderWidth'=> 0,'backgroundColor'=> 'rgba(219,219,216,0.8)'),

             'credits'=>array('enabled'=>false),

            'series' => array(
                array('name' => 'Number of Incident','data' => $incidentvalues,'colorByPoint'=>true,),

            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            'xAxis' => array('categories' => $incident,'crosshair'=> true),
            'yAxis' => array('text' => '', 'min' => 0)

        );
        $kpiJsonFileData = json_encode($incidentwisegraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign =(string) $this->renderView('VesselBundle:Default:incidentwisepdf.html.twig', array(
            'incidentvalues' => $incidentvalues,
            'incidentName' => $incidentwisename,
            'currentYear' => $currentYear,
            'incident'=> $incident,
            'imageSource' => 'KPI-' .  $todayDate . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $userMailId = $request->request->get('clientMail');
        $commentBox = $request->request->get('textboxvalue');
        $mailidarray = array();
        if (filter_var($userMailId, FILTER_VALIDATE_EMAIL)) {
            array_push($mailidarray, $usermail);
            $mailer = $this->container->get('mailer');
            $message = \Swift_Message::newInstance()
                ->setFrom('starshipping123@gmail.com')
                ->setTo($userMailId)
                ->setSubject('incidentwise report graph')
                ->setBody($commentBox);
            $message->attach(\Swift_Attachment::fromPath($pdfFilePath)->setFilename($fileName . '.pdf'));
            $mailer->send($message);
        } else {
            $findmail = $em->createQueryBuilder()
                ->select('a.useremailid')
                ->from('VesselBundle:EmailUsers', 'a')
                ->join('VesselBundle:EmailGroup', 'b', 'WITH', 'b.id = a.groupid')
                ->where('b.groupname = :groupname')
                ->ORwhere('a.useremailid = :mailid')
                ->setParameter('groupname', $userMailId)
                ->setParameter('mailid', $userMailId)
                ->getQuery()
                ->getResult();
            for ($i = 0; $i < count($findmail); $i++) {
                $mailer = $this->container->get('mailer');
                $message = \Swift_Message::newInstance()
                    ->setFrom('starshipping123@gmail.com')
                    ->setTo($findmail[$i]['useremailid'])
                    ->setSubject('incidentwise report graph')
                    ->setBody($commentBox);
                $message->attach(\Swift_Attachment::fromPath($pdfFilePath)->setFilename($fileName . '.pdf'));
                $mailer->send($message);
                array_push($mailidarray, $findmail[$i]['useremailid']);
            }

        }
        $response = new JsonResponse();
        $response->setData(array('updatemsg' => "Report has been send"));
        return $response;

    }

    /**
     * @Rest\post("/sendSeverityReport",name="send_Severityreport")
     */
    public function sendReportseverityAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentYear = $request->request->get('yearobj');
        $shipid = $request->request->get('shipname');
        $select_checkedall = $request->request->get('checkedall');
        $todayTime = date("H:i:s");
        $todayDate = date("Y-m-d");
        $userobject = $this->getUser();
        $companyId = $userobject->getCompanyId();
        $vesselname = array();
        $incidentCount = array();
        $incidentClosed =array();
        $incidentOpened =array();
        $vesselListObject=array();


        if ($select_checkedall == 'true') {
            $VesselList = $em->createQueryBuilder()
                ->select('s.id', 's.shipName')
                ->from('VesselBundle:Shipdetails', 's')
                ->getQuery()
                ->getResult();
            for ($k = 0; $k < count($VesselList); $k++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselList[$k]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $VesselList[$k]['shipName']);
            }

            for ($j = 0; $j < count($VesselList); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $VesselList[$j]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $Vessel_Detail);
            }
            for($shipcount = 0; $shipcount<count($VesselList); $shipcount++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);
                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $VesselList[$shipcount]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

            }
            //Find type of Incident Count
            $typeofIncdientlist = $em->createQueryBuilder()
                ->select('ti.id', 'ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            $incidentCountByIncidentWise = $em->createQueryBuilder()
                ->select('count(i.id) as typeofincidentCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->orderBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $typeofincidentCountarray = array();
            for ($typeofincidentcount = 0; $typeofincidentcount < count($typeofIncdientlist); $typeofincidentcount++) {
                $typeofincidentTempArray = array();
                $typeofincidentTempArray['name'] = $typeofIncdientlist[$typeofincidentcount]['incidentName'];
                if ($typeofincidentcount > count($incidentCountByIncidentWise) - 1) {
                    $typeofincidentTempArray['y'] = 0;
                } else {
                    $typeofincidentTempArray['y'] = (int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
                }
                array_push($typeofincidentCountarray, $typeofincidentTempArray);
            }
            //Find type of cuase Count
            $typeofCauselist = $em->createQueryBuilder()
                ->select('tc.id', 'tc.causeName')
                ->from('DashboardBundle:TypeofCause', 'tc')
                ->getQuery()
                ->getResult();
            $incidnentTypeofcuaseList = $em->createQueryBuilder()
                ->select('count(i.id) as typeofcauseCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $incidentCountbyTypeofCause = array();
            for ($typeofcaausecount = 0; $typeofcaausecount < count($typeofCauselist); $typeofcaausecount++) {
                $typeofcauseTempArray = array();
                $typeofcauseTempArray['name'] = $typeofCauselist[$typeofcaausecount]['causeName'];
                if ($typeofcaausecount > count($incidnentTypeofcuaseList) - 1) {
                    $typeofcauseTempArray['y'] = 0;
                } else {
                    $typeofcauseTempArray['y'] = (int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
                }
                array_push($incidentCountbyTypeofCause, $typeofcauseTempArray);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('count(i.id) as shipWiseCount', 's.shipName', 'if.dateofIncident')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $serverityClassfication = $em->createQueryBuilder()
                ->select('count(i.id) as countValue')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andwhere('tc.severityClassification = :statusValue')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('statusValue', 3)
                ->orderBy('i.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $typeofcaausecountvesslewise = array();
            //Find Number of incident for particular Vessel
            $ship_typeofcuaselist = array();
            for ($shipCount = 0; $shipCount < count($vesselname); $shipCount++) {
                //array_push($vesselList, $VesselList[$shipCount]['shipName']);
                $incidentCountByIncidentWiseWithVesselWise = array();
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['shipWiseCount']);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                }


                array_push($typeofcaausecountvesslewise, array_sum($incidentCountByIncidentWiseWithVesselWise));
                array_push($ship_typeofcuaselist, $incidentCountByIncidentWiseWithVesselWise);
            }

        } else {
            for ($i = 0; $i < count($shipid); $i++) {
                $VesselList = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $shipid[$i])
                    ->getQuery()
                    ->getResult();
                array_push($vesselname, $VesselList);
            }
            for ($j = 0; $j < count($vesselname); $j++) {
                $Vessel_Detail = $em->createQueryBuilder()
                    ->select('s.id', 's.shipName')
                    ->from('VesselBundle:Shipdetails', 's')
                    ->where('s.id = :ship_id ')
                    ->setParameter('ship_id', $vesselname[$j][0]['id'])
                    ->getQuery()
                    ->getResult();
                array_push($vesselListObject, $vesselname[$j][0]['shipName']);
            }
            //Find type of Incident Count
            for($k = 0; $k<count($vesselname); $k++) {
                $incidentCountQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentCount')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->getQuery()
                    ->getResult();

                array_push($incidentCount, $incidentCountQuery);
                $incidentOpenedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentOpened')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 1)
                    ->getQuery()
                    ->getResult();


                array_push($incidentOpened, $incidentOpenedQuery);

                $incidentClosedQuery = $em->createQueryBuilder()
                    ->select('count(i.id) as incidentClosed')
                    ->from('DashboardBundle:IncidentFirstInfo', 'i')
                    ->where('i.shipId = :ship_id ')
                    ->andWhere('YEAR(i.dateofIncident) =:currentYear')
                    ->andWhere('i.statusofReport = :statusofReport ')
                    ->setParameter('ship_id', $vesselname[$k][0]['id'])
                    ->setParameter('currentYear', $currentYear)
                    ->setParameter('statusofReport', 2)
                    ->getQuery()
                    ->getResult();

                array_push($incidentClosed, $incidentClosedQuery);

            }
            $typeofIncdientlist = $em->createQueryBuilder()
                ->select('ti.id', 'ti.incidentName')
                ->from('DashboardBundle:TypeofIncident', 'ti')
                ->getQuery()
                ->getResult();
            $incidentCountByIncidentWise = $em->createQueryBuilder()
                ->select('count(i.id) as typeofincidentCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:TypeofIncident', 'tc', 'with', 'if.typeofIncdientId = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->orderBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $typeofincidentCountarray = array();
            for ($typeofincidentcount = 0; $typeofincidentcount < count($typeofIncdientlist); $typeofincidentcount++) {
                $typeofincidentTempArray = array();
                $typeofincidentTempArray['name'] = $typeofIncdientlist[$typeofincidentcount]['incidentName'];
                if ($typeofincidentcount > count($incidentCountByIncidentWise) - 1) {
                    $typeofincidentTempArray['y'] = 0;
                } else {
                    $typeofincidentTempArray['y'] = (int)$incidentCountByIncidentWise[$typeofincidentcount]['typeofincidentCount'];
                }
                array_push($typeofincidentCountarray, $typeofincidentTempArray);
            }
            //Find type of cuase Count
            $typeofCauselist = $em->createQueryBuilder()
                ->select('tc.id', 'tc.causeName')
                ->from('DashboardBundle:TypeofCause', 'tc')
                ->getQuery()
                ->getResult();
            $incidnentTypeofcuaseList = $em->createQueryBuilder()
                ->select('count(i.id) as typeofcauseCount')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('tc.id')
                ->getQuery()
                ->getResult();
            //Find Number of incident for particular Incident
            $incidentCountbyTypeofCause = array();
            for ($typeofcaausecount = 0; $typeofcaausecount < count($typeofCauselist); $typeofcaausecount++) {
                $typeofcauseTempArray = array();
                $typeofcauseTempArray['name'] = $typeofCauselist[$typeofcaausecount]['causeName'];
                if ($typeofcaausecount > count($incidnentTypeofcuaseList) - 1) {
                    $typeofcauseTempArray['y'] = 0;
                } else {
                    $typeofcauseTempArray['y'] = (int)$incidnentTypeofcuaseList[$typeofcaausecount]['typeofcauseCount'];
                }
                array_push($incidentCountbyTypeofCause, $typeofcauseTempArray);
            }

            $graphRecord = $em->createQueryBuilder()
                ->select('count(i.id) as shipWiseCount', 's.shipName', 'if.dateofIncident')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('VesselBundle:Shipdetails', 's', 'with', 'if.shipId = s.id')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->groupBy('s.id')
                ->orderBy('s.id')
                ->getQuery()
                ->getResult();
            $serverityClassfication = $em->createQueryBuilder()
                ->select('count(i.id) as countValue')
                ->from('DashboardBundle:Incident', 'i')
                ->join('DashboardBundle:IncidentFirstInfo', 'if', 'with', 'i.id = if.incidentId')
                ->join('DashboardBundle:IncidentDetails', 'ide', 'with', 'i.id = ide.incidentId')
                ->join('DashboardBundle:TypeofCause', 'tc', 'with', 'ide.typeofCause = tc.id')
                ->andwhere('tc.severityClassification = :statusValue')
                ->andWhere('YEAR(if.dateofIncident) =:currentYear')
                ->setParameter('currentYear', $currentYear)
                ->setParameter('statusValue', 3)
                ->orderBy('i.id')
                ->getQuery()
                ->getResult();
            $vesselList = array();
            $vesselwiseincidentCount = array();
            $incidentclosedVessleCount = array();
            $incidentopenStatusCount = array();
            $typeofcaausecountvesslewise = array();
            //Find Number of incident for particular Vessel
            $ship_typeofcuaselist = array();
            for ($shipCount = 0; $shipCount <count($vesselname); $shipCount++) {
                array_push($vesselList, $vesselname[$shipCount][0]['shipName']);
                $incidentCountByIncidentWiseWithVesselWise = array();
                if ($shipCount > count($graphRecord) - 1) {
                    array_push($vesselwiseincidentCount, 0);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                } else {
                    array_push($vesselwiseincidentCount, (int)$graphRecord[$shipCount]['shipWiseCount']);
                    for ($j = 0; $j < count($typeofCauselist); $j++) {
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
                            ->setParameter('ship_id', $vesselname[$shipCount][0]['id'])
                            ->setParameter('currentYear', $currentYear)
                            ->setParameter('typeofIncdientId', $typeofCauselist[$j]['id'])
                            ->getQuery()
                            ->getResult();
                        array_push($incidentCountByIncidentWiseWithVesselWise, $incidentCountByIncidentWiseQuery[0]['typeofcauseCount']);
                    }
                }

                array_push($typeofcaausecountvesslewise, array_sum($incidentCountByIncidentWiseWithVesselWise));
                array_push($ship_typeofcuaselist, $incidentCountByIncidentWiseWithVesselWise);
            }
        }

        $pdfObject = $this->container->get('tfox.mpdfport')->getMPdf();
        $pdfObject->defaultheaderline = 0;
        $pdfObject->defaultheaderfontstyle = 'B';
        $severityGraphObject = array(
            'chart' => array('renderTo' => 'areaId', 'type' => "column"),
            'exporting' => array('enabled' => false),
            'plotOptions' => array('column' => array(
                "pointPadding"=> 0.2,
                "borderWidth"=> 0,
            )),
            'title'=> array('text'=> ''),

            'tooltip' =>array('shadow'=>false, 'borderWidth'=> 0,),



            'series' => array(
                array('name' => 'severity','data' =>$typeofcaausecountvesslewise),

            ),
            'subtitle' => array('style' => array('color' => '#0000f0', 'fontWeight' => 'bold')),
            'xAxis' => array('categories' => $vesselListObject,'crosshair'=> true),
            'yAxis' => array('text' => '', 'min' => 0)

        );
        $kpiJsonFileData = json_encode($severityGraphObject);
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-', 0777, true);
        }

        $phantomJsLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/bin/phantomjs ';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-', 0777, true);
        }
        $kpiJsonFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'  . $todayDate . $todayTime . '.json';
        file_put_contents($kpiJsonFilePath, $kpiJsonFileData);
        $kpiHighChartLocation = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/highcharts-convert.js ';
        $kpiInFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofjsonfiles/KPI-'. $todayDate . $todayTime . '.json ';
        $kpiOutFile = $this->container->getParameter('kernel.root_dir') . '/../web/phantomjs/listofgraph/KPI-' .  $todayDate . $todayTime . '.png ';
        $kpiImageGeneration = $phantomJsLocation . $kpiHighChartLocation . '-infile ' . $kpiInFile . '-outfile ' . $kpiOutFile . ' -scale 2.5 -width 1024';
        $kpiFileHandle = popen($kpiImageGeneration, 'r');
        $kpiResult = fread($kpiFileHandle, 2096);


        $customerListDesign = $this->renderView('VesselBundle:Default:severitypdf.html.twig', array(
            'totalnoIncidnets' => array_sum($vesselwiseincidentCount), 'currentYear' => $currentYear,'vesselListObject'=> $vesselListObject,
            'graphData' => $vesselwiseincidentCount, 'incidentclosedVessleCount' => $incidentclosedVessleCount,
            'incidentopenStatusCount' => $incidentopenStatusCount, 'serverityClassfication' => $serverityClassfication[0]['countValue'],
            'typeofIncidentWiseIncidents' => $typeofincidentCountarray, 'typeofCausewiseIncident' => $incidentCountbyTypeofCause,
            'typeofCauseList' => $typeofCauselist, 'vesselwisetypeofcause' => $ship_typeofcuaselist, 'typeofcaausecountvesslewise' => $typeofcaausecountvesslewise,'vessel'=>$vesselname,'incidentCount'=>$incidentCount,
            'incidentClosed'=>$incidentClosed,'incidentOpened'=>$incidentOpened,'imageSource' => 'KPI-' .  $todayDate . $todayTime . '.png ',
        ));
        $pdfObject->AddPage('', 4, '', 'on');
        $pdfObject->SetFooter('|{DATE l jS F Y h:i}| Page No: {PAGENO}');
        $pdfObject->WriteHTML($customerListDesign,0777,true);

        $content = $pdfObject->Output('', 'S');
        $fileName = 'pdfReport' . date('Y-m-d H-i-s') . '.pdf';
        if (!is_dir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/')) {
            mkdir($this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/', 0777, true);
        }
        $pdfFilePath = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/brochures/' . $fileName;
        file_put_contents($pdfFilePath, $content);
        $userMailId = $request->request->get('clientMail');
        $commentBox = $request->request->get('textboxvalue');
        $mailidarray = array();
        if (filter_var($userMailId, FILTER_VALIDATE_EMAIL)) {
            array_push($mailidarray, $usermail);
            $mailer = $this->container->get('mailer');
            $message = \Swift_Message::newInstance()
                ->setFrom('starshipping123@gmail.com')
                ->setTo($userMailId)
                ->setSubject('incidentwise report graph')
                ->setBody($commentBox);
            $message->attach(\Swift_Attachment::fromPath($pdfFilePath)->setFilename($fileName . '.pdf'));
            $mailer->send($message);
        } else {
            $findmail = $em->createQueryBuilder()
                ->select('a.useremailid')
                ->from('VesselBundle:EmailUsers', 'a')
                ->join('VesselBundle:EmailGroup', 'b', 'WITH', 'b.id = a.groupid')
                ->where('b.groupname = :groupname')
                ->ORwhere('a.useremailid = :mailid')
                ->setParameter('groupname', $userMailId)
                ->setParameter('mailid', $userMailId)
                ->getQuery()
                ->getResult();
            for ($i = 0; $i < count($findmail); $i++) {
                $mailer = $this->container->get('mailer');
                $message = \Swift_Message::newInstance()
                    ->setFrom('starshipping123@gmail.com')
                    ->setTo($findmail[$i]['useremailid'])
                    ->setSubject('incidentwise report graph')
                    ->setBody($commentBox);
                $message->attach(\Swift_Attachment::fromPath($pdfFilePath)->setFilename($fileName . '.pdf'));
                $mailer->send($message);
                array_push($mailidarray, $findmail[$i]['useremailid']);
            }

        }
        $response = new JsonResponse();
        $response->setData(array('updatemsg' => "Report has been send"));
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