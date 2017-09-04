<?php

namespace RankingBundle\Controller;

use RankingBundle\Entity\RankingRulesDetails;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * RankingRulesDetailsController.
 * @Route("/ranking_rules")
 */
class RankingRulesDetailsController extends Controller
{
    /**
     * Add Ranking Rules
     * @Rest\Post("/add_rules",name="add_rules")
     */
    public function addRulesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rules = $request->request->get('createdRules');
        $rules_order = $request->request->get('createRulesFieldOrder');
        $kpiDetailsId = $request->request->get('kpi_id');
        $elementDetailsId = $request->request->get('element_id');

        $kpiDetailsIdObj = $this->getDoctrine()->getManager()->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('id' =>  $kpiDetailsId));
        $elementDetailsIdObj = $this->getDoctrine()->getManager()->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' =>  $elementDetailsId));

        if($rules) {
            for($i=0;$i<count($rules);$i++) {
                $rankingRulesDetails = new RankingRulesDetails();
                $rankingRulesDetails->setRules(json_encode($rules[$i]));
                $rankingRulesDetails->setRulesOrder(json_encode($rules_order[$i]));
                $rankingRulesDetails->setKpiDetailsId($kpiDetailsIdObj);
                $rankingRulesDetails->setElementDetailsId($elementDetailsIdObj);
                $rankingRulesDetails->setCreatedDateTime();

                $em->persist($rankingRulesDetails);
                $em->flush();
            }
        }

        return true;
    }

    /**
     * Edit Ranking Rules
     * @Rest\Post("/edit_rules",name="edit_rules")
     */
    public function editRulesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rules = $request->request->get('createdRules');
        $rules_order = $request->request->get('createRulesFieldOrder');
        $kpiDetailsId = $request->request->get('kpi_id');
        $elementDetailsId = $request->request->get('element_id');

        $kpiDetailsIdObj = $this->getDoctrine()->getManager()->getRepository('RankingBundle:RankingKpiDetails')->findOneBy(array('id' =>  $kpiDetailsId));
        $elementDetailsIdObj = $this->getDoctrine()->getManager()->getRepository('RankingBundle:RankingElementDetails')->findOneBy(array('id' =>  $elementDetailsId));

        $rulesIdQuery = $em->createQueryBuilder()
            ->select('a.id')
            ->from('RankingBundle:RankingRulesDetails', 'a')
            ->where('a.elementDetailsId = :element_id ')
            ->setParameter('element_id', $elementDetailsId)
            ->getQuery()
            ->getResult();

        if(count($rulesIdQuery) == count($rules)) {

            for($i=0; $i<count($rulesIdQuery); $i++) {
                $rulesDetailsObj=$em->getRepository('RankingBundle:RankingRulesDetails')->find(array('id'=>$rulesIdQuery[$i]['id']));
                $rulesDetailsObj->setRules(json_encode($rules[$i]));
                $rulesDetailsObj->setRulesOrder(json_encode($rules_order[$i]));
                $rulesDetailsObj->setKpiDetailsId($kpiDetailsIdObj);
                $rulesDetailsObj->setElementDetailsId($elementDetailsIdObj);
                $rulesDetailsObj->setUpdatedDateTime();

                $em->flush();
            }

        } else if(count($rulesIdQuery) > count($rules)) {

            for($i=0; $i<count($rulesIdQuery); $i++) {
                $rulesDetailsObj=$em->getRepository('RankingBundle:RankingRulesDetails')->find(array('id'=>$rulesIdQuery[$i]['id']));

                if(count($rules) > $i) {
                    $rulesDetailsObj->setRules(json_encode($rules[$i]));
                    $rulesDetailsObj->setRulesOrder(json_encode($rules_order[$i]));
                    $rulesDetailsObj->setKpiDetailsId($kpiDetailsIdObj);
                    $rulesDetailsObj->setElementDetailsId($elementDetailsIdObj);
                    $rulesDetailsObj->setUpdatedDateTime();

                    $em->flush();
                } else {
                    $em->remove($rulesDetailsObj);
                    $em->flush();
                }
            }

        } else if(count($rulesIdQuery) < count($rules)) {

            for($i=0; $i<count($rules); $i++) {

                if(count($rulesIdQuery) > $i) {
                    $rulesDetailsObj=$em->getRepository('RankingBundle:RankingRulesDetails')->find(array('id'=>$rulesIdQuery[$i]['id']));

                    $rulesDetailsObj->setRules(json_encode($rules[$i]));
                    $rulesDetailsObj->setRulesOrder(json_encode($rules_order[$i]));
                    $rulesDetailsObj->setKpiDetailsId($kpiDetailsIdObj);
                    $rulesDetailsObj->setElementDetailsId($elementDetailsIdObj);
                    $rulesDetailsObj->setUpdatedDateTime();

                    $em->flush();
                } else {
                    $rankingRulesDetails = new RankingRulesDetails();
                    $rankingRulesDetails->setRules(json_encode($rules[$i]));
                    $rankingRulesDetails->setRulesOrder(json_encode($rules_order[$i]));
                    $rankingRulesDetails->setKpiDetailsId($kpiDetailsIdObj);
                    $rankingRulesDetails->setElementDetailsId($elementDetailsIdObj);
                    $rankingRulesDetails->setCreatedDateTime();

                    $em->persist($rankingRulesDetails);
                    $em->flush();
                }
            }
        }

        return true;
    }

    /**
     * Get created ranking rules details
     * @Rest\Get("/get_rules_details",name="get_rules_details")
     */
    public function getRulesDetailsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $rulesDetailQuery = $em->createQueryBuilder()
            ->select('a.id, identity(a.kpiDetailsId), identity(a.elementDetailsId), a.createdDateTime')
            ->from('RankingBundle:RankingRulesDetails', 'a')
            ->groupby('a.elementDetailsId')
            ->getQuery()
            ->getResult();

        $rulesDetailArray = array();
        if(count($rulesDetailQuery)>0) {
            foreach($rulesDetailQuery as $rule) {

                $elementDetail = $em->createQueryBuilder()
                    ->select('a.elementName')
                    ->from('RankingBundle:RankingElementDetails', 'a')
                    ->where('a.id = :element_id ')
                    ->setParameter('element_id', $rule['2'])
                    ->getQuery()
                    ->getResult();

                $kpiDetail = $em->createQueryBuilder()
                    ->select('a.kpiName, a.kpiStatusValue')
                    ->from('RankingBundle:RankingKpiDetails', 'a')
                    ->where('a.id = :kpi_id ')
                    ->setParameter('kpi_id', $rule['1'])
                    ->getQuery()
                    ->getResult();

                $status = '';
                if($kpiDetail[0]['kpiStatusValue'] == 1) $status = 'Ranking';
                if($kpiDetail[0]['kpiStatusValue'] == 2) $status = 'Scorecard';
                if($kpiDetail[0]['kpiStatusValue'] == 3) $status = 'Both';

                $result = array(
                    'id' => $rule['2'],
                    'element' => $elementDetail[0]['elementName'],
                    'kpi' => $kpiDetail[0]['kpiName'],
                    'status' => $status,
                    'created_at' => $rule['createdDateTime']->format('Y-M-d')
                );
                array_push($rulesDetailArray, $result);
            }
        }
        $response = new Response($this->serialize(['rules' => $rulesDetailArray]), Response::HTTP_CREATED);
        return $this->setBaseHeaders($response);
    }

    /**
     * Get created ranking rules
     * @Rest\Post("/get_rules",name="get_rules")
     */
    public function getRulesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');

        $rulesDetailQuery = $em->createQueryBuilder()
            ->select('a.id, a.rules, a.rulesOrder, identity(a.kpiDetailsId), identity(a.elementDetailsId)')
            ->from('RankingBundle:RankingRulesDetails', 'a')
            ->where('a.elementDetailsId = :element_id ')
            ->setParameter('element_id', $id)
            ->getQuery()
            ->getResult();

        $typeQuery = $em->createQueryBuilder()
            ->select('a.kpiStatusValue')
            ->from('RankingBundle:RankingKpiDetails', 'a')
            ->where('a.id = :kpi_id ')
            ->setParameter('kpi_id', $rulesDetailQuery[0]['1'])
            ->getQuery()
            ->getResult();

        $response = new Response($this->serialize(['rules' => $rulesDetailQuery, 'status' =>  $typeQuery[0]['kpiStatusValue']]), Response::HTTP_CREATED);
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
