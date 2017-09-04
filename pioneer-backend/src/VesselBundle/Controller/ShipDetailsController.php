<?php
namespace VesselBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\Form\FormInterface;
use VesselBundle\Entity\Shipdetails;
use UserBundle\Util\CommonFunctions;
use JMS\Serializer\SerializationContext;
use VesselBundle\Entity\ShipStatusDetails;

/**
 * DefaultController.
 * @Route("/secure")
 */
class ShipDetailsController extends Controller
{


    /**
     * @Rest\Post("/Create_Vessel",name="CreateVessel")
     */
    public function createShipAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$params = $request->request->get('ShipDetails');
        $requestContent=json_decode($request->getContent(),true);
        $companyDetails=$requestContent['currentuser'];
        $shipDetails=$requestContent['vesselobject'];
        $shipName =  $shipDetails['shipName'];
        $shipType =  $shipDetails['ShipType'];
        $imoNumber =  $shipDetails['IMONumber'];
        $country =  $shipDetails['Country'];
        $location =  $shipDetails['Location'];
        $description = $shipDetails['Description'];
        $manufacturingYear =  $shipDetails['Manufacturingyear'];
        $built = $shipDetails['ShipYard'];
        $size =  $shipDetails['LengthOverall'];
        $gt =  $shipDetails['Gt'];
        $create_date = new \DateTime();
        $user_id=$companyDetails['id'];
        $shipdetails = new \VesselBundle\Entity\Shipdetails();
        $country_value = $this->getDoctrine()->getManager()->getRepository('VesselBundle:AppsCountries')->findOneBy(array('id' =>  $country));
        $vessel_type = $this->getDoctrine()->getManager()->getRepository('VesselBundle:ShipTypes')->findOneBy(array('id' =>  $shipType));

        $check_imonumber = $em->createQueryBuilder()
            ->select('a.id', 'a.imoNumber')
            ->from('VesselBundle:Shipdetails', 'a')
            ->where('a.imoNumber = :imo_number')
            ->setParameter('imo_number', $imoNumber)
            ->getQuery();
        $imo_Number = $check_imonumber->getResult();

        if(count($imo_Number)!=0) {
            $response = new Response($this->serialize(['imomsg' => 'Imonumber already registered!']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

        $query = $em->createQueryBuilder()
            ->select('a.id', 'a.shipName')
            ->from('VesselBundle:Shipdetails', 'a')
            ->where('a.shipName = :Ship_name')
            ->setParameter('Ship_name', $shipName)
            ->getQuery();
        $ShipDetail = $query->getResult();

        //$response = new JsonResponse();
        if(count($ShipDetail)!=0) {
            $response = new Response($this->serialize(['resmsg' => 'shipname already registered!']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }
        else {


            $shipdetails->setshipName($shipName);
            $shipdetails->setshipType($vessel_type);
            $shipdetails->setimoNumber($imoNumber);
            $shipdetails->setcountry($country_value);
            $shipdetails->setlocation($location);
            $shipdetails->setdescription($description);
            $shipdetails->setbuilt($built);
            $shipdetails->setsize($size);
            $shipdetails->setgt($gt);
            $shipdetails->setCreatedDate();

            if ($companyDetails['company_id'] != '') {
                $shipdetails->setcompanyName($companyDetails['company_id']);
            } else {
                $em = $this->getDoctrine()->getManager();
                $user = $em->createQueryBuilder()
                    ->select('a.companyname')
                    ->from('UserBundle:CompanyUsers', 'a')
                    ->where('a.userId = :comp_id')
                    ->setParameter('comp_id', $user_id)
                    ->getQuery();
                $Shipdetail = $user->getResult();
                $company_name = $Shipdetail[0]['companyname'];

                $shipdetails->setcompanyName($company_name);
            }
            $shipdetails->setmanufacturingYear($manufacturingYear);

            $em->persist($shipdetails);
            $em->flush();

            $ship_id = $shipdetails->getId();
            $today = date("Y-m-d H:i:s");
            $today_obj = date_create($today);

            $shipstatusdetails = new ShipStatusDetails();
            $shipstatusdetails->setShipDetailsId($this->getDoctrine()->getManager()->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' => $ship_id)));
            $shipstatusdetails->setActiveDate($today_obj);
            $shipstatusdetails->setStatus(1);
            $em->persist($shipstatusdetails);
            $em->flush();


            $response = new JsonResponse();
            $response = new Response($this->serialize(['created' => 'ship created successfully!']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);
        }
        return $response;
    }

    /**
     * @Rest\post("/Show_allships",name="Show_Ships")
     */

    public function Show_AllshipsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $pageNumber = $request->request->get('pageNumber');
        $records_per_page = $request->request->get('recordsperPage');
        $query = $em->createQueryBuilder()
            ->select('a.id', 'a.shipName', 'a.description', 'a.location', 'a.size', 'a.built', 'a.gt', 'a.manufacturingYear', 'a.imoNumber', 'a.built')
            ->from('VesselBundle:Shipdetails', 'a')
            ->getQuery();
        $Shipdetail = $query->getResult();
        $query = $em->createQueryBuilder()
            ->select('a')
            ->from('VesselBundle:Shipdetails', 'a')
            ->getQuery();

        $shipDetails = $query->getResult();
        $count = count($shipDetails);
        $last_page = ceil($count / $records_per_page);
        $previous_page = $pageNumber > 1 ? $pageNumber - 1 : 1;
        $next_page = $pageNumber < $last_page ? $pageNumber + 1 : $last_page;
        $shipListvalues = $em->createQueryBuilder()
            ->select('a.id', 'a.shipName', 'a.description', 'a.location', 'a.size', 'a.built', 'a.gt', 'a.manufacturingYear', 'a.imoNumber', 'a.built')
            ->from('VesselBundle:Shipdetails', 'a')
            ->setMaxResults($records_per_page)
            ->setFirstResult(($pageNumber - 1) * $records_per_page)
            ->getQuery()
            ->getResult();

        $shipStatus = array();
        for ($shipCount = 0; $shipCount < $count; $shipCount++) {
            $shipId = $shipDetails[$shipCount]->getId();
            $shipStatusQuery = $em->createQueryBuilder()
                ->select('a.status')
                ->from('VesselBundle:ShipStatusDetails', 'a')
                ->where('a.shipDetailsId = :ship_id')
                ->setParameter('ship_id', $shipId)
                ->groupby('a.id')
                ->getQuery()
                ->getResult();

            if (count($shipStatusQuery) != 0) {
                if ((int)$shipStatusQuery[count($shipStatusQuery) - 1]['status'] == 1) {
                    array_push($shipStatus, 1);
                } else {
                    array_push($shipStatus, 0);
                }
            } else {
                array_push($shipStatus, 0);
            }
        }

        $response = new Response($this->serialize(['shipcountList' => $shipListvalues,'shipStatus' => $shipStatus,
            'totalRecords'=>$count,'last_page' => $last_page,
            'previous_page' => $previous_page, 'current_page' => (int)$pageNumber,
            'next_page' => $next_page]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);


    }

    /**
     * @Rest\post("/Show_ships",name="Showship")
     */

    public function ShowshipsAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $shipdetails = new \VesselBundle\Entity\Shipdetails();
        $ship_id = $request->request->get('typevalue');
        $query = $em->createQueryBuilder()
            ->select('a.id', 'a.shipName', 'a.description', 'a.location', 'a.size', 'a.built', 'a.gt', 'a.manufacturingYear','a.imoNumber', 'a.built','identity(a.shipType) as shipType','identity(a.country) as country')
            ->from('VesselBundle:Shipdetails', 'a')
            ->where('a.id = :shipid')
            ->setParameter('shipid', $ship_id)
            ->getQuery();
        $Shipdetail = $query->getResult();

        $response = new JsonResponse($Shipdetail);

        return $response;
    }

    /**
     * @Rest\post("/Ship_types",name="shipTypes")
     */

    public function ship_typesAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $ship_id = $request->request->get('typevalue');
        $shipTypeId = $em->createQueryBuilder()
            ->select('identity(a.shipType)')
            ->from('VesselBundle:Shipdetails', 'a')
            ->where('a.id = :Ship_id')
            ->setParameter('Ship_id', $ship_id)
            ->getQuery()
            ->getResult();

        $shipTypeName = $em->createQueryBuilder()
            ->select('a.shipType', 'a.id')
            ->from('VesselBundle:ShipTypes', 'a')
            ->where('a.id = :Ship_id')
            ->setParameter('Ship_id', $shipTypeId[0][1])
            ->getQuery()
            ->getResult();

        $response = new JsonResponse($shipTypeName);
        return $response;

    }


    /**
     * @Rest\Get("/Show_countries",name="app_countries")
     */

    public function countriesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $countryName_array = $em->createQueryBuilder()
                ->select('a.countryName', 'a.id')
                ->from('VesselBundle:AppsCountries', 'a')
                ->getQuery();
        $detail = $countryName_array->getResult();

        $response = new JsonResponse($detail);
        return $response;

    }
    /**
     * @Rest\Get("/Show_vessel_types",name="Vessel_types")
     */

    public function VesselTypeAction(){
        $em = $this->getDoctrine()->getManager();
        $ship_Type = $em->createQueryBuilder()
            ->select('a.shipType', 'a.id')
            ->from('VesselBundle:ShipTypes', 'a')
            ->getQuery();
        $vessel_detail = $ship_Type->getResult();

        $response = new JsonResponse($vessel_detail);
        return $response;

    }

    /**
     * @Rest\Post("/Show_shipStatus",name="ship_status")
     */

    public function ship_statusAction(Request $request){

        $today = date("Y-m-d H:i:s");
        $today_obj = date_create($today);
        $em = $this->getDoctrine()->getManager();
        $shipdetails = new \VesselBundle\Entity\Shipdetails();
        //$data = json_decode($request->getContent());
        $data = $request->request->get('shiptypevalue');

        $shipname=$em->createQueryBuilder()
                 ->select('a.shipName')
                  ->from('VesselBundle:Shipdetails', 'a')
                  ->where('a.id = :shipid')
                  ->setParameter('shipid',$data)
                  ->getQuery();
        $vesselname = $shipname->getResult();
        $shipnamestatus= $vesselname[0]['shipName'];
        $ship_status = $em->createQueryBuilder()
            ->select('a.status')
            ->from('VesselBundle:ShipStatusDetails', 'a')
            ->where('a.shipDetailsId = :ship_id')
            ->setParameter('ship_id', $data)
            ->groupby('a.id')
            ->getQuery()
            ->getResult();
        $index = count($ship_status) - 1;
        $shipStatusDetails = new ShipStatusDetails();
        $responseStatus='';
        if (count($ship_status) != 0) {
            if ($ship_status[$index]['status'] == 1) {
                $shipStatusDetails->setShipDetailsId($this->getDoctrine()->getManager()->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  $data)));
                $shipStatusDetails->setEndDate($today_obj);
                $shipStatusDetails->setStatus(0);
                $em->persist($shipStatusDetails);
                $responseStatus=false;
                $shipvalue=$shipnamestatus .' Deactivated';
                $em->flush();

            } else {
                $shipStatusDetails->setShipDetailsId($this->getDoctrine()->getManager()->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' =>  $data)));
                $shipStatusDetails->setActiveDate($today_obj);
                $shipStatusDetails->setStatus(1);
                $em->persist($shipStatusDetails);
                $responseStatus=true;
                $shipvalue=$shipnamestatus .' Activated';
                $em->flush();
                $response = new Response($this->serialize(['userStatus'=>$responseStatus,'shipStatus'=>$shipvalue]), Response::HTTP_CREATED);
                return $this->setBaseHeaders($response);


            }
        }
        $response = new Response($this->serialize(['userStatus'=>$responseStatus,'shipStatus'=>$shipvalue]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);

    }

    /**
     * @Rest\Post("/update_ship",name="update_Vessel")
     */

    public function ship_updateAction(Request $request)
    {

        $id=$request->get('id');
        $shipName = $request->get('shipName');
        $shipType = $request->get('shipType');
        $imoNumber = $request->get('imoNumber');
        $country = $request->get('country');
        $location = $request->get('location');
        $description = $request->get('description');
        $manufacturingYear = $request->get('manufacturingYear');
        $built = $request->get('built');
        $size = $request->get('size');
        $gt = $request->get('gt');
        $em = $this->getDoctrine()->getManager();
        $shipDetail = $em->getRepository('VesselBundle:Shipdetails')->findOneBy(array('id' => $id));
        $country_value = $this->getDoctrine()->getManager()->getRepository('VesselBundle:AppsCountries')->findOneBy(array('id' =>  $country));
        $vessel_type = $this->getDoctrine()->getManager()->getRepository('VesselBundle:ShipTypes')->findOneBy(array('id' =>  $shipType));
//        $shipDetail = new \VesselBundle\Entity\Shipdetails();
        //$shipDetail = new Shipdetails();

        $check_imonumber = $em->createQueryBuilder()
            ->select('a.id', 'a.imoNumber')
            ->from('VesselBundle:Shipdetails', 'a')
            ->where('a.imoNumber = :imo_number')
            ->setParameter('imo_number', $imoNumber)
            ->getQuery();
        $imo_Number = $check_imonumber->getResult();

        if(count($imo_Number)!=0) {
            $response = new Response($this->serialize(['imomsg' => 'Imonumber already registered!']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);

        }

        $query = $em->createQueryBuilder()
            ->select('a.id', 'a.shipName')
            ->from('VesselBundle:Shipdetails', 'a')
            ->where('a.shipName = :Ship_name')
            ->setParameter('Ship_name', $shipName)
            ->getQuery();
        $ShipDetail = $query->getResult();


        if(count($ShipDetail)!=0) {
         /*   $response = new Response($this->serialize(['resmsg' => 'shipname already registered!']), Response::HTTP_CREATED);
            return $this->setBaseHeaders($response);*/

        }
        else {
            $shipDetail->setshipName($shipName);
            $shipDetail->setshipType($vessel_type);
            $shipDetail->setimoNumber($imoNumber);
            $shipDetail->setcountry($country_value);
            $shipDetail->setlocation($location);
            $shipDetail->setdescription($description);
            $shipDetail->setbuilt($built);
            $shipDetail->setsize($size);
            $shipDetail->setgt($gt);
            $shipDetail->setmanufacturingYear($manufacturingYear);
            $em->flush();
        }


            $response = new JsonResponse();
            $response = new Response($this->serialize(['updatemsg' => 'ship updated!']), Response::HTTP_CREATED);
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